#!/bin/bash

chown -R www-data:www-data .
chmod -R 777 storage
composer install
php artisan key:generate
php artisan migrate

php-fpm