FROM php:7.2.25-fpm-buster

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        git \
        unzip \
        libzip-dev \
        zip \
        unzip\
    	libmcrypt-dev \
        libpcre3-dev \
	    libcurl4-nss-dev \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN pecl channel-update pecl.php.net && \
    pecl install psr phalcon

RUN cd ~ && \
    touch 30-psr.ini && \
    echo 'extension=psr.so' > 30-psr.ini && \
    cp 30-psr.ini /usr/local/etc/php/conf.d/30-psr.ini && \
    touch 50-phalcon.ini && \
    echo 'extension=phalcon.so' > 50-phalcon.ini && \
    cp 50-phalcon.ini /usr/local/etc/php/conf.d/50-phalcon.ini

RUN curl --silent --show-error https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer
