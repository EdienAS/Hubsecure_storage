import logging
import os
import hashlib
import uuid
from os import getcwd
PATH_FILES = getcwd() + "/temp_files/"


logger = logging.getLogger(__name__)


def human_readable_size(size):
    if size < 1024:
        return f"{size} B"
    elif size < 1024 * 1024:
        return f"{size / 1024:.2f} KB"
    elif size < 1024 * 1024 * 1024:
        return f"{size / 1024 / 1024:.2f} MB"
    else:
        return f"{size / 1024 / 1024 / 1024:.2f} GB"


async def compute_sha256(file_name):
    hash_sha256 = hashlib.sha256()
    with open(file_name, "rb") as f:
        for chunk in iter(lambda: f.read(4096), b""):
            hash_sha256.update(chunk)
    return hash_sha256.hexdigest()


async def UploadSingleFile(file):
    print(type(file))
    try:
        contents = await file.read()
        gen_new_name = str(uuid.uuid1()) + "_" + file.filename
        with open(PATH_FILES + gen_new_name, 'wb') as f:
            f.write(contents)

        sha_hash = await compute_sha256(PATH_FILES + gen_new_name)
        return ({
            "name": file.filename,
            "content_type": file.content_type,
            "gen_name": gen_new_name,
            "file_path": PATH_FILES + gen_new_name,
            "file_size": os.path.getsize(PATH_FILES + gen_new_name),
            "file_sha_hash": sha_hash
        })
    except Exception as e:
        logger.error(e)
        return {"message": "There was an error uploading the file(s)"}
    finally:
        await file.close()


async def UploadFile(files):
    file_list = []
    for file in files:
        try:
            contents = await file.read()
            gen_new_name = str(uuid.uuid1()) + "_" + file.filename
            with open(PATH_FILES + gen_new_name, 'wb') as f:
                f.write(contents)

            sha_hash = await compute_sha256(PATH_FILES + gen_new_name)
            file_list.append({
                "name": file.filename,
                "content_type": file.content_type,
                "gen_name": gen_new_name,
                "file_size": os.path.getsize(PATH_FILES + gen_new_name),
                "file_sha_hash": sha_hash
            })
        except Exception as e:
            logger.error(e)
            return {"message": "There was an error uploading the file(s)"}
        finally:
            await file.close()
    return file_list
