# Use the official PHP 8.4 image
FROM php:8.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y unzip git && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory inside the container
WORKDIR /app

# Copy project files into the container
COPY . .

# Install PHP dependencies (Twig, etc.)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Expose Render’s default port
EXPOSE 10000

# Start the built-in PHP server from the public folder
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
