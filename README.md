# Laravel Blogger

### Prerequisites
* php v7.4
* Apache v2.4.43
* MySQL v8
* [Composer](https://getcomposer.org) v2.x

### Quick setup
* Clone this repo, checkout to most active branch
* Create a config file (copy from ```.env.example```), and update environment variables
```
cp .env.example .env
```
* Install dependencies
```
composer install
npm install

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
* compile css and js assets
```
npm run dev 
```
* start the local development server
```
php artisan serve 
```
