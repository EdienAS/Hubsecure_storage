import subprocess
import os
import shutil
from os import getcwd
import helper.mongo as MongoHelper

PATH_FILES_DOWN = getcwd() + "/temp_files/download/"


async def uncompress_and_decrypt_file(file_path, key, block_uuid):
    dec_key = key.replace("b'", "")
    dec_key = dec_key.replace("'", "")
    parseUrl = os.path.basename(file_path).split('/')[-1]
    parseUrl = parseUrl.replace(".hs", "")
    gen_uncompressed_name = PATH_FILES_DOWN + parseUrl
    is_zip_ok = False

    filter = {"uuid": block_uuid}

    try:
        isExist = os.path.exists(PATH_FILES_DOWN)
        if not isExist:
            os.makedirs(PATH_FILES_DOWN)
        unzip_sub_process = subprocess.run(
            ["unzip", "-o", "-P "+dec_key, file_path, "-d", PATH_FILES_DOWN], stdout=subprocess.PIPE)
        if unzip_sub_process.stderr:
            is_zip_ok = False
            print(unzip_sub_process.stderr)
        else:
            print(unzip_sub_process.stdout)
            is_zip_ok = True
    except subprocess.CalledProcessError as e:
        print(e)
        is_zip_ok = False

    if is_zip_ok == True:
        update = {"temp_download_file": gen_uncompressed_name,
                  "download_count": 0}
        await MongoHelper.updateOne("documents", filter, update)
        return {
            "status": "ok"
        }
    else:
        return {
            "status": "error"
        }


async def compress_and_encrypt_file(file_path, key):
    gen_compressed_name = file_path + ".hs"
    gen_uncompressed_name = file_path + ".tmp"
    dec_key = str(key.decode("utf-8"))

    is_zip_ok = False
    is_zip_err = True

    try:
        os.remove(gen_compressed_name)
    except FileNotFoundError:
        print("Encrypted file is not present in the system.")

    try:
        shutil.rmtree(gen_uncompressed_name)
    except FileNotFoundError:
        print("Uncompressed file is not present in the system.")

    try:
        zip_sub_process = subprocess.run(
            ["zip", "-9", "-e", "-v", "-j", "-P "+dec_key, gen_compressed_name, file_path], stdout=subprocess.PIPE)
        if zip_sub_process.stdout:
            unzip_sub_process = subprocess.run(
                ["unzip", "-P "+dec_key, gen_compressed_name, "-d", gen_uncompressed_name], stdout=subprocess.PIPE)
            if unzip_sub_process.stderr:
                is_zip_ok = False
                print(unzip_sub_process.stderr)
            else:
                is_zip_err = False
                is_zip_ok = True
                try:
                    shutil.rmtree(gen_uncompressed_name)
                except FileNotFoundError:
                    is_zip_ok = False
        else:
            is_zip_err = True
    except subprocess.CalledProcessError as e:
        print(e)
        is_zip_ok = False
        is_zip_err = True

    if is_zip_ok == True:
        try:
            os.remove(file_path)
        except FileNotFoundError:
            print("Original file is not present in the system.")

        return {
            "status": "ok",
            "processed_file": gen_compressed_name
        }
    else:
        return {
            "status": "error"
        }
