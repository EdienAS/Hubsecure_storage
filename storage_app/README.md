# Hubsecure-Backend API
Backend APIs responds to the requests coming from Frontend. This APIs manages Hubsecure Database, User Data and Authentication, Files and Folders
management. It Interacts with XRPL APIs to Upload/Download Files, requests Encryption/Decryption Keys and User XRPL Wallet Data.

# Installation and Setup Guide
## Server Requirements

**For running app make sure you have:**

- PHP >= 8.0
- MySQL 5.6+
- MongoDb >= 1
- Nginx or Apache

**These PHP Extensions are require:**

- bcmath
- calendar
- Core
- ctype
- curl
- date
- dom
- exif
- FFI
- fileinfo
- filter
- ftp
- gd
- gettext
- hash
- iconv
- json
- libxml
- mbstring
- mongodb
- mysqli
- mysqlnd
- openssl
- pcntl
- pcre
- PDO
- pdo_mysql
- Phar
- posix
- readline
- Reflection
- session
- shmop
- SimpleXML
- sockets
- sodium
- SPL
- standard
- sysvmsg
- sysvsem
- sysvshm
- tokenizer
- xml
- xmlreader
- xmlwriter
- xsl
- Zend OPcache
- zip
- zlib

## Installation

### 1. Upload files on your server
Clone the repository with git clone.
Upload project files to the web root folder of your domain. It's mostly located in `html`, `www` or `public_html` folder name.

### 2. Configure your Document Root
Configure your domain document root to the point of the files you previously uploaded directly into `/public` folder. So, if you uploaded files into `/public_html` folder, your document root must be set as `/public_html/public`.

Don't forget to enable Force HTTPS Redirect.

### 3. Set write permissions
Set `755` permission (CHMOD) to these files and folders directory within all children subdirectories:

- /bootstrap
- /storage
- /.env

### 4. Create Datebases
- MySql
-- Main Database
-- Testing Database
- MongoDb
-- Main Database
-- Testing Database

### 5. Create and Setup Enviornment Variable Files
Copy .env file to .env.testing

Edit below details with proper values in both the files
- App Name
- App URL
- Set LOG_CHANNEL to 'daily'
- Edit database credentials
- Add MongoDb credentials 
-- MONGODB_CONNECTION
-- MONGODB_HOST
-- MONGODB_PORT
-- MONGODB_DATABASE
-- MONGODB_USERNAME
-- MONGODB_PASSWORD
- BROADCAST_DRIVER = database
- Set FILESYSTEM_DISK to 'local'
- Set QUEUE_CONNECTION to 'database'
- Edit Mail credentials
- Add parameter FRONTEND_URL with corresponding value
- Add XRPL Block parameters with corresponding value
-- XRPL_BLOCK_DOMAIN = "<XRPL_API_Domain>"
-- XRPL_APP_ENCRYPTION_KEY
**Note:** Generate XRPL_APP_ENCRYPTION_KEY by sending a GET request to <XRPL_API_Domain>/gen/key/application API.
- Add SCOUT_DRIVER parameter and set to 'database'

- Generate below details for testing enviornment and add it into .env.testing file.
-- BROADCAST_DRIVER = log
-- XRPL_BLOCK_DOMAIN = "<XRPL_API_Domain>"
-- XRPL_APP_ENCRYPTION_KEY - Use previously generated app encryption key.
-- XRPL_CLIENT_ENCRYPTION_KEY: send a GET request to <XRPL_API_Domain>/gen/key/client API.
-- XRPL_CLIENT_WALLET_SEED: send a GET request to <XRPL_API_Domain>/test/test_wallet API and take the "seed" value.
-- XRPL_CLIENT_WALLET_SEQ: send a GET request to <XRPL_API_Domain>/test/test_wallet API and take the "seq" value.

### 6. Install Packages
- Run `composer update`

### 7. Generate Application Key
- Run `php artisan key:generate`

### 8. Execute Database Migrations and Seeds
- Run `php artisan migrate`
- Run `php artisan db:seed`

- A default user will be created: 
-- Email: admin@admin.com
-- Password: password

### 9. Setup Cron Job
- Set cron job as below
-- `* * * * * cd <path_to_your_project_folder> && php artisan schedule:run >> /dev/null 2>&1`

### 10. Execute Configuration and Cache clear commands
- Run `php artisan optimize:clear`
- Run `php artisan config:cache`
- Run `php artisan config:clear`
- Run `php artisan cache:clear`

### Open your application in your web browser
Then open your Frontend Web application in web browser and login. If everything works fine, you will be redirected to dashboard.
