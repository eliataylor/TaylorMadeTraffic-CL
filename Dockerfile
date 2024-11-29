FROM php:8.1-apache

# Install mysqli extension and any dependencies
RUN apt-get update && apt-get install -y \
    && docker-php-ext-install mysqli && docker-php-ext-enable mysqli \
    && docker-php-ext-enable xdebug

# Enable Apache modules
RUN a2enmod rewrite ssl
