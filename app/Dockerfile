# Dockerfile for PHP Application
FROM php:8.2-apache

# Set the working directory
WORKDIR /var/www/html

# Copy application code to the container
COPY . /var/www/html

# Install required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Expose the default web server port
EXPOSE 80