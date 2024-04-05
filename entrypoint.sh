#!/bin/sh

mysql -h mariadb -u root -p

cd /var/www/html 

cp .env.example .env

sed -i 's/DB_HOST=.*/DB_HOST=mariadb/g' .env 
sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/g' .env
sed -i 's/DB_PORT=.*/DB_PORT=3307/g' .env 
sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=your_root_password/g' .env

cat /var/www/html/.env

rm -rf Modules/*
rm composer.lock

composer install --no-interaction

composer require mybizna/isp:24.3.004 --no-interaction

echo '----------'
echo '-----mariadb-----'

mysql -u root -h mariadb -e "CREATE DATABASE IF NOT EXISTS mybizna"

php artisan key:generate

php artisan migrate --force

