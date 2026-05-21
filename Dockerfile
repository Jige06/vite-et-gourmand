FROM php:8.2-apache

# Installation des extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libssl-dev \
    libzstd-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Désactiver tous les MPM et réactiver uniquement prefork
RUN find /etc/apache2/mods-enabled/ -name "mpm_*.load" -delete \
    && find /etc/apache2/mods-enabled/ -name "mpm_*.conf" -delete \
    && ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load \
    && ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf \
    && a2enmod rewrite

COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Copie du projet dans /var/www/html
COPY . /var/www/html

# Permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80