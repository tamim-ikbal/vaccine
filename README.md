<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></p>


## Laravel Boilerplate

### Clone this Project
    git clone https://github.com/tamim-ikbal/vaccine.git
#### Goto project directory
    cd vaccine
### Install dependencies
    composer install

    npm install

### Create a copy of your .env.example file to .env
    cp .env.example .env

### Generate an app encryption key
    php artisan key:generate

### Database Connection
#### Create an empty database for the application and then In the .env file, add database information to allow Laravel to connect to the database
    DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD

### SMTP
#### Configure SMTP for sending email

### Migrate and Seed the database
    php artisan migrate:fresh --seed

### Run application
    composer run dev
