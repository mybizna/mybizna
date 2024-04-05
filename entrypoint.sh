#!/bin/sh

cd /var/www/html 

rm -rf Modules/*
rm composer.lock

composer install --no-interaction

composer require mybizna/isp:24.3.004 --no-interaction

mysql -u root -h "mariadb" -e "CREATE DATABASE IF NOT EXISTS mybizna"

#php artisan key:generate

#php artisan migrate --force

