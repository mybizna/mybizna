#!/bin/sh
#sudo chmod +x easycommit.sh && sudo ./easycommit.sh
cd ..
su - www-data
#git config --local user.email "dedanirungu@gmail.com"
#git config --local user.name "dedanirungu"
#sudo git config --system --add safe.directory /var/www/html/php/laravel/laravelerp

git add .
git commit --allow-empty -m "Regular Update"
