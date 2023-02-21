#!/bin/sh
# chmod +x package_post_build.sh && ./package_post_build.sh

rm -r public/mybizna/components 

mkdir public/mybizna/components

cp -r resources/js/components/  public/mybizna

rm -r public/mybizna/components/App.vue
rm -r public/mybizna/components/router

