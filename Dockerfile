FROM php:8.1-apache

# Install mysqli extension and any dependencies
# RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli && docker-php-ext-enable xdebug
# RUN docker-php-ext-install mysqli && docker-php-ext-enable xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug && docker-php-ext-install mysqli

# Enable Apache modules
RUN a2enmod rewrite ssl