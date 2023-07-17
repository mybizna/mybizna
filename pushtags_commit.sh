#!/bin/sh
# chmod +x pushtags_commit.sh && ./pushtags_commit.sh

cd Modules

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