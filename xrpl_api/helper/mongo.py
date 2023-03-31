import pymongo
import settings
import traceback
import sys
import logging

logger = logging.getLogger(__name__)


def check_connection_status():
    try:
        logger.info("> Attempting to connect to mongodb server...")
        client = pymongo.MongoClient(settings.MONGODB_CONNECTION)
        db = client[settings.MONGODB_DB]
        logger.info("> Connected.")
        return True
    except Exception as e:
        logger.error("Exception seen: " + str(e))
        traceback.print_exc(file=sys.stdout)
        return False
    finally:
        if 'client' in locals():
            client.close()


async def get_client():
    try:
        client = pymongo.MongoClient(settings.MONGODB_CONNECTION)
        db = client[settings.MONGODB_DB]
        return db
    except Exception as e:
        logger.error("Exception seen: " + str(e))
        traceback.print_exc(file=sys.stdout)
        return False


async def insert(doc, collection):
    mongoClient = await get_client()
    docId = mongoClient[collection].insert_one(doc).inserted_id
    return docId


async def find_one(collection, *args, count=False):
    mongoClient = await get_client()
    if not count:
        return mongoClient[collection].find_one(*args)
    return mongoClient[collection].find(*args).count()


async def updateOne(collection, filter, updatedValue):
    mongoClient = await get_client()
    return mongoClient[collection].update_one(filter, {"$set": updatedValue})
