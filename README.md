# Hubsecure Storage


HubSecure' Storage module gives power users and enterprises to share important files and folders with people within and outside the organization. A highly complicated encryption methodology is used to create a hash which is then saved on the blockchain which makes HubSecure a reliable and safe platform to use to store documents securely. The file itself is saved on distributed networks using the IPFS protocol in chunks after encrypting.

The complete HubSecure Storage Solution consists of 3 components:

* XRPL API
* Backend API
* Frontend [Improvements in progress]

This repository has all three components in their respective folder.


# Demo

[![Hubsecure Storage Demo](https://img.youtube.com/vi/jNmqCG6Rf9Q/0.jpg)](https://www.youtube.com/watch?v=jNmqCG6Rf9Q)

___

### XRPL API

This API helps to Upload/Download files, Encrypt/Decrypt Files and Create Encrypted NFT inside XRPL.

#### Technology Used :

* Python [Fast API]
* IPFS Node
* MongoDB

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
* Handles KYC document verification using [https://www.idanalyzer.com] API.
* Handles KYC document encryption and NFT minting.

___

### Backend API

Backend API helps with almost all requests coming from Frontend. It manages users, user data, File Uploads, Role Management, Authentication, etc.

#### Technology Used :

* PHP [Laravel]
* MySql
* MongoDB

#### What This API does not handle?

* Files Compression, Minting and Upload to IPFS
* Generation of Encryption/Decryption Key
* Generation of Customer XRPL Wallet Data

#### What This API does?

* Handles Hubsecure Database management, i.e. Insert/Read/Update/Delete Database Records.
* Handles requests coming from Frontend and return with appropriate responses.
* Handles File Upload/Download by connecting with XRPL APIs
* Handles Files and Folders management and Sharing
* Handles Queues and Notification Broadcasting
* Handles User Data and Authentication
* Handles User Registration/Login

___

### Frontend

Frontend handled everything about generating View.

#### Technology Used :

* HTML & CSS
* Javascript
* Vue.Js [Required v2.x.x]
* Vuex [Required v3.x.x]
* Vue-Router [Required v3.x.x]

#### What Pages are Implemented?

* Authentication Pages including SignIn, SignUp
* My Drive page to list all the folders and files
* Dashboard page to view recent folders and files
* Trash page to view trashed folders and files

___

### Deployment

This repo has been made as a docker package. XRPL API, Backend API, and Frotend will be built and run as containers. But this setup is **NOT READY FOR PRODUCTION**. Use it only for Development or Test purpose.

##### Note

* Before Deploying, make sure to update all `.env` files in respective folders.
* Install Docker, Docker-compose
* It will consume common ports like `80`,`3306` etc on your machine.

```bash
$ chmod +x *.sh
$ ./deploy.sh
```

##### Stop Docker Containers

```bash
$ docker-compose down
```

##### Destroy Docker Containers with data

```bash
$ docker-compose down -v
```
___

### Documentations

##### XRPL API

[XRPL API POSTMAN COLLECTION](https://github.com/EdienAS/Hubsecure_storage/tree/master/xrpl_api/postman_collection)

##### Backend API

[Backend API POSTMAN COLLECTION](https://github.com/EdienAS/Hubsecure_storage/tree/master/storage_app/documents)

___

###  PHPMyAdmin

* **URL** : http://localhost:8081
* **Server** : mysql
* **Username** : local
* **Password** : local

___

###  MongoEexpress

**URL** : http://localhost:8082

___

###  Contributing

If you would like to contribute to the project, please feel free to fork the repository and submit a pull request. Before submitting a pull request, please make sure that your changes are thoroughly tested and that they adhere to the project's coding standards.

___

### Security Vulnerabilities

If you discover a security vulnerability within Hubsecure Storage Opensource Version, please submit an Issue. All security vulnerabilities will be promptly addressed.

___

### License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/license/mit/)

___

### Credits

This project was created by **Hubsecure Team**.
