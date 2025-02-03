FROM php:8.1-apache

# Install mysqli extension and any dependencies
# RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli && docker-php-ext-enable xdebug
# RUN docker-php-ext-install mysqli && docker-php-ext-enable xdebug
RUN if ! php -m | grep -q 'xdebug'; then pecl install xdebug && docker-php-ext-enable xdebug; fi
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable Apache modules
RUN a2enmod rewrite ssl