# Laravel Blogger

[![tests](https://github.com/ankurk91/laravel-blogger-example/actions/workflows/tests.yml/badge.svg)](https://github.com/ankurk91/laravel-blogger-example/actions/workflows/tests.yml)

### Prerequisites
* php v7.4, [see](https://laravel.com/docs/installation) Laravel specific requirements
* Apache v2.4.33 with ```mod_rewrite```
* MySQL v8.0
* [Composer](https://getcomposer.org) v2.x

### Quick setup
* Clone this repo, checkout to most active branch
* Write permissions on ```storage``` and ```bootstrap/cache``` folders
* Create a config file (copy from ```.env.example```), and update environment variables
```
cp .env.example .env
```
* Install dependencies
```
composer install
php artisan key:generate
```
* Migrate and Seed database
```
php artisan migrate
php artisan db:seed
```
* Create the symbolic link for local file uploads
```
php artisan storage:link
```
* Point your web server to **public** folder of this project
* Additionally, you can run this command on production server
```
php artisan optimize
```
