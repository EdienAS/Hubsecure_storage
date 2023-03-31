import base64
import hmac
import hashlib
import os
import re
import uuid
import base64
from builtins import bytes
from cryptography.fernet import Fernet
from gibberish import Gibberish


def extract_hash(string, length=32):
    modify = re.search(r'\b[0-9a-fA-F]{%d}\b' % length, string).group(0)
    if modify:
        return modify


async def encryptFernet(text, key):
    fobject = Fernet(key)
    return fobject.encrypt(str(text).encode('utf-8'))


async def decryptFernet(token, key):
    fobject = Fernet(key)
    return fobject.decrypt((token)).decode("utf-8")


async def hashSimpleText(text):
    return hashlib.sha256(text.encode()).hexdigest()


async def hashText(text):
    salt = uuid.uuid4().hex
    return hashlib.sha256(salt.encode() + text.encode()).hexdigest() + ':' + salt


async def matchHashedText(hashedText, providedText):
    _hashedText, salt = hashedText.split(':')
    return _hashedText == hashlib.sha256(salt.encode() + providedText.encode()).hexdigest()

async def generate_random_sentance(length=5):
    gen = Gibberish()
    gensentance = gen.generate_words(length)
    return " ".join(gensentance).upper()

async def generateUniqeEncryptionKey(length=32):
    genkey = base64.b64encode(hmac.new(str(uuid.uuid1()).encode(
        'utf-8'), str(uuid.uuid4()).encode('utf-8'), hashlib.sha256).digest())[:-1]
    if int(length) <= len(genkey):
        genkey = genkey[:int(length)]
    return str(genkey.decode("utf-8"))


async def generate_salt_from_hash(application_key_hash, client_key_hash):
    mix_app_key_hash_first = application_key_hash[0:8]
    mix_app_key_hash_last = application_key_hash[-8:]
    mix_client_key_hash_first = application_key_hash[0:8]
    mix_client_key_hash_last = application_key_hash[-8:]
    mix_keys = str(mix_app_key_hash_first + "" + mix_client_key_hash_first +
                   "" + mix_app_key_hash_last + "" + mix_client_key_hash_last)
    let_it_hash = base64.urlsafe_b64encode(bytes(mix_keys, "ascii"))
    return let_it_hash


def generate_key() -> bytes:
    return base64.urlsafe_b64encode(os.urandom(32))
