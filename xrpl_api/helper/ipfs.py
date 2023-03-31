import logging
import asyncio
import requests
from pathlib import Path
import os
import json
from os import getcwd
import settings
from urllib.parse import urlparse, parse_qs
import urllib.request as urllib2
logger = logging.getLogger(__name__)

PATH_FILES = getcwd() + "/temp_files/"

ipfs_url = settings.IPFS_DOMAIN


async def write_metadata(file):
    collectible_metadata = {}
    cleaned_title = file.split("/")[-1].split(".")[0].split("_")[0]
    metadata_dir = PATH_FILES + "metadata/testnet/"
    if not os.path.exists(metadata_dir):
        os.makedirs(metadata_dir)

    metadata_filename = (
        PATH_FILES + "metadata/testnet/" + cleaned_title + ".json"
    )
    if Path(metadata_filename).exists():
        logger.info(
            "metadata file {} already exists ".format(metadata_filename))
    else:
        logger.info("create metadata file {} ".format(metadata_filename))
        logger.info(collectible_metadata)
        img_uri = None
        img_hash = None
        img_hash, img_uri = await upload_to_ipfs(file)
        collectible_metadata["file_hash"] = img_hash
        collectible_metadata["file_uri"] = img_uri
        logger.info(collectible_metadata)

        # Write to metada file
        with open(metadata_filename, "w") as file:
            json.dump(collectible_metadata, file)

        meta_hash = None
        metadata_uri = None
        meta_hash, metadata_uri = await upload_to_ipfs(metadata_filename)
        collectible_metadata["metadata_uri"] = metadata_uri
        collectible_metadata["metadata_hash"] = meta_hash
        with open(metadata_filename, "w") as file:
            json.dump(collectible_metadata, file)

    respObj = {}
    with open(metadata_filename) as f:
        collectible_metadata = json.load(f)
        respObj = {
            "file_uri": collectible_metadata["file_uri"],
            "file_hash": collectible_metadata["file_hash"],
            "metadata_uri": collectible_metadata["metadata_uri"],
            "metadata_hash": collectible_metadata["metadata_hash"],
            "collectible_metadata": json.dumps(collectible_metadata, indent=2, sort_keys=True)
        }
    return respObj


async def download_from_ipfs(file_uri):
    chunk_size = 4096
    parseUrl = urlparse(file_uri)
    parseQ = parse_qs(parseUrl.query)
    fileUrl = settings.LOCAL_IPFS_WEB_DOMAIN + parseUrl.path + \
        "?download=true&filename=" + parseUrl.path

    ret = urllib2.urlopen(fileUrl)
    if ret.code == 200:
        # http://127.0.0.1:8080/ipfs/QmZq4bKTCq2jGR5MsuXbyk4jgn8X4MaAJmUyVGcb84wZ2h?download=true&filename=QmZq4bKTCq2jGR5MsuXbyk4jgn8X4MaAJmUyVGcb84wZ2h
        filename = PATH_FILES+parseQ["filename"][0]
        r = requests.get(fileUrl)
        with open(filename, "wb") as code:
            code.write(r.content)
        return filename
    else:
        return False


async def upload_to_ipfs(filePath):
    logger.info("> Retrieving file at: " + filePath)
    if os.path.exists(filePath):
        with Path(filePath).open("rb") as fp:
            doc_binary = fp.read()
            response = requests.post(
                ipfs_url + '/api/v0/add', files={"file": doc_binary})
            ipfs_hash = response.json()["Hash"]
            filename = filePath.split("/")[-1:][0]
            uri = "https://ipfs.io/ipfs/{}?filename={}".format(
                ipfs_hash, filename)
            logger.info("> IPFS Upload compleated")
            return ipfs_hash, uri
    else:
        return False, False
