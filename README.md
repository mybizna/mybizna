<p align="center"><a href="https://mybizna.com" target="_blank"><img src="http://mybizna.com/wp-content/uploads/2021/11/logo.png" width="400"></a></p>


<a href="https://packagist.org/packages/mybizna/mybizna"><img src="https://img.shields.io/packagist/dt/mybizna/mybizna" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/mybizna/mybizna"><img src="https://img.shields.io/packagist/v/mybizna/mybizna" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/mybizna/mybizna"><img src="https://img.shields.io/packagist/l/mybizna/mybizna" alt="License"></a>
</p> 

## About Mybizna

Mybizna is an open-source ERP (Enterprise Resource Planning) solution for Laravel. It is developed using laravel which is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. 

<figure><img src="https://files.gitbook.com/v0/b/gitbook-x-prod.appspot.com/o/spaces%2F0dkrQE1EPlRKzUjTpBUW%2Fuploads%2FmpawOQoIdwsBw6kqcKmi%2FMybizna-Dashboard.png?alt=media&token=46a1efb4-3b78-4de1-aa30-6fb7189add10" alt=""><figcaption></figcaption></figure>


## Minimum Requirement

-   PHP 8.1^


## Installation

### How to setup using Docker
```
git clone https://github.com/mybizna/mybizna.git

cd mybizna

docker compose up --build
```

To add more modules, add them in file ``` entrypoint-composers.sh ``` with content

```
#!/bin/sh

cd /var/www/html 

# Require additional composer packages
composer require mybizna/isp --no-interaction

```

### How to setup on the system
```
composer create-project mybizna/setup mybizna
```

### How to Install in Laravel
<a href="https://mybizna.gitbook.io/mybizna-erp/readme/how-to-install-on-laravel" target="_blank">How to Install in Laravel</a>

### How to Install in Wordpress
<a href="https://mybizna.gitbook.io/mybizna-erp/readme/how-to-installation-in-wordpress" target="_blank">How to Install in Wordpress</a>

## How to Participate
<a href="https://mybizna.gitbook.io/mybizna-erp/readme/readme/how-to-participate" target="_blank">How to Participate</a>

## Who's behind?

An open-source project by [mybizna](https://mybizna.com/) contributed by a bunch of [people](https://github.com/mybizna/mybizna/graphs/contributors).