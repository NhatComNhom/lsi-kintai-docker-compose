FROM php:8.2.0-fpm

WORKDIR /var/www/html

RUN apt-get update \
    && docker-php-ext-install mysqli

ADD ./php.ini /usr/local/etc/php/php.ini