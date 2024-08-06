#!/bin/sh
# chmod +x pushtags.sh && ./pushtags.sh



commit_modules () {

    cd Modules

    echo ""
    echo "-------------------"
    echo "Committing Modules that have changed"
    echo ""
    

    for module in `ls -Utr `; do

        echo ""
        echo "----------------------------------------"
        echo ""
        echo $module

        cd $module

        # Check if there are any changed files
        changed_files=$(git diff --name-only)
        if [ -z "$changed_files" ]; then
            echo "No changed files. Skipping..."
            cd ..
            continue
        fi

        git add .

        read -p "Enter commit message (or press Enter for default): " commit_message


        # Check if commit_message is empty
        if [ -z "$commit_message" ]; then
            commit_message="Changes to files: $changed_files"
        fi
        
        git commit -m "$commit_message"

        cd ..
    done
    
    cd ..
}


upload_modules () {
    echo ""
    echo "-------------------"
    echo "Committing Modules"
    echo ""

    for module in `ls -U Modules| sort`; do
        cd Modules/$module

        echo ""
        echo "-------------------"
        echo "Module $module"   
        echo ""    

        last_release_commit=$(git describe --abbrev=0 --tags)
        commit_count=$(git rev-list --count "$last_release_commit"..HEAD)

        if [ "$commit_count" -gt 0 ]; then
            echo "There are $commit_count commit(s) from the last release."

            # Advance the version based on your requirements
            # Update the module's composer.json and perform necessary actions

            # Extract the current version from the module's composer.json
            current_version=$(jq -r '.version' composer.json)

            major=$(echo "$current_version" | cut -d'.' -f1)
            minor=$(echo "$current_version" | cut -d'.' -f2)
            patch=$(echo "$current_version" | cut -d'.' -f3)

            # Increment the patch number with a maximum value of 50
            if [ "$patch" -lt 50 ]; then
                patch=$(expr $patch + 1)  
            else
                minor=$(expr $minor + 1)  
                patch=1
            fi                

            # Pad the patch number with three zeros
            patch=$(printf "%03d" $patch)  

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
    echo ""
    echo "-------------------"
    echo "Committing ERP"
    echo ""


    # Check if there are any changed files
    changed_files=$(git diff --name-only)
    if [ -z "$changed_files" ]; then
        echo "No changed files. Skipping..."
    else
        read -p "Enter commit message for ERP (or press Enter for default): " commit_message

        # Check if commit_message is empty
        if [ -z "$commit_message" ]; then
            commit_message="Changes to files: $changed_files"
        fi
        
        git add .
        git commit -m "$commit_message"
        git push origin main
    fi

    last_release_commit=$(git describe --abbrev=0 --tags)
    commit_count=$(git rev-list --count "$last_release_commit"..HEAD)

    if [ "$commit_count" -gt 0 ]; then

        # Extract the current version from the module's composer.json
        current_version=$(jq -r '.version' composer.json)

        major=$(echo "$current_version" | cut -d'.' -f1)
        minor=$(echo "$current_version" | cut -d'.' -f2)
        patch=$(echo "$current_version" | cut -d'.' -f3)

        # Increment the patch number with a maximum value of 50
        if [ "$patch" -lt 50 ]; then
            patch=$(expr $patch + 1)  
        else
            minor=$(expr $minor + 1)  
            patch=1
        fi                

        # Pad the patch number with three zeros
        patch=$(printf "%03d" $patch)  
      

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

commit_modules
upload_modules
commit_erp


