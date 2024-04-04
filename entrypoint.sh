#!/bin/sh

cd /var/www/html 

rm -rf Modules/*
rm -rf composer.lock

composer install --no-interactions

composer require mybizna/account --no-interactions
composer require mybizna/isp --no-interactions

php artisan key:generate

php artisan migrate --force

