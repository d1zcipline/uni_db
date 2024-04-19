FROM php:fpm

RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable pdo pdo_mysql

RUN pecl install xdebug && docker-php-ext-enable xdebug