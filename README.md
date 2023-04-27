<p align="center"><a href="https://mybizna.com" target="_blank"><img src="http://mybizna.com/wp-content/uploads/2021/11/logo.png" width="400"></a></p>


<a href="https://packagist.org/packages/mybizna/mybizna"><img src="https://img.shields.io/packagist/dt/mybizna/mybizna" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/mybizna/mybizna"><img src="https://img.shields.io/packagist/v/mybizna/mybizna" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/mybizna/mybizna"><img src="https://img.shields.io/packagist/l/mybizna/mybizna" alt="License"></a>
</p> 

## About Mybizna

Mybizna is an open-source ERP (Enterprise Resource Planning) solution for Laravel. It is developed using laravel which is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. 


## Core Components

-   HRM - Human Resource Management
-   CRM - Customer Relationship Management
-   Accounting - Double Entry Accounting


## Minimum Requirement

-   PHP 8.1^


## Installation

```
composer create-project laravel/laravel:^9.0 mybizna

cd mybizna/

composer require mybizna/account

// Configure Database in .env

// Edit app/Models/Users.php
protected $fillable = [
        ....
        'username',
        'is_admin',
        'phone',
];

// Add class
use Spatie\Permission\Traits\HasRoles;
// Add Trait
use  HasRoles;

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

php artisan automigrator:migrate

php artisan mybizna:dataprocessor

php artisan module:enable

php artisan key:generate

php artisan serve

```

## How to Participate

```
git clone --depth 1 https://github.com/mybizna/mybizna

cd mybizna

git submodule init
git submodule update
git submodule foreach 'git fetch origin; git checkout $(git rev-parse --abbrev-ref HEAD); git reset --hard origin/$(git rev-parse --abbrev-ref HEAD); git submodule update --recursive; git clean -dfx'

cp .env.example .env

composer install
composer dump-autoload -o

php artisan automigrator:migrate

php artisan tinker
$user = new App\Models\User();
$user->password = Hash::make('johndoe');
$user->email = 'johndoe@johndoe.com';
$user->name = 'John Doe';
$user->username = 'johndoe';
$user->phone = '0723232323';
$user->save();

php artisan mybizna:dataprocessor

php artisan vendor:publish --provider="Mybizna\Assets\Providers\MybiznaAssetsProvider"

php artisan key:generate

php artisan serve

```

If you want to run build for js and css Resources from scratch.

```

npm install
npm run build

```

## Who's behind?

An open-source project by [mybizna](https://mybizna.com/), contributed by a bunch of [people](https://github.com/mybizna/mybizna/graphs/contributors).
