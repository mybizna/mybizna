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

-   PHP 7.0^


## Installation

```
git clone https://github.com/mybizna/mybizna

cd mybizna

composer install
composer dump-autoload -o

npm install
npm run build

php artisan lucid:migrate

php artisan tinker
$user = new App\Models\User();
$user->password = Hash::make('johndoe');
$user->email = 'johndoe@johndoe.com';
$user->name = 'John Doe';
$user->save();

php artisan mybizna:dataprocessor

php artisan vendor:publish --provider="Mybizna\Assets\Providers\MybiznaAssetsProvider"

```



## Who's behind?

An open-source project by [mybizna](https://mybizna.com/), contributed by a bunch of [people](https://github.com/mybizna/mybizna/graphs/contributors).
