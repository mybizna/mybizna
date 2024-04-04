# Contents of Dockerfile_ext

cd /var/www/html 

composer install --no-interactions

composer require mybizna/account --no-interactions
composer require mybizna/isp --no-interactions

php artisan key:generate

php artisan migrate --force

