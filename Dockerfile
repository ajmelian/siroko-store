FROM php:8.3-apache

# Instalación de extensiones requeridas
RUN apt-get update
RUN apt-get install -y git unzip libicu-dev libzip-dev libpq-dev libxml2-dev
RUN apt-get install -y docker-php-ext-install intl pdo pdo_mysql zip

# Instala Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install

# Habilita mod_rewrite de Apache
RUN a2enmod rewrite

COPY php.ini /usr/local/etc/php/

EXPOSE 80

