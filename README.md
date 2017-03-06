Packagist-mirrors
========================
#### Download `packagist.org` All file to local,make mirrors site!

### Requirement
------------------
```
- PHP > 5.3
- ext-curl
- ext-hash
- ext-json
- ext-zlib
- ext-PDO
- ext-pdo\_sqlite
```
### Install
------------------

```sh 
$ git clone https://github.com/hirak/packagist-crawler
$ cd packagist-crawler
$ composer install
```
---------------------
Download!
------------------

```sh
$ php parallel.php

(...few minutes...)

$ ls cache/
p/
packages.json
```
----------------------------------------
Configuration
------------------
```
- config.default.php
- config.php
```
#### If you want to modify the `default.config.php`,Please copy it , rename as `config.php`.
----------------------------------------
### config.default.php
```php
<?php
return (object)array(
    'cachedir' => __DIR__ . '/cache/',
    //'cachedir' => '/usr/share/nginx/html/',
    //'cachedir' => '/usr/local/apache2/htdocs/',
    'packagistUrl' => 'https://packagist.org',
    'maxConnections' => 4,
    'lockfile' => __DIR__ . '/cache/.lock',
    'expiredDb' => __DIR__ . '/cache/.expired.db
);
//#################################################################
//#               Parameter description                           #
//#################################################################
$cachedir； Download File Store directory

$packagistUrl： Composer origin(packagist.org) site, you can modify value to another Composer mirrors url!

$maxConnections： The number of parallel downloading Multithread.

$expiredDb： To update file is recorded by the JSON.
```