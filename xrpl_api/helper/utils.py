from pathlib import Path
import json
import codecs
import hashlib


def to_sha1(input):
    h = hashlib.sha1(input.encode('utf-8'))
    output = h.hexdigest().upper()
    print("output length ", len(output))
    return output


def to_hex(input_string):
    output_hex = input_string.encode('utf-8').hex().upper()
    return output_hex


def file_to_hex(filename):
    with Path(filename).open("rb") as file:
        input = json.load(file)
        text = json.dumps(input, sort_keys=True,
                          indent=4, separators=(',', ': '))
        hex_value = to_hex(text)
        return hex_value


def memo_to_hex(file_url, meta_url):
    data = {
        'file_url': file_url,
        'metadata_url':  meta_url
    }

    return to_hex(str(data))


def uri_hex(file_url):
    data = {
        'file_url': file_url
    }

    return to_hex(str(data))


def memo_json_to_hex(data_json):
    data = {
        'enc_data': data_json
    }

    return to_hex(str(data))


def hex_to_ascii(hex_string):
    binary_str = codecs.decode(hex_string, "hex")
    string_value = str(binary_str, 'utf-8')
    return string_value


def get_explorer_addr(account):
    return f"https://test.bithomp.com/explorer/{account}"
