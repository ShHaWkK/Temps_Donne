# Étape de build (développement)
FROM php:8-apache AS build

# Mise à jour des packages système et installation des dépendances en une seule commande pour minimiser les couches
RUN apt-get update && apt-get install -y \
    libpq-dev \
    $PHPIZE_DEPS && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pgsql && \
    apt-get clean && \
    # Nettoyage après installation pour réduire la taille de l'image
    rm -rf /var/lib/apt/lists/*  

# Étape finale (production)
FROM php:8-apache

# Copie des extensions et configurations de PHP depuis l'étape de build
COPY --from=build /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=build /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# Copier les fichiers nécessaires de l'application du répertoire de build vers le répertoire de serveur web
COPY ./api /var/www/html/
