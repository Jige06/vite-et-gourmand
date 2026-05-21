FROM php:8.2-apache

# Installation des extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libssl-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Installation de l'extension MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Activation du module rewrite Apache
RUN a2enmod rewrite

# Copie du projet dans /var/www/html
COPY . /var/www/html

# Configuration Apache - document roo sur le dossier public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80