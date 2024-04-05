#!/bin/sh

cd /var/www/html 

cp .env.example .env

sed -i 's/DB_HOST=.*/DB_HOST=mariadb/g' .env 
sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/g' .env
sed -i 's/DB_PORT=.*/DB_PORT=3306/g' .env 

rm -rf Modules/*
rm composer.lock

composer install --no-interaction

composer require mybizna/isp:24.3.004 --no-interaction


php artisan key:generate

php artisan migrate:rollback

php artisan migrate:status

php artisan migrate --force

