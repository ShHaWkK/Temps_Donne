FROM php:8-apache

RUN apt-get update

# Installation de l'extension GD
RUN apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Installation de xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Installation de PDO
RUN docker-php-ext-install pdo pdo_mysql

# Installation des extensions PHP pour PostgreSQL
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql
