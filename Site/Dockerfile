FROM php:7.2.25-fpm-buster

RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    zip \
    unzip\
	libmemcached-dev \
	libcurl4-nss-dev

RUN docker-php-ext-configure zip --with-libzip
RUN docker-php-ext-install pdo_mysql zip
