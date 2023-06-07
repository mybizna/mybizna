#!/bin/sh
# chmod +x pushtags.sh && ./pushtags.sh

echo "
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
Starting Commit Process
"
update_assets () {
    rm -r ../assets/src/mybizna/css
    rm -r ../assets/src/mybizna/images
    rm -r ../assets/src/mybizna/js
    rm -r ../assets/src/mybizna/tailwind
    rm -r ../assets/src/mybizna/tinymce
    rm -r ../assets/src/mybizna/vue3-sfc-loader

    mkdir ../assets/src/mybizna/assets

    cp -r public/mybizna/css ../assets/src/mybizna/css
    cp -r public/mybizna/images ../assets/src/mybizna/images
    cp -r public/mybizna/js ../assets/src/mybizna/js
    cp -r public/mybizna/tinymce ../assets/src/mybizna/tinymce
    cp -r public/mybizna/tailwind ../assets/src/mybizna/tailwind
    cp -r public/mybizna/fontawesome ../assets/src/mybizna/fontawesome
    cp -r public/mybizna/vue3-sfc-loader ../assets/src/mybizna/vue3-sfc-loader
}


commit_assets () {
    cd ../assets

    last_release_commit=$(git describe --abbrev=0 --tags)
    commit_count=$(git rev-list --count "$last_release_commit"..HEAD)

    if [ "$commit_count" -gt 0 ]; then

        # Get the current date and extract the year and week number
        current_year=$(date +%y)
        current_month=$(date +%m)

        # Extract the current version from the module's composer.json
        current_version=$(jq -r '.version' composer.json)

        major=$(echo "$current_version" | cut -d'.' -f1)
        minor=$(echo "$current_version" | cut -d'.' -f2)
        patch=$(echo "$current_version" | cut -d'.' -f3)

        # Reset the patch to zero at the start of each month
        if [ "$minor" != "$current_month" ]; then
            minor=$current_month
            patch=0
        else
            patch=$((patch + 1))
        fi

        major=$current_year
        minor=$current_month            

        # Construct the new version
        new_version="$major.$minor.$patch"

        MESSAGE="Release $new_version"

        jq ".version=\"$new_version\"" composer.json > tmp_composer.json
        echo yes | mv tmp_composer.json composer.json

        git add .
        git commit --allow-empty -m "$MESSAGE"
        git push origin main
        git tag $new_version
        git push --tags

        gh repo set-default
        gh release create $new_version --generate-notes

        cd ../erp

    fi
}


commit_migration () {
    cd ../migration

    last_release_commit=$(git describe --abbrev=0 --tags)
    commit_count=$(git rev-list --count "$last_release_commit"..HEAD)

    if [ "$commit_count" -gt 0 ]; then

        # Get the current date and extract the year and week number
        current_year=$(date +%y)
        current_month=$(date +%m)

        # Extract the current version from the module's composer.json
        current_version=$(jq -r '.version' composer.json)

        major=$(echo "$current_version" | cut -d'.' -f1)
        minor=$(echo "$current_version" | cut -d'.' -f2)
        patch=$(echo "$current_version" | cut -d'.' -f3)

        # Reset the patch to zero at the start of each month
        if [ "$minor" != "$current_month" ]; then
            minor=$current_month
            patch=0
        else
            patch=$((patch + 1))
        fi

        major=$current_year
        minor=$current_month            

        # Construct the new version
        new_version="$major.$minor.$patch"

        MESSAGE="Release $new_version"

        jq ".version=\"$new_version\"" composer.json > tmp_composer.json
        echo yes | mv tmp_composer.json composer.json

        git add .
        git commit --allow-empty -m "$MESSAGE"
        git push origin main
        git tag $new_version
        git push --tags

        gh repo set-default
        gh release create $new_version --generate-notes

    fi

    cd ../erp
}

commit_module () {
    for module in `ls -U Modules| sort`; do
        cd Modules/$module

        echo ""
        echo "-------------------"
        echo "Module $module"        

        last_release_commit=$(git describe --abbrev=0 --tags)
        commit_count=$(git rev-list --count "$last_release_commit"..HEAD)

        if [ "$commit_count" -gt 0 ]; then
            echo "There are $commit_count commit(s) from the last release."

            # Advance the version based on your requirements
            # Update the module's composer.json and perform necessary actions

            # Get the current date and extract the year and week number
            current_year=$(date +%y)
            current_month=$(date +%m)

            # Extract the current version from the module's composer.json
            current_version=$(jq -r '.version' composer.json)

            major=$(echo "$current_version" | cut -d'.' -f1)
            minor=$(echo "$current_version" | cut -d'.' -f2)
            patch=$(echo "$current_version" | cut -d'.' -f3)

            # Reset the patch to zero at the start of each month
            if [ "$minor" != "$current_month" ]; then
                minor=$current_month
                patch=0
            else
                patch=$((patch + 1))
            fi

            major=$current_year
            minor=$current_month            

            # Construct the new version
            new_version="$major.$minor.$patch"

            jq ".version=\"$new_version\"" composer.json > tmp_composer.json
            echo yes | mv tmp_composer.json composer.json

            MESSAGE="Release $new_version"

            git add .
            git commit --allow-empty -m "$MESSAGE"
            git push origin main

            git tag $new_version
            git push --tags

            gh repo set-default
            gh release create $new_version --generate-notes

            # Perform any necessary actions with the updated version

            echo "Version for module $module has been advanced to $new_version."
        else
            echo "There are no new commits since the last release."
        fi

        cd ../../

    done
}

commit_erp () {
    last_release_commit=$(git describe --abbrev=0 --tags)
    commit_count=$(git rev-list --count "$last_release_commit"..HEAD)

    if [ "$commit_count" -gt 0 ]; then

        update_assets

        commit_assets

        # Get the current date and extract the year and week number
        current_year=$(date +%y)
        current_month=$(date +%m)

        # Extract the current version from the module's composer.json
        current_version=$(jq -r '.version' composer.json)

        major=$(echo "$current_version" | cut -d'.' -f1)
        minor=$(echo "$current_version" | cut -d'.' -f2)
        patch=$(echo "$current_version" | cut -d'.' -f3)

        # Reset the patch to zero at the start of each month
        if [ "$minor" != "$current_month" ]; then
            minor=$current_month
            patch=0
        else
            patch=$((patch + 1))
        fi

        major=$current_year
        minor=$current_month            

        # Construct the new version
        new_version="$major.$minor.$patch"

        MESSAGE="Release $new_version"

        jq ".version=\"$new_version\"" composer.json > tmp_composer.json
        echo yes | mv tmp_composer.json composer.json

        git add .
        git commit --allow-empty -m "$MESSAGE"
        git push origin main
        git tag $new_version
        git push --tags

        gh repo set-default
        gh release create $new_version --generate-notes

    fi

}

commit_migration
commit_module
commit_erp


