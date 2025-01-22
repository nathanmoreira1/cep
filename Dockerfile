# Use the official PHP image with Apache
FROM php:8.2-apache

# Set the server name
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Enable the Apache rewrite module
RUN a2enmod rewrite

# Install necessary PHP extensions (if any)
RUN docker-php-ext-install opcache

# Install system dependencies for Composer
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy project files to the container
COPY . /var/www/html/

# Replace the Apache configuration file
COPY ./config/apache-default.conf /etc/apache2/sites-available/000-default.conf

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 80 to access the application
EXPOSE 80
