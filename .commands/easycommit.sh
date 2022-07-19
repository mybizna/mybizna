#!/bin/sh
#sudo chmod +x easycommit.sh && sudo ./easycommit.sh
cd ..
su - www-data
#git config --local user.email "dedanirungu@gmail.com"
#git config --local user.name "dedanirungu"

git add .
git commit --allow-empty -m "Regular Update"
