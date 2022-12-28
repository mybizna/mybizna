#!/bin/sh
#   mybizna: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@
#sudo chmod +x pushtags.sh && sudo ./pushtags.sh

VERSION=0.9.7.2
FOLDER=$(pwd)
OLDVERSION=`cat version`

echo "
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
COPY COMMANDS BELOW


"
if [ $VERSION != $OLDVERSION ]
 then

    echo "sed -i 's/$OLDVERSION/$VERSION/g'  composer.json"
    echo "sed -i 's/$OLDVERSION/$VERSION/g'  Modules/*/composer.json"

    echo "


git submodule foreach git tag $VERSION

git submodule foreach git add .
git submodule foreach git commit --allow-empty -m 'Update'
git submodule foreach git push origin main

git submodule foreach git push --tags

git submodule foreach gh release create $VERSION --generate-notes


git tag $VERSION
git add .
git commit --allow-empty -m 'Update'
git push origin main

git push --tags

gh release create $VERSION --generate-notes
    "
    #git release $VERSION 
    #git submodule foreach git release $VERSION  
    #git submodule foreach gh release create 0.9.7 --generate-notes
else
    echo "
git submodule foreach git add .
git submodule foreach  git commit --allow-empty -m 'Update'
git submodule foreach git push origin main
    "
fi

echo " 
echo '$VERSION' > 'version' 

"