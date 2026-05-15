# --- Stage 1: Build Assets ---
FROM php:8.4-alpine as base

# Install System dependencies for building
RUN apk add --no-cache \
    bash \
    curl \
    git \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm

# Install PHP extensions for PHP 8.4
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_mysql gd zip bcmath intl opcache

WORKDIR /var/www


# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy only dependency files first to leverage Docker cache
COPY composer.json composer.lock package.json package-lock.json ./

ENV NOT_ARTISAN_DISCOVER=1

RUN composer install --no-dev --no-interaction --no-scripts --optimize-autoloader
RUN npm install

# Copy the rest of the application
COPY . .

# Finalize Composer and Build Assets
RUN composer dump-autoload --optimize --no-dev
RUN npm run build

# --- Stage 2: Final Production Image ---
FROM php:8.5-fpm-alpine
WORKDIR /var/www

# FIX: Unsafe path transitions by ensuring root ownership of system paths
# This resolves the warnings you saw in the logs
RUN chown root:root /var && chmod 755 /var && \
    chown root:root /var/log && chmod 755 /var/log

# Copy extensions and binaries from base
COPY --from=base /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=base /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d
COPY --from=base /usr/bin/composer /usr/bin/composer
COPY --from=base /var/www /var/www

# Set permissions for Laravel 13/PHP 8.5
# We give ownership to www-data ONLY for the app files
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Switch to the web user for security
USER www-data

EXPOSE 9000
CMD ["php-fpm"]