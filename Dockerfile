# Use the official PHP 8.4 image with Apache
FROM php:8.4-apache

# Install required system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev && \
    docker-php-ext-install pdo pdo_mysql zip && \
    a2enmod rewrite

# Set working directory inside container
WORKDIR /var/www/html

# Copy all project files to container
COPY . .

# Install Composer (copy from official Composer image)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependenci
