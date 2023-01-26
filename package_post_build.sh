#!/bin/sh
# chmod +x package_post_build.sh && ./package_post_build.sh

rm -r public/mybizna/assets 

mkdir public/mybizna/assets
mkdir public/mybizna/assets/components

cp -r resources/js/components/  public/mybizna/assets

rm -r public/mybizna/assets/components/App.vue
rm -r public/mybizna/assets/components/router

