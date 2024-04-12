# Start from the official PHP 8.3 image with FPM
FROM php:8.3.4-fpm

# Set working directory
WORKDIR /app

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug || echo "Xdebug already installed"

# Add Xdebug configuration
RUN echo 'xdebug.mode = debug' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.start_with_request = trigger' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.client_host = host.docker.internal' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.client_port = 9003' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.log = /var/tmp/xdebug.log' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the application's code to the working directory
COPY . /app

# Install PHP dependencies with Composer
# Consider running composer install with --no-dev for production environments
RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader && rm -rf /root/.composer

# Dump autoload
RUN composer dump-autoload --no-scripts --no-dev --optimize
