# Phalcon Base Application

## Intro

A collection of boilerplate code for Phalcon Framework projects to enable even faster project setup and development.


## Setup

git clone git@github.com:Caffe1neAdd1ct/phalcon-base.git


### Composer

    cd phalcon-base/
    /usr/bin/php /path/to/composer.phar install --dev


### PHP In Built Web Server

    cd phalcon-base/
    /usr/bin/php -S localhost:8000 -t public public/htrouter.php


### Compiling Phalcon

    git clone --depth=1 git://github.com/phalcon/cphalcon.git
    cd cphalcon/build
    sudo ./install

If needed change the php executable path inside `install`, some installations are suffixed e.g php55 php56

### Application Settings

#### Database
    adapter - Mysql Sqlite
    host - 127.0.0.1
    user - notroot?
    password - secret
    dbname - schema or filename
    dbdir - only for sqlite, path to db file.
#### Url / Routing
    host - domain / host
    baseUri - /subdirectory/ if not straight inside the document root

### Mailcatcher

#### rbenv


#### bundler



#### mailcatcher standalone





