FROM php:8-apache

RUN apt-get update

# Debugeur 
RUN pecl install xdebug && docker-php-ext-enable xdebug 

#Install PDO
RUN docker-php-ext-install pdo pdo_mysql

# PHP extensions

RUN apt-get update\ 
  && apt-get install -y libpq-dev \
  && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo pdo_pgsql pgsql
