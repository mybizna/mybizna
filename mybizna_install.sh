#!/bin/bash
# chmod +x mybizna_install.sh && ./mybizna_install.sh . testlaravel


# Function to validate folder path
validate_folder_path() {
    local folder_path=$1

    # Check if folder path is provided
    if [[ -z "$folder_path" ]]; then
        echo "Error: Folder path cannot be empty."
        return 1
    fi

    # Check if folder path exists
    if [[ ! -d "$folder_path" ]]; then
        echo "Error: Folder path '$folder_path' does not exist."
        return 1
    fi

    return 0
}

# Function to validate script name
validate_string() {
    local name=$1

    # Check if script name is provided
    if [[ -z "$name" ]]; then
        return 1
    fi

    # Add additional script name validation logic here if required

    return 0
}

# Check if folder path and script name are provided as parameters
if [[ $# -ne 2 ]]; then
    echo "Usage: $0 <folder_path> <project_name>"
    exit 1
fi

# Extract folder path and script name from the parameters
folder_path=$1
project_name=$2

# Validate folder path
if ! validate_folder_path "$folder_path"; then
    exit 1
fi

# Validate script name
if ! validate_string "$project_name"; then
    echo "Error: Project name cannot be empty."
    exit 1
fi

# Prompt for Mysql Host
read -p "Enter Mysql Host (default is localhost): " -e db_host
db_host="${name:-localhost}"
if ! validate_string "$db_host"; then
    echo "Error: Mysql Host cannot be empty."
    exit 1
fi

# Prompt for Mysql Host
read -p "Enter Mysql Port (default is 3306):" -e  db_port
db_port="${name:-3306}"
if ! validate_string "$db_port"; then
    echo "Error: Mysql Port cannot be empty."
    exit 1
fi


# Prompt for Mysql Username
read -p "Enter Mysql Username: " db_username
if ! validate_string "$db_username"; then
    echo "Error: Mysql Username cannot be empty."
    exit 1
fi

# Prompt for Mysql Password
read  -s -p "Enter Mysql Password: " db_password
if ! validate_string "$db_password"; then
    echo "Error: Mysql Password cannot be empty."
    exit 1
fi
echo ""

# Prompt for Mysql Database
read -p "Enter Mysql Database: " db_name
if ! validate_string "$db_name"; then
    echo "Error: Mysql Database cannot be empty."
    exit 1
fi

mysql_cmd="mysql  -h $db_host  -P $db_port -u $db_username  -p$db_password"

echo $mysql_cmd

# Test the connection by executing a simple query
query="SELECT 1"
if echo "$query" | $mysql_cmd -D "$db_name" >/dev/null 2>&1; then
    echo "MySQL connected successfully."
else
    read -p "Failed to connect to MySQL. Do you want to create the database?  (default is Y) [y/N]: " create_db
    create_db="${name:-y}"

    if [[ $create_db =~ ^[Yy]$ ]]; then
        # Create the database
        create_db_query="CREATE DATABASE $db_name;"
        echo "$create_db_query" | $mysql_cmd -u "$db_username" -p"$db_password" >/dev/null 2>&1

        if echo "$query" | $mysql_cmd -D "$db_name" >/dev/null 2>&1; then
            echo "MySQL connected successfully after creating the database."
        else
            echo "Error: Failed to connect to MySQL after creating the database."
            exit 1
        fi
    else
        echo "MySQL connection aborted. Database not created."
        exit 1
    fi
fi

# Construct the full path for script installation
install_path="$folder_path/$project_name"

composer create-project laravel/laravel:^9.0 $install_path

# Copy the script to the installation path
cd $install_path

#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

sed -i "s/^DB_HOST=.*/DB_HOST=127.0.0.1/" .env
sed -i "s/^DB_PORT=.*/DB_PORT=3306/" .env
sed -i "s/^DB_DATABASE=.*/DB_DATABASE=$db_name/" .env
sed -i "s/^DB_USERNAME=.*/DB_USERNAME=$db_username/" .env
sed -i "s/^DB_PASSWORD=.*/DB_PASSWORD=$db_password/" .env

sed -i "s/^CACHE_DRIVER=.*/CACHE_DRIVER=database/" .env
sed -i "s/^SESSION_DRIVER=.*/SESSION_DRIVER=database/" .env

sed -i '/^SESSION_LIFETIME=.*/aSANCTUM_STATEFUL_DOMAINS=' .env
sed -i '/^SESSION_LIFETIME=.*/aSESSION_DOMAIN=' .env


#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

# Specify the path to the User.php file
user_model_path="app/Models/User.php"

# Check if the User.php file exists
if [[ -f "$user_model_path" ]]; then

    # Add the "use Spatie\Permission\Traits\HasRoles;" line after "use Laravel\Sanctum\HasApiTokens;"
    sed -i '/use Laravel\\Sanctum\\HasApiTokens;/a\
use Spatie\\Permission\\Traits\\HasRoles;\
' "$user_model_path"

   # Add the "use HasRoles;" line on the first occurrence of "{"
    sed -i '/{/{s/{/{\
    use HasRoles;/;:a;n;ba}' "$user_model_path"

    # Add the lines to the User model
    sed -i "/protected \$fillable = \[/a\
    'username',\n\
    'is_admin',\n\
    'phone',\
" "$user_model_path"
    echo "User model updated successfully."
else
    echo "Error: User model file not found at $user_model_path."
fi


#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

# Specify the path to the Kernel.php file
kernel_file_path="app/Http/Kernel.php"

# Check if the file exists
if [[ -f "$kernel_file_path" ]]; then
    # Remove the comment from the specified line
    sed -i 's#// \\Laravel\\Sanctum\\Http\\Middleware\\EnsureFrontendRequestsAreStateful::class,#\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,#' "$kernel_file_path"

    echo "Comment removed successfully."
else
    echo "Error: Kernel.php file not found at $kernel_file_path."
fi


#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx


# Prompt for ERP Admin Username
read -p "Enter ERP Admin Name: " erp_name
if ! validate_string "$erp_name"; then
    echo "Error: ERP Admin Name cannot be empty."
    exit 1
fi


# Prompt for ERP Admin Username
read -p "Enter ERP Admin Username: " erp_username
if ! validate_string "$erp_username"; then
    echo "Error: ERP Admin Username cannot be empty."
    exit 1
fi


# Prompt for ERP Admin Password
read -p "Enter ERP Admin Password: " erp_password
if ! validate_string "$erp_password"; then
    echo "Error: ERP Admin Password cannot be empty."
    exit 1
fi


# Prompt for ERP Admin Email
read -p "Enter ERP Admin Email: " erp_email
if ! validate_string "$erp_email"; then
    echo "Error: ERP Admin Email cannot be empty."
    exit 1
fi


# Prompt for ERP Admin Email
read -p "Enter ERP Admin Phone: " erp_phone
if ! validate_string "$erp_phone"; then
    echo "Error: ERP Admin Phone cannot be empty."
    exit 1
fi


php artisan tinker <<EOF

use Illuminate\Support\Facades\Hash;

\$user = new App\Models\User();
\$user->password = Hash::make('$erp_password');
\$user->email = '$erp_email';
\$user->name = '$erp_name';
\$user->is_admin = 1;
\$user->username = '$erp_username';
\$user->phone = '$erp_phone';
\$user->save();
exit
EOF


#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

composer require mybizna/account

php artisan cache:table
php artisan session:table
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan vendor:publish --provider="Mybizna\Assets\Providers\MybiznaAssetsProvider"
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"


#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

php artisan automigrator:migrate

php artisan module:enable

php artisan mybizna:dataprocessor

php artisan key:generate

echo "Script installed successfully at $install_path."