FROM php:8.2-apache

# Installation des extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libssl-dev \
    libzstd-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Installation de l'extension MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Désactiver mpm_event, activer mpm_prefork
RUN if apache2ctl -M 2>/dev/null | grep -q 'mpm_event'; then \
        a2dismod mpm_event; \
    fi \
    && a2enmod mpm_prefork rewrite

COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Copie du projet dans /var/www/html
COPY . /var/www/html

# Permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80