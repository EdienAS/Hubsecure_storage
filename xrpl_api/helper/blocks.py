import helper.ipfs as IpfsHelper
import helper.mongo as MongoHelper
from os import getcwd
import settings
import helper.file_handler as File
import helper.hash as HashHelper
import helper.subprocess as SubProcessHelper
import helper.xrpl as XrplHelper
from starlette.responses import FileResponse
import logging
import uuid
import json
from cryptography.fernet import Fernet
logger = logging.getLogger(__name__)


PATH_FILES = getcwd() + "/temp_files/"
PATH_FILES_DOWN = getcwd() + "/temp_files/download/"


async def UploadSingleFile(data):
    upload_files = await File.UploadSingleFile(data)
    file_list = []
    try:
        upload_files['uuid'] = str(uuid.uuid1())
        upload_files['status'] = "pending"
        upload_files['db_id'] = str(await MongoHelper.insert(upload_files, "documents"))
        file_list.append(upload_files)
    except Exception as e:
        logger.error(e)
        return {"message": "There was an error Uploading the file(s)"}
        
    return json.loads(json.dumps(file_list, default=str))

async def UploadFile(data):
    upload_files = await File.UploadFile(data)
    file_list = []
    for file in upload_files:
        try:
            file['uuid'] = str(uuid.uuid1())
            file['status'] = "pending"
            file['db_id'] = str(await MongoHelper.insert(file, "documents"))
            file_list.append(file)
        except Exception as e:
            logger.error(e)
            return {"message": "There was an error Uploading the file(s)"}
    return json.loads(json.dumps(file_list, default=str))


async def block_has_downloadable_link(data):
    checkFile = await MongoHelper.find_one("documents", {"uuid": data["block_uuid"]})
    if checkFile and checkFile["download_count"] != "" and int(checkFile["download_count"]) == 0:
        return True
    else:
        return False


async def block_download(block_uuid):
    checkFile = await MongoHelper.find_one("documents", {"uuid": block_uuid})
    if checkFile and checkFile["download_count"] != "" and int(checkFile["download_count"]) == 0:
        filter = {"uuid": block_uuid}
        update = {"download_count": -2, "temp_download_file": ""}
        await MongoHelper.updateOne("documents", filter, update)
        return FileResponse(checkFile["temp_download_file"], media_type='application/octet-stream', filename=checkFile["name"])
    else:
        return {
            "status": "error",
            "msg": "File not found"
        }


async def get_document_meta(data):
    checkFile = await MongoHelper.find_one("documents", {"uuid": data["block_uuid"]})

    if checkFile and checkFile["name"]:
        if checkFile and checkFile["download_count"] != "" and int(checkFile["download_count"]) == 0:
            return {
                "status": "completed",
                "block_data": {
                    "distributor": checkFile["xrpl_nft_data"]["data"]["distributor"],
                    "issued_for": checkFile["xrpl_nft_data"]["data"]["issued_for"],
                    "transfer_fee": checkFile["xrpl_nft_data"]["data"]["transfer_fee"],
                    "fee": checkFile["xrpl_nft_data"]["data"]["fee"],
                    "nft_trans_id": checkFile["xrpl_nft_data"]["data"]["issued_token"],
                    "nft_trans_details": checkFile["xrpl_nft_data"]["data"]["issued_token_link"]
                },
                "block_uuid": data["block_uuid"],
                "document": {
                    "enc_file_hash": checkFile["ipfs_meta"]["file_hash"],
                    "enc_file_uri": checkFile["ipfs_meta"]["file_uri"],
                    "dec_file_uri": settings.APP_HOST_NAME + "/download/once/"+data["block_uuid"],
                    "file_name": checkFile["name"],
                    "file_type": checkFile["content_type"],
                    "file_size": checkFile["file_size"]
                }
            }
        else:
            return {
                "status": "processing",
                "block_data": {
                    "distributor": checkFile["xrpl_nft_data"]["data"]["distributor"],
                    "issued_for": checkFile["xrpl_nft_data"]["data"]["issued_for"],
                    "transfer_fee": checkFile["xrpl_nft_data"]["data"]["transfer_fee"],
                    "fee": checkFile["xrpl_nft_data"]["data"]["fee"],
                    "nft_trans_id": checkFile["xrpl_nft_data"]["data"]["issued_token"],
                    "nft_trans_details": checkFile["xrpl_nft_data"]["data"]["issued_token_link"]
                },
                "block_uuid": data["block_uuid"],
                "document": {
                }
            }
    else:
        return {
            "status": "error",
            "block_uuid": "Block on found."
        }


async def get_document_data(data):
    checkFile = await MongoHelper.find_one("documents", {"uuid": data["block_uuid"]})
    if checkFile and checkFile["name"]:
        try:
            thash_details = await XrplHelper.get_transaction_hash_details(checkFile["xrpl_nft_data"]["data"]["issued_token"])
            if thash_details.status == "success":

                # If download link already available
                if checkFile and checkFile["download_count"] != "" and int(checkFile["download_count"]) == 0:
                    return {
                        "status": "completed",
                        "block_data": {
                            "distributor": checkFile["xrpl_nft_data"]["data"]["distributor"],
                            "issued_for": checkFile["xrpl_nft_data"]["data"]["issued_for"],
                            "transfer_fee": checkFile["xrpl_nft_data"]["data"]["transfer_fee"],
                            "fee": checkFile["xrpl_nft_data"]["data"]["fee"],
                            "nft_trans_id": checkFile["xrpl_nft_data"]["data"]["issued_token"],
                            "nft_trans_details": checkFile["xrpl_nft_data"]["data"]["issued_token_link"]
                        },
                        "block_uuid": data["block_uuid"],
                        "document": {
                            "enc_file_hash": checkFile["ipfs_meta"]["file_hash"],
                            "enc_file_uri": checkFile["ipfs_meta"]["file_uri"],
                            "dec_file_uri": settings.APP_HOST_NAME + "/download/once/"+data["block_uuid"],
                            "file_name": checkFile["name"],
                            "file_type": checkFile["content_type"],
                            "file_size": checkFile["file_size"]
                        }
                    }

                # Else
                genClientKeyHash = str(await HashHelper.hashSimpleText(data['client']['client_encryption_key']))
                genApplicationKeyHash = str(await HashHelper.hashSimpleText(data['application']['app_encryption_key']))
                # Generate Encryption Key based on application and client key hash [Name : DeltaKey], to Encrypt AlphaKey
                genEncryptionSalt = (await HashHelper.generate_salt_from_hash(genApplicationKeyHash, genClientKeyHash))
                # Decryption sample
                retrive_memo_key = str(bytes.fromhex(
                    thash_details.result["Memos"][0]["Memo"]["MemoData"]).decode('utf-8'))
                retrive_memo_key = retrive_memo_key.replace("b'", "")
                retrive_memo_key = retrive_memo_key.replace("'\"", "\"")
                retrive_memo_key = retrive_memo_key.replace("'", "\"")
                retrive_memo_key = json.loads(retrive_memo_key)
                encode_enc_key = str(
                    retrive_memo_key["enc_data"]).encode("utf-8")
                decryptEncryptionKey = str(await HashHelper.decryptFernet(encode_enc_key, genEncryptionSalt))

                try:
                    retrive_file_uri = str(bytes.fromhex(
                        thash_details.result["URI"]).decode('utf-8'))
                    retrive_file_uri = retrive_file_uri.replace("'", "\"")
                    retrive_file_uri = json.loads(retrive_file_uri)
                    genFileLink = retrive_file_uri["file_url"]
                    getFile = await IpfsHelper.download_from_ipfs(genFileLink)
                    if not getFile:
                        return {
                            "status": "error",
                            "msg": "Could not retrive file from IPFS."
                        }
                    else:
                        decryptFile = await SubProcessHelper.uncompress_and_decrypt_file(getFile, decryptEncryptionKey, data["block_uuid"])

                        if decryptFile and decryptFile["status"] == "ok":
                            return {
                                "status": "completed",
                                "block_data": {
                                    "distributor": checkFile["xrpl_nft_data"]["data"]["distributor"],
                                    "issued_for": checkFile["xrpl_nft_data"]["data"]["issued_for"],
                                    "transfer_fee": checkFile["xrpl_nft_data"]["data"]["transfer_fee"],
                                    "fee": checkFile["xrpl_nft_data"]["data"]["fee"],
                                    "nft_trans_id": checkFile["xrpl_nft_data"]["data"]["issued_token"],
                                    "nft_trans_details": checkFile["xrpl_nft_data"]["data"]["issued_token_link"]
                                },
                                "block_uuid": data["block_uuid"],
                                "document": {
                                    "enc_file_hash": checkFile["ipfs_meta"]["file_hash"],
                                    "enc_file_uri": checkFile["ipfs_meta"]["file_uri"],
                                    "dec_file_uri": "/download/once/"+data["block_uuid"],
                                    "file_name": checkFile["name"],
                                    "file_type": checkFile["content_type"],
                                    "file_size": checkFile["file_size"]
                                }
                            }
                except:
                    return {
                        "status": "error",
                        "msg": "Could not retrive file from IPFS."
                    }

                return thash_details.result
            return {
                "status": "error",
                "msg": "No data found."
            }
        except:
            return {
                "status": "error",
                "msg": "Request error on XRPL. Possible wrong transaction hash."
            }


async def get_block_status(block_uuid):
    checkFile = await MongoHelper.find_one("documents", {"uuid": block_uuid})
    if checkFile and checkFile["name"]:
        if checkFile["status"] == "compleated":
            return {
                "status": "compleated",
                "block_data": {
                    "distributor": checkFile["xrpl_nft_data"]["data"]["distributor"],
                    "issued_for": checkFile["xrpl_nft_data"]["data"]["issued_for"],
                    "transfer_fee": checkFile["xrpl_nft_data"]["data"]["transfer_fee"],
                    "fee": checkFile["xrpl_nft_data"]["data"]["fee"],
                    "nft_trans_id": checkFile["xrpl_nft_data"]["data"]["issued_token"],
                    "nft_trans_details": checkFile["xrpl_nft_data"]["data"]["issued_token_link"]
                },
                "block_uuid": block_uuid
            }
        else:
            return {
                "status": checkFile["status"],
                "block_uuid": block_uuid
            }


async def create_block(data):
    
    if data and data['application'] and data['application']['app_encryption_key'] and data['client'] and data['client']['client_encryption_key'] and data["document_uuid"] and data['client']["client_wallet_seed"] and data['client']["client_wallet_seq"]:
        logger.info("> Processing encryption keys")

        client_wallet_seed = data['client']["client_wallet_seed"]
        client_wallet_seq = data['client']["client_wallet_seq"]
        # Generete Key to Encrypt file and file meta [Name : AlphaKey]
        genFileEncryptionKey = Fernet.generate_key()
        # Create SHA hash from application and client key
        genClientKeyHash = str(await HashHelper.hashSimpleText(data['client']['client_encryption_key']))
        genApplicationKeyHash = str(await HashHelper.hashSimpleText(data['application']['app_encryption_key']))
        # Generate Encryption Key based on application and client key hash [Name : DeltaKey], to Encrypt AlphaKey
        genEncryptionSalt = (await HashHelper.generate_salt_from_hash(genApplicationKeyHash, genClientKeyHash))
        # Encrypt AlphaKey with DeltaKey [Name : LambdaKey]
        encryptEncryptionKey = await HashHelper.encryptFernet(genFileEncryptionKey, genEncryptionSalt)
        # Decryption sample
        decryptEncryptionKey = str(await HashHelper.decryptFernet(encryptEncryptionKey, genEncryptionSalt))

        print("genFileEncryptionKey : " + str(genFileEncryptionKey))
        print("genClientKeyHash : " + str(genClientKeyHash))
        print("genApplicationKeyHash : " + str(genApplicationKeyHash))
        print("genEncryptionSalt : " + str(genEncryptionSalt))
        print("encryptEncryptionKey : " + str(encryptEncryptionKey))
        print("decryptEncryptionKey : " + decryptEncryptionKey)

        logger.info("> Processing encryption keys")
        # Find file
        checkFile = await MongoHelper.find_one("documents", {"uuid": data['document_uuid']})
        filter = {"uuid": data['document_uuid']}
        if checkFile and checkFile["name"]:
            logger.info("> Document Found : " + checkFile["uuid"])
            
            # Check if already working on the file
            if not checkFile["status"] != "pending" and not checkFile["status"] != "compleated":
                logger.info("> Block is already beeing processed.")
                return {
                    "status": checkFile["status"],
                    "block_uuid": checkFile["uuid"]
                }
                
            if checkFile["status"] == "compleated":
                logger.info("> Block processing compleated.")
                return {
                    "status": "compleated",
                    "block_uuid": checkFile["uuid"]
                }

            file_loc = PATH_FILES + checkFile["gen_name"]
            logger.info("> Encrypting & Compressing file")
            run_compress = await SubProcessHelper.compress_and_encrypt_file(file_loc, (genFileEncryptionKey))
            if run_compress and run_compress["status"] == "ok":

                update = {"status": "encrypting"}
                await MongoHelper.updateOne("documents", filter, update)

                update = {"processed_file": run_compress['processed_file']}
                await MongoHelper.updateOne("documents", filter, update)
                logger.info("> File Processing done")

                update = {"status": "uploading"}
                await MongoHelper.updateOne("documents", filter, update)

                logger.info("> Uploading to IPFS")
                UploadIpfs = await IpfsHelper.write_metadata(run_compress['processed_file'])
                update = {"ipfs_meta": UploadIpfs}
                await MongoHelper.updateOne("documents", filter, update)
                logger.info("> Uploaded to IPFS")

                # Will Delete file from server
                # try:
                #    logger.info("> Deleting temporary file")
                #    os.remove(run_compress['processed_file'])
                #    logger.info("> Temporary file deleted")
                # except FileNotFoundError:
                #    print("Temporary file is not present in the system.")

                update = {"status": "minting"}
                await MongoHelper.updateOne("documents", filter, update)

                # Mint NFT
                data = {
                    "title": "hub_secure_"+checkFile["gen_name"],
                    "metadata_uri": UploadIpfs["metadata_uri"],
                    "file_uri": UploadIpfs["file_uri"],
                    "file_hash": UploadIpfs["file_hash"],
                    "fee": "10",
                    "transfer_fee": "5",
                    "nft_trans_quantity": "1000000000000000e-96",
                    "enc_data": str(encryptEncryptionKey)

                }
                husecure_wallet = {
                    "seed": settings.XRP_HUBSECURE_SEED,
                    "seq": settings.XRP_HUBSECURE_SEQ,
                }

                # client_wallet = {
                #     "seed": "sEdTsxgEsgatzanLPKA6vJcTeFwSom2",
                #     "seq": "36191320",
                # }
                
                client_wallet = {
                    "seed": client_wallet_seed,
                    "seq": client_wallet_seq,
                }
                
                try:
                    mintnft = await XrplHelper.mint_nft(data, husecure_wallet, client_wallet)
                    update = {"xrpl_nft_data": mintnft}
                    await MongoHelper.updateOne("documents", filter, update)
                    logger.info("> NFT created")

                    update = {"status": "compleated", "download_count": ""}
                    await MongoHelper.updateOne("documents", filter, update)

                    return {
                        "status": "ok",
                        "msg": "File encryption error, please see logs."
                    }
                except:
                    update = {"status": "minting_error"}
                    await MongoHelper.updateOne("documents", filter, update)
                    return {
                        "status": "error",
                        "msg": "NFT processing error, please check logs."
                    }
            else:
                return {
                    "status": "error",
                    "msg": "File encryption error, please see logs."
                }
    else:
        return {
            "status": "error",
            "msg": "Required inputs are incorrect."
        }
