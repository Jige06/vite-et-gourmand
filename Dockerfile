FROM php:8.2-apache

# Installation des extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libssl-dev \
    libzstd-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && sed -i 's/^LoadModule mpm_event/#LoadModule mpm_event/' /etc/apache2/mods-enabled/mpm_event.load \
    && a2enmod mpm_prefork rewrite

COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Copie du projet dans /var/www/html
COPY . /var/www/html

# Permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80