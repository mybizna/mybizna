#!/bin/sh
# chmod +x pushtags.sh && ./pushtags.sh

VERSION=1.3.5
FOLDER=$(pwd)
OLDVERSION=`cat version`

echo "Enter Your Commit Message: "  
read MESSAGE  
echo "
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
Starting Commit Process
"
update_assets () {
    rm -r ../assets/src/mybizna/components
    rm -r ../assets/src/mybizna/css
    rm -r ../assets/src/mybizna/fonts
    rm -r ../assets/src/mybizna/images
    rm -r ../assets/src/mybizna/js
    rm -r ../assets/src/mybizna/tailwind
    rm -r ../assets/src/mybizna/tinymce
    rm -r ../assets/src/mybizna/vue3-sfc-loader

    mkdir ../assets/src/mybizna/assets

    cp -r resources/js/components ../assets/src/mybizna/components
    cp -r public/mybizna/css ../assets/src/mybizna/css
    cp -r public/mybizna/fonts ../assets/src/mybizna/fonts
    cp -r public/mybizna/images ../assets/src/mybizna/images
    cp -r public/mybizna/js ../assets/src/mybizna/js
    cp -r public/mybizna/tinymce ../assets/src/mybizna/tinymce
    cp -r public/mybizna/tailwind ../assets/src/mybizna/tailwind
    cp -r public/mybizna/fontawesome ../assets/src/mybizna/fontawesome
    cp -r public/mybizna/vue3-sfc-loader ../assets/src/mybizna/vue3-sfc-loader
}

commit_assets () {
    cd ../assets

    #sed -i s/$OLDVERSION/$VERSION/g  composer.json 
    jq ".version=\"$VERSION\"" composer.json > tmp_composer.json
    echo yes | mv tmp_composer.json composer.json

    git add .
    git commit --allow-empty -m "$MESSAGE"
    git push origin main
    git tag $VERSION
    git push --tags

    gh repo set-default
    gh release create $VERSION --generate-notes

    cd ../erp
}


commit_migration () {
    cd ../migration

    #sed -i s/$OLDVERSION/$VERSION/g  composer.json 
    jq ".version=\"$VERSION\"" composer.json > tmp_composer.json
    echo yes | mv tmp_composer.json composer.json

    git add .
    git commit --allow-empty -m "$MESSAGE"
    git push origin main
    git tag $VERSION
    git push --tags

    gh repo set-default
    gh release create $VERSION --generate-notes

    cd ../erp
}

commit_erp_versioned () {

    #sed -i s/$OLDVERSION/$VERSION/g  composer.json
    jq ".version=\"$VERSION\"" composer.json > tmp_composer.json
    echo yes | mv tmp_composer.json composer.json

    for module in `ls -U Modules| sort`; do
        jq ".version=\"$VERSION\"" Modules/$module/composer.json > Modules/$module/tmp_composer.json
        echo yes | mv Modules/$module/tmp_composer.json Modules/$module/composer.json
    done

    git submodule foreach git add .
    git submodule foreach git commit --allow-empty -m "$MESSAGE"
    git submodule foreach  git push origin main 

    git submodule foreach git tag $VERSION
    git submodule foreach git push --tags

    git add .
    git commit --allow-empty -m "$MESSAGE"
    git push origin main

    git tag $VERSION
    git push --tags

    git submodule foreach gh repo set-default
    git submodule foreach gh release create $VERSION --generate-notes
    
    gh repo set-default
    gh release create $VERSION --generate-notes
}
commit_erp () {
    git submodule foreach git add .
    git submodule foreach  git commit --allow-empty -m "$MESSAGE"
    git submodule foreach git push origin main
}

if [ $VERSION != $OLDVERSION ]
 then
    update_assets
    commit_assets
    commit_migration
    commit_erp_versioned

    if [ -d commands/ ]; then
        cd commands
        chmod +x process.sh && ./process.sh
    fi

else
    commit_erp
fi


echo "$VERSION" > 'version' 


