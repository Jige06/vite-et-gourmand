FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libssl-dev \
    libzstd-dev \
    zip \
    curl \
    && docker-php-ext-install pdo pdo_mysql zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && a2enmod rewrite

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY apache.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html

# Installation des dépendances Composer
RUN cd /var/www/html && composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/html

RUN echo '#!/bin/bash\n\
find /etc/apache2/mods-enabled/ -name "mpm_*.load" -delete\n\
find /etc/apache2/mods-enabled/ -name "mpm_*.conf" -delete\n\
ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load\n\
ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf\n\
apache2-foreground' > /start.sh && chmod +x /start.sh

EXPOSE 80
CMD ["/start.sh"]