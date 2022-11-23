
## Installation

###Enter the commands in brackets to terminal on mac one by one

install brew if not installed:

`/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`

install mysql:

`brew install mysql`

`mysql_secure_installation`


install brew services:

`brew tap homebrew/services`

start mysql:

`brew services start mysql`

set mysql root password:

`mysqladmin -u root password 'root'`

login mysql

`sudo mysql -u root -p`

create new database for app:

`create database appointment;`

exit from mysql:

`exit;`

go to your app folder:

`cd /path/to/your/laravel/site`

create .env file and set your mysql password and database name in .env file:

`cp .env.example .env`

install composer dependencies

`composer install`

run migrations and seeders

`php artisan migrate:fresh; php artisan db:seed`

run builtin server

`php artisan serve`

then go to http://127.0.0.1:8000/`

Username:`admin@appointment.test`

Password: `test`


