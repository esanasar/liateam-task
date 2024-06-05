# Use an official PHP runtime as a parent image
FROM php:8.2-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk add --no-cache linux-headers libxml2-dev libzip-dev curl-dev \
    && docker-php-ext-install sockets curl pdo pdo_mysql soap


RUN apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS\
    && apk add autoconf
## Install build dependencies for xdebug
#RUN apk add --no-cache --virtual .build-dependencies $PHPIZE_DEPS autoconf \
#    && pecl install xdebug \
#    && docker-php-ext-enable xdebug \
#    && apk del .build-dependencies

#RUN apt-get update && apt-get install -y \
#    libzip-dev \
#    zlib1g-dev \
#    unzip \
#    && docker-php-ext-install zip pdo pdo_mysql

# Install MongoDB extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

#Install Composer
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /www/main

RUN apk add --no-cache poppler-utils

# Copy application files
# COPY . .

# Set permissions for www-data user
RUN #chown -R www-data:www-data /www/main

# Expose port 8000 and start php-fpm server
# EXPOSE 8000

CMD ["sh", "-c", "composer install && php artisan key:generate && php artisan storage:link && php-fpm"]
