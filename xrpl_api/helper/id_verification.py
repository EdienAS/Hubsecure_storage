import idanalyzer
import helper.ipfs as IpfsHelper
import helper.mongo as MongoHelper
import helper.file_handler as File
import helper.blocks as Blocks
from fastapi import BackgroundTasks
from os import getcwd
import settings
import helper.hash as HashHelper
import helper.subprocess as SubProcessHelper
import helper.xrpl as XrplHelper
import logging
import uuid
import json
import base64
from bson.json_util import dumps
logger = logging.getLogger(__name__)

PATH_FILES = getcwd() + "/temp_files/"


async def VerifyID(doc_front, doc_back, live_photo, doc_type, cust_name, cust_dob, doc_number, uuid):
    logger.info("> Starting identity verificcation of : " + uuid)
    try:
        coreapi = idanalyzer.CoreAPI(settings.IDANALYZER_API_KEY)
        coreapi.throw_api_exception(True)
        coreapi.enable_authentication(True, 'quick')
        coreapi.verify_document_number(doc_number)
        coreapi.verify_name(cust_name)
        coreapi.verify_dob(cust_dob)
        response = coreapi.scan(document_primary=doc_front,
                                document_secondary=doc_back, biometric_photo=live_photo)

        filter = {"uuid": uuid}
        update = {"status": "completed", "identity_data": response}
        await MongoHelper.updateOne("kyc_docs", filter, update)

        logger.info("> Identity verificcation ccompleted : " + uuid)
        # logger.info(response)
        return True

    except idanalyzer.APIError as e:
        # If API returns an error, catch it
        details = e.args[0]
        print("API error code: {}, message: {}".format(
            details["code"], details["message"]))

    except Exception as e:
        print(e)


async def UploadFile(doc_type, cust_name, cust_dob, doc_number, block_doc_front, block_doc_back, block_doc_live):
    if block_doc_front[0] and block_doc_front[0]["file_path"] and block_doc_back[0] and block_doc_back[0]["file_path"] and block_doc_live[0] and block_doc_live[0]["file_path"]:
        kyc_doc = {}
        kyc_doc['uuid'] = str(uuid.uuid1())
        kyc_doc['status'] = "processing"
        kyc_doc['identity_data'] = {}
        kyc_doc['user_upload_data'] = {
            "doc_front": block_doc_front[0],
            "doc_back": block_doc_back[0],
            "live_photo": block_doc_live[0],
            "doc_type": doc_type,
            "cust_name": cust_name,
            "cust_dob": cust_dob,
            "doc_number": doc_number
        }
        await MongoHelper.insert(json.loads(json.dumps(kyc_doc)), "kyc_docs")
    return kyc_doc


async def get_kyc_status(kyc_uuid):
    kycStatus = await MongoHelper.find_one("kyc_docs", {"uuid": kyc_uuid})
    if kycStatus and kycStatus["user_upload_data"]:
        if kycStatus["status"] == "completed":
            return (json.loads(dumps(kycStatus)))
        else:
            return {
                "status": kycStatus["status"],
                "block_uuid": kyc_uuid
            }
