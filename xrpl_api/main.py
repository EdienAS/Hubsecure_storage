from typing import Union
from fastapi import FastAPI, File, UploadFile, BackgroundTasks, Request, Form
from typing_extensions import Annotated
from fastapi.responses import JSONResponse
import helper.mongo as MongoHelper
import helper.hash as HashHelper
import helper.xrpl as XrplHelper
import helper.blocks as Blocks
import helper.id_verification as IdVerificationHelpeer
import logging
from typing import List

# setup loggers
logging.config.fileConfig('logging.conf', disable_existing_loggers=False)

# get root logger
logger = logging.getLogger(__name__)

app = FastAPI(
    title="Hubsecure XRPL Internal API",
    description="Handles Files, IPFS, Encryption, Decryption Compression and NFTMinting for HubSecure",
    version="0.0.1",
    contact={
        "name": "Ahmed Rizawan",
        "email": "ahmed@edien.com",
    },
    license_info={
        "name": "Apache 2.0",
        "url": "https://www.apache.org/licenses/LICENSE-2.0.html",
    })

# Health Check


@app.get('/')
async def read_root(background_tasks: BackgroundTasks):
    return {
        'status': 'alive',
        'db_connected': MongoHelper.check_connection_status()
    }

# Generate Application Key


@app.get('/gen/key/application')
async def gen_application_key():
    result = await HashHelper.generateUniqeEncryptionKey()
    return result


# Generate Client Key
@app.get('/gen/key/client')
async def gen_client_key():
    result = await HashHelper.generate_random_sentance()
    return result


# Generate Test Wallet


@app.get('/test/test_wallet')
async def read_root_g():
    getWallet = await XrplHelper.generate_test_wallet()
    return getWallet

# Get wallet details


@app.get('/xrp/get_wallet_details/{wallet_classic_address}')
def get_wallet_details(wallet_classic_address: str):
    getWallet = XrplHelper.parse_wallet(wallet_classic_address)
    return getWallet


@app.post("/block/upload")
async def upload_file(background_tasks: BackgroundTasks, files: List[UploadFile] = File(...)):
    result = await Blocks.UploadFile(files)
    return JSONResponse(content=result)


@app.post("/block/create")
async def create_block(background_tasks: BackgroundTasks, data: Request):
    dataObj = await data.json()
    # Process Block
    background_tasks.add_task(Blocks.create_block, data=dataObj)
    return {
        "status": "processing",
        "block_uuid": dataObj["document_uuid"]
    }


@app.get('/block/status/{block_uuid}')
async def get_block_status(block_uuid: str):
    result = await Blocks.get_block_status(block_uuid)
    return result


@app.get('/download/once/{block_uuid}')
async def get_block_status(block_uuid: str):
    return await Blocks.block_download(block_uuid)


@app.post('/block/document')
async def get_document_data(background_tasks: BackgroundTasks, data: Request):
    dataObj = await data.json()
    getMetaFast = await Blocks.get_document_meta(dataObj)
    hasDownloadableLink = await Blocks.block_has_downloadable_link(dataObj)
    if not hasDownloadableLink:
        background_tasks.add_task(Blocks.get_document_data, data=dataObj)
    return getMetaFast


# @app.post("/kyc/upload")
# async def upload_file(background_tasks: BackgroundTasks, doc_front: Annotated[UploadFile, File()],
#     doc_back: Annotated[UploadFile, File()],
#     doc_type: Annotated[str, Form()]):
#     result = await IdVerificationHelpeer.UploadFile(doc_front, doc_back, doc_type)
#     return JSONResponse(content=result)

@app.post("/kyc/upload")
async def upload_file(background_tasks: BackgroundTasks,
                      doc_front: UploadFile = File(),
                      doc_back: UploadFile = File(),
                      live_photo: UploadFile = File(),
                      cust_name: str = Form(),
                      cust_dob: str = Form(),
                      doc_number: str = Form(),
                      doc_type: str = Form()
                      ):

    # Create block of Document and Create NFT of it
    block_doc_front = await Blocks.UploadSingleFile(doc_front)
    block_doc_back = await Blocks.UploadSingleFile(doc_back)
    block_doc_live = await Blocks.UploadSingleFile(live_photo)

    # Run ID Verification In Background
    result = await IdVerificationHelpeer.UploadFile(doc_type, cust_name, cust_dob, doc_number, block_doc_front, block_doc_back, block_doc_live)
    background_tasks.add_task(IdVerificationHelpeer.VerifyID, doc_front=result["user_upload_data"]["doc_front"]["file_path"], doc_back=result["user_upload_data"]["doc_back"]["file_path"],
                              live_photo=result["user_upload_data"]["live_photo"]["file_path"], doc_type=doc_type, cust_name=cust_name, cust_dob=cust_dob, doc_number=doc_number, uuid=result['uuid'])

    return JSONResponse(content=result)


@app.get('/kyc/status/{kyc_uuid}')
async def get_kyc_status(kyc_uuid: str):
    result = await IdVerificationHelpeer.get_kyc_status(kyc_uuid)
    return JSONResponse(content=result)
