# Use the official PHP image with Apache for PHP 8.2
FROM php:8.2-apache

# Install additional dependencies
RUN apt-get update && \
    apt-get install -y \
        libonig-dev \
        libzip-dev \
        unzip \
        && \
    docker-php-ext-install pdo_mysql mbstring zip && \
    a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy only the composer files to leverage Docker layer caching
COPY composer.json composer.lock /var/www/html/

# Install Laravel dependencies
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application code
COPY . /var/www/html/

# Generate the autoload files
#RUN composer dump-autoload --optimize

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]

