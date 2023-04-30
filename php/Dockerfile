FROM php:8.2.0-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y libpq-dev \
&& docker-php-ext-install pdo pdo_pgsql pgsql mysqli

ADD ./php.ini /usr/local/etc/php/php.ini