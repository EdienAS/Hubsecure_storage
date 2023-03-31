# Hubsecure_storage


HubSecure' Storage module gives power to user and enterprise to share important files, folder with people within and outside organsation. Higly complicated encryption methodology is used to create a hash which is then save saved on blockchain which makes HubSecure reliable and safe platform to use as dcouments becomes incorruptible and secure. File itself is saved on distributed networks using IPFS protocol in chunks. <br /> <br />

The complete HubSecure's Storage module consist of 3 components <br />
  a. Frontend  <br />
  b. Backend  <br />
  c. XRPL node  <br />
  
The complete respository have all three component in its respective folder.<br /> <br /> <br />




# Deployment

#### Note

* Change .env files as required on each app.

```sh
$ chmod +x *.sh
$ ./deploy.sh
```

# xrpl_api

This API helps to Upload/Download files, Encrypt/Decrypt Files and Create Encrypted NFT inside XRPL.

#### What This API does not handle?

* Any User Data
* Any Unencrypted files in local storage
* Host Customers XRPL Wallet data [Seed, Sequence]
* Host Encryption / Decryption key

#### What This API does?

* Handles File Uploads and Provide UUID called `document_uuid`
* Handles File Upload to IPFS
* Handles Temporary file deletions
* Handles File Compression and Encryption
* Handles Encryption key generation and Securing Encryption key in NFT 
* Handles NFT minting in XRPL 
* Handles KYC document verification using [https://www.idanalyzer.com] api.
* Handles KYC document encryption and NFT minting.


## Contributing
If you would like to contribute to the project, please feel free to fork the repository and submit a pull request. Before submitting a pull request, please make sure that your changes are thoroughly tested and that they adhere to the project's coding standards.

## License
This project is released under the MIT License. See the <b>LICENSE</b> file for more information.

## Credits
This project was created by <b>Hubsecure Team</b>.