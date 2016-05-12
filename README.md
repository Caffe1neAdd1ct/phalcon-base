# Phalcon Base Application

## Intro

A collection of boilerplate code for Phalcon Framework projects to enable even faster project setup and development.


## Setup

    git clone git@github.com:Caffe1neAdd1ct/phalcon-base.git


### Compiling Phalcon

    git clone --depth=1 git://github.com/phalcon/cphalcon.git
    cd cphalcon/build
    sudo ./install

If needed change the PHP executable path inside `install`, some installations are suffixed e.g php55 php56


### Installing dependencies via Composer

    cd phalcon-base/
    /usr/bin/php /path/to/composer.phar install --dev


### PHP In Built Web Server

    cd phalcon-base/
    /usr/bin/php -S localhost:8000 -t public public/htrouter.php

The PHP inbuilt webserver should only be used for development purposes.


### Application Settings


#### Database
    adapter  - Mysql Sqlite
    host     - 127.0.0.1
    user     - notroot?
    password - secret
    dbname   - schema or filename
    dbdir    - only for sqlite, path to db file.


#### Url / Routing
    host    - domain / host
    baseUri - /subdirectory/ if not straight inside the document root


#### Mail
    server   - localhost
    username - me@mailbox.com
    password - secret
    port     - 1025 (default for mailcatcher)
    security - none or tls or ssl
    from     - app@localhost
    name     - App Name

### Mailcatcher

#### rbenv


#### bundler



#### mailcatcher standalone





