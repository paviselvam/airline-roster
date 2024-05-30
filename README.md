This project runs with Laravel version 10

Assuming you've already installed on your machine: PHP (>= 8.2.0), Laravel, Composer and Node.js.
# install dependencies
composer install
npm install

# create .env file and generate the application key
cp .env.example .env
php artisan key:generate

# create project folder
composer create-project --prefer-dist laravel/laravel airline-roster
cd airline-roster

# Database using MYSQL and APACHE SERVER
Download Xampp
Start the Apache server and MYSQL
Create tables and link with project
Give credentials for DB connection in .env file
php artisan migrate

# Required commands
composer dump-autoload
php artisan route:clear
php artisan cache:clear
php artisan optimize:clear
composer require maatwebsite/excel:3.1.48
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
php artisan optimize:clear

# Please make sure php.ini file is updated
php artisan route:list
php artisan serve
Open Postman and upload files and test with routes
 

