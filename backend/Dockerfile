# Use PHP 8.2 as the base image
FROM php:8.2-fpm

# Install required extensions and tools
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql gd \
    && pecl install redis && docker-php-ext-enable redis

# Set the working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader --no-dev

# Set permissions
RUN chown -R www-data:www-data /var/www

# Expose port for Laravel
EXPOSE 8000

# Start PHP-FPM
CMD ["php-fpm"]
