# Utilisez une image de base officielle PHP avec Apache
FROM php:8.0-apache
WORKDIR /var/www/html
RUN docker-php-ext-install pdo pdo_mysql
COPY . /var/www/html/
EXPOSE 81
