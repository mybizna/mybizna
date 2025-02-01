#!/bin/sh
# chmod +x pushtags.sh && ./pushtags.sh

echo "
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
Starting Commit Process
"

release_modules () {

    local commit_message="$1"
    local action="$2"

    echo ""
    echo "-------------------"
    echo "Committing Modules"
    echo ""
    echo "$commit_message"
    echo ""

    for module in `ls -U Modules| sort`; do
        cd Modules/$module

        echo ""
        echo "-------------------"
        echo "Module $module"
        echo ""

        # Check if there are any changed files
        changed_files=$(git diff --name-only)
        if [ -z "$changed_files" ]; then
            echo "No changed files. Skipping..."
            cd ../../
            continue
        fi


        # Check if commit_message is empty
        if [ -z "$commit_message" ]; then
            commit_message="Changes to files: $changed_files"
        fi

        git add .
        git commit -m "$commit_message"
        git push origin main

        if [ -z "$action" ] || [ "$action" != "y" ]; then
            cd ../../
            continue
        fi

        last_release_commit=$(git describe --abbrev=0 --tags)
        commit_count=$(git rev-list --count "$last_release_commit"..HEAD)

        if [ "$commit_count" -gt 0 ]; then
            echo "There are $commit_count commit(s) from the last release."

            # Advance the version based on your requirements
            # Update the module's composer.json and perform necessary actions

            # Extract the current version from the module's composer.json
            current_version=$(jq -r '.version' composer.json)

            # Extract the major and patch versions
            current_major=$(echo "$current_version" | cut -d'.' -f1)
            current_patch=$(echo "$current_version" | cut -d'.' -f2)

            # Get the current year
            major=$(date +%Y)

            # If the year has changed, reset patch to 1; otherwise, increment it
            if [ "$major" -ne "$current_major" ]; then
                patch=1
            else
                patch=$(expr $current_patch + 1)
            fi

            # Pad the patch number with three zeros
            patch=$(printf "%03d" $patch)

            # Construct the new version
            new_version="$major.$patch"

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

release_erp () {
    local commit_message="$1"
    local action="$2"

    echo ""
    echo "-------------------"
    echo "Committing ERP"
    echo ""


    # Check if there are any changed files
    changed_files=$(git diff --name-only)
    if [ -z "$changed_files" ]; then
        echo "No changed files. Skipping..."
        exit 0
    fi

    # Check if commit_message is empty
    if [ -z "$commit_message" ]; then
        commit_message="Changes to files: $changed_files"
    fi

    git add .
    git commit -m "$commit_message"
    git push origin main

    if [ -z "$action" ] || [ "$action" != "y" ]; then
        exit 0
    fi

    last_release_commit=$(git describe --abbrev=0 --tags)
    commit_count=$(git rev-list --count "$last_release_commit"..HEAD)

    if [ "$commit_count" -gt 0 ]; then

        # Extract the current version from the module's composer.json
        current_version=$(jq -r '.version' composer.json)

        # Extract the major and patch versions
        current_major=$(echo "$current_version" | cut -d'.' -f1)
        current_patch=$(echo "$current_version" | cut -d'.' -f2)

        # Get the current year
        major=$(date +%Y)

        # If the year has changed, reset patch to 1; otherwise, increment it
        if [ "$major" -ne "$current_major" ]; then
            patch=1
        else
            patch=$(expr $current_patch + 1)
        fi

        # Pad the patch number with three zeros
        patch=$(printf "%03d" $patch)

        # Construct the new version
        new_version="$major.$patch"

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

read -p "Enter commit message (or press Enter for default): " commit_message

read -p "Do want to run release?: y/n" action

release_modules "$commit_message" "$action"
release_erp  "$commit_message" "$action"


