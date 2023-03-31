import settings
from xrpl.models.requests.account_info import AccountInfo
from xrpl.core import addresscodec
from xrpl.asyncio.wallet import generate_faucet_wallet
from xrpl.wallet import Wallet
import json
import xrpl
import logging
import asyncio
from .utils import to_sha1
from .utils import memo_to_hex, memo_json_to_hex, uri_hex
from .utils import get_explorer_addr

logger = logging.getLogger(__name__)


async def generate_test_wallet():
    client = xrpl.clients.JsonRpcClient(settings.XRP_TESTNET_URL)
    cold_wallet = await generate_faucet_wallet(client, debug=True)
    issuer_addr = cold_wallet.classic_address
    issuer_explorer = get_explorer_addr(issuer_addr)
    return {
        "wallet_addr": issuer_addr,
        "explorer_url": issuer_explorer,
        "pub_key": cold_wallet.public_key,
        "priv_key": cold_wallet.private_key,
        "seed": cold_wallet.seed,
        "seq": cold_wallet.sequence,
    }


def parse_wallet(wallet_classic_addr, is_test_network=True):
    client = xrpl.clients.JsonRpcClient(settings.XRP_TESTNET_URL)
    try:
        xaddress = addresscodec.classic_address_to_xaddress(
            wallet_classic_addr, tag=12345, is_test_network=is_test_network)
        acct_info = AccountInfo(
            account=wallet_classic_addr,
            ledger_index="validated",
            strict=True,
        )
        response = client.request(acct_info)
        resultJson = json.loads(json.dumps(
            response.result, indent=4, sort_keys=True))
        resultJson["xaddress"] = xaddress
        return resultJson
    except:
        return {
            "status": "error",
            "msg": "Invalid Wallet"
        }


def get_wallet(wallet_address, wallet_sequence):
    client = xrpl.clients.JsonRpcClient(settings.XRP_TESTNET_URL)
    test_wallet = Wallet(
        seed="snisFjQoYt6WUyfqd66HJdUy96uFk", sequence=36172244)
    print(test_wallet)
    return {
        "wallet_addr": "",
        "explorer_url": ""
    }


async def get_transaction_hash_details(trans_hash):
    client = xrpl.asyncio.clients.AsyncJsonRpcClient(
        settings.XRP_TESTNET_URL)
    result = await xrpl.asyncio.transaction.get_transaction_from_hash(trans_hash, client)
    return result


async def mint_nft(data, husecure_wallet, client_wallet, should_use_test_net=True):

    if data and data['file_uri'] and data['file_hash'] and data["title"] and husecure_wallet and husecure_wallet["seed"] and husecure_wallet["seq"] and client_wallet and client_wallet["seed"] and client_wallet["seq"]:
        print("Ok")

        title = data["title"]
        metadata_uri = data["metadata_uri"]

        # Set NTF variables
        FILE_URL = data["file_uri"]
        FILE_HASH = data["file_hash"]
        META_URL = data["metadata_uri"]

        # Compute the variables
        FILE_HASH_SHA = to_sha1(FILE_HASH)
        MEMO_DATA_HEX = uri_hex(FILE_URL)

        issue_quantity = data["nft_trans_quantity"]

        logger.info("> Minting NFT for title {} and metadata_uri {}".format(
            title, metadata_uri))

        # Defaults
        issuer_addr = "Not set"
        distributor_addr = "Not set"
        issued_token_link = "Not set"

        # Connect to xrp server
        if should_use_test_net:
            client = xrpl.asyncio.clients.AsyncJsonRpcClient(
                settings.XRP_TESTNET_URL)

        # 1: Get credentials
        logger.info(
            "> Getting new issuer and distributer accounts from the Testnet faucet...")

        client_wallet_obj = xrpl.wallet.Wallet(
            client_wallet["seed"], int(client_wallet["seq"]))
        hubsecure_wallet_obj = xrpl.wallet.Wallet(
            husecure_wallet["seed"], int(husecure_wallet["seq"]))

        issuer_addr = client_wallet_obj.classic_address
        issuer_explorer = get_explorer_addr(issuer_addr)
        logger.info("> Issuer wallet classic address {}, seed {}, and sequence {}".format(
            client_wallet_obj.classic_address, client_wallet_obj.seed, client_wallet_obj.sequence))
        distributor_addr = hubsecure_wallet_obj.classic_address
        distributor_explorer = get_explorer_addr(distributor_addr)
        logger.info("> Distributer wallet classic address {}, seed {}, and sequence {}".format(
            hubsecure_wallet_obj.classic_address, hubsecure_wallet_obj.seed, hubsecure_wallet_obj.sequence))

        # Configure issuer (cold address) settings
        cold_settings_tx = xrpl.models.transactions.AccountSet(
            account=client_wallet_obj.classic_address,
            transfer_rate=0,
            tick_size=5,
            domain=bytes.hex(META_URL.encode("ASCII")),
            set_flag=xrpl.models.transactions.AccountSetFlag.ASF_DEFAULT_RIPPLE,  # OR set it to 8
        )
        cst_prepared = await xrpl.asyncio.transaction.safe_sign_and_autofill_transaction(
            transaction=cold_settings_tx,
            wallet=client_wallet_obj,
            client=client,
        )
        logger.info("> Sending issuer address AccountSet transaction...")
        response = await xrpl.asyncio.transaction.send_reliable_submission(cst_prepared, client)
        # print(response)

        # Configure hot address settings
        hot_settings_tx = xrpl.models.transactions.AccountSet(
            account=hubsecure_wallet_obj.classic_address,
            set_flag=xrpl.models.transactions.AccountSetFlag.ASF_REQUIRE_AUTH,
        )
        hst_prepared = await xrpl.asyncio.transaction.safe_sign_and_autofill_transaction(
            transaction=hot_settings_tx,
            wallet=hubsecure_wallet_obj,
            client=client,
        )
        logger.info("> Sending distributor address AccountSet transaction...")
        response = await xrpl.asyncio.transaction.send_reliable_submission(hst_prepared, client)
        # print(response)

        # STEP TWO: Create trust line from hot to cold address
        currency_code = FILE_HASH_SHA
        trust_set_tx = xrpl.models.transactions.TrustSet(
            account=hubsecure_wallet_obj.classic_address,
            limit_amount=xrpl.models.amounts.issued_currency_amount.IssuedCurrencyAmount(
                currency=currency_code,
                issuer=client_wallet_obj.classic_address,
                value=issue_quantity,  # Large limit, arbitrarily chosen -- 10000000000
            )
        )
        ts_prepared = await xrpl.asyncio.transaction.safe_sign_and_autofill_transaction(
            transaction=trust_set_tx,
            wallet=hubsecure_wallet_obj,
            client=client,
        )
        logger.info(
            "> Creating trust line from distributer address to issuer...")
        response = await xrpl.asyncio.transaction.send_reliable_submission(ts_prepared, client)
        # print(response)

        # STEP THREE: Issue token -------------------------------------------------------------------
        logger.info("> Prepare token {}...".format(FILE_HASH_SHA))

        send_token_tx = xrpl.models.transactions.NFTokenMint(
            account=client_wallet_obj.classic_address,
            transfer_fee=int(data["transfer_fee"]),
            nftoken_taxon=0,
            flags=8,
            fee=data["fee"],
            uri=MEMO_DATA_HEX,
            memos=[xrpl.models.transactions.Memo(
                memo_data=memo_json_to_hex(data["enc_data"])
            )]
        )
        # logger.info("> Payment object: {}".format(send_token_tx))

        pay_prepared = await xrpl.asyncio.transaction.safe_sign_and_autofill_transaction(
            transaction=send_token_tx,
            wallet=client_wallet_obj,
            client=client,
        )
        logger.info("> Sending {} NFT: {} to {}...".format(
            issue_quantity, currency_code, hubsecure_wallet_obj.classic_address))
        response = await xrpl.asyncio.transaction.send_reliable_submission(pay_prepared, client)
        # print(response)

        tx_id = pay_prepared.get_hash()
        issued_token_link = settings.XRP_TESTNET_EXPLORER+"/transactions/"+tx_id
        logger.info("> Issue token transaction details: {}".format(
            issued_token_link))

        # # Check balances ---------------------------------------------------------------
        # logger.info("> Getting distributer address balances...")
        # hub_bal_response = await client.request(xrpl.models.requests.AccountLines(
        #     account=hubsecure_wallet_obj.classic_address,
        #     ledger_index="validated",
        # ))
        # # print(response)

        # logger.info("> Getting issuer address balances...")
        # client_bal_response = await client.request(xrpl.models.requests.GatewayBalances(
        #     account=client_wallet_obj.classic_address,
        #     ledger_index="validated",
        #     hotwallet=[hubsecure_wallet_obj.classic_address]
        # ))
        # # print(response)

        return {
            "status": "ok",
            "data": {
                "distributor": hubsecure_wallet_obj.classic_address,
                "issued_token": tx_id,
                "issued_token_link": issued_token_link,
                "issued_for": client_wallet_obj.classic_address,
                "fee": data["fee"],
                "transfer_fee": data["transfer_fee"]
            }

        }
    else:
        return {
            "status": "error",
            "msg": "Something went wrong"
        }

# async def nft_test():
#     client = xrpl.asyncio.clients.AsyncJsonRpcClient(settings.XRP_TESTNET_URL)

#     cold_wallet = xrpl.wallet.Wallet(
#         "sEdS7Xf8abA1hmUPzsFNGzYSBaZdCo4", 36191203)
#     hot_wallet = xrpl.wallet.Wallet(
#         "sEdTsxgEsgatzanLPKA6vJcTeFwSom2", 36191320)

#     FILE_URL = "http://test.com"
#     FILE_HASH = ""
#     META_URL = "http://test2.com"
#     FILE_HASH_SHA = "fd5fce11f002fea1dcc4c8aa492a1ae68590b4d5".upper()
#     issue_quantity = NFT_QUANTITY
#     MEMO_DATA_HEX = memo_to_hex(FILE_URL, META_URL)

#     # Configure issuer (cold address) settings -------------------------------------
#     cold_settings_tx = xrpl.models.transactions.AccountSet(
#         account=cold_wallet.classic_address,
#         transfer_rate=0,
#         tick_size=5,
#         domain=bytes.hex(META_URL.encode("ASCII")),
#         set_flag=xrpl.models.transactions.AccountSetFlag.ASF_DEFAULT_RIPPLE,  # OR set it to 8
#     )
#     cst_prepared = await xrpl.asyncio.transaction.safe_sign_and_autofill_transaction(
#         transaction=cold_settings_tx,
#         wallet=cold_wallet,
#         client=client,
#     )
#     print("\nSending issuer address AccountSet transaction...")
#     response = await xrpl.asyncio.transaction.send_reliable_submission(cst_prepared, client)
#     print(response)

#     # Configure hot address settings -----------------------------------------------
#     hot_settings_tx = xrpl.models.transactions.AccountSet(
#         account=hot_wallet.classic_address,
#         set_flag=xrpl.models.transactions.AccountSetFlag.ASF_REQUIRE_AUTH,
#     )
#     hst_prepared = await xrpl.asyncio.transaction.safe_sign_and_autofill_transaction(
#         transaction=hot_settings_tx,
#         wallet=hot_wallet,
#         client=client,
#     )
#     print("\nSending distributor address AccountSet transaction...")
#     response = await xrpl.asyncio.transaction.send_reliable_submission(hst_prepared, client)
#     print(response)

#     # STEP TWO: Create trust line from hot to cold address -----------------------------------
#     currency_code = FILE_HASH_SHA  # "fd5fce11f002fea1dcc4c8aa492a1ae68590b4d5".upper()
#     trust_set_tx = xrpl.models.transactions.TrustSet(
#         account=hot_wallet.classic_address,
#         limit_amount=xrpl.models.amounts.issued_currency_amount.IssuedCurrencyAmount(
#             currency=currency_code,
#             issuer=cold_wallet.classic_address,
#             value=NFT_QUANTITY,  # Large limit, arbitrarily chosen -- 10000000000
#         )
#     )
#     ts_prepared = await xrpl.asyncio.transaction.safe_sign_and_autofill_transaction(
#         transaction=trust_set_tx,
#         wallet=hot_wallet,
#         client=client,
#     )
#     print("\nCreating trust line from distributer address to issuer...")
#     response = await xrpl.asyncio.transaction.send_reliable_submission(ts_prepared, client)
#     print(response)

#     # STEP THREE: Issue token -------------------------------------------------------------------
#     issue_quantity = NFT_QUANTITY
#     print(f"\nPrepare token {FILE_HASH_SHA}...")

#     send_token_tx = xrpl.models.transactions.NFTokenMint(
#         account=cold_wallet.classic_address,
#         transfer_fee=20,
#         nftoken_taxon=0,
#         flags=8,
#         fee="10",
#         uri=memo_to_hex("http://test.com", "http://test.com"),
#         memos=[xrpl.models.transactions.Memo(
#             # memo_type = MEMO_TYPE_HEX,
#             memo_data=MEMO_DATA_HEX
#         )]
#     )
#     print("Payment object:", send_token_tx)

#     pay_prepared = await xrpl.asyncio.transaction.safe_sign_and_autofill_transaction(
#         transaction=send_token_tx,
#         wallet=cold_wallet,
#         client=client,
#     )
#     print(
#         f"\nSending {issue_quantity} NFT: {currency_code} to {hot_wallet.classic_address}...")
#     response = await xrpl.asyncio.transaction.send_reliable_submission(pay_prepared, client)
#     print(response)

#     tx_id = pay_prepared.get_hash()
#     issued_token_link = f"https://testnet.xrpl.org/transactions/{tx_id}"
#     print("\n issue token transaction details: ", issued_token_link)

#     # Check balances ---------------------------------------------------------------
#     print("\nGetting distributer address balances...")
#     response = await client.request(xrpl.models.requests.AccountLines(
#         account=hot_wallet.classic_address,
#         ledger_index="validated",
#     ))
#     print(response)

#     print("\nGetting issuer address balances...")
#     response = await client.request(xrpl.models.requests.GatewayBalances(
#         account=cold_wallet.classic_address,
#         ledger_index="validated",
#         hotwallet=[hot_wallet.classic_address]
#     ))
#     print(response)
#     return True
