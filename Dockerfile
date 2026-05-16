# =========================================================
# Stage 1: Build Assets & Dependencies
# =========================================================
FROM php:8.4-fpm-alpine AS base

# Install build tools and Node.js for Filament asset compilation
RUN apk add --no-cache bash curl git zip unzip nodejs npm

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy dependency manifests
COPY composer.json composer.lock package.json package-lock.json ./

# Install backend dependencies (Ignore platform requirements for compilation stage)
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV NOT_ARTISAN_DISCOVER=1
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-reqs

# Install frontend tools for Filament plugins
RUN npm install

# Copy application source
COPY . .

# Remove cached local files to avoid environment pollution
RUN rm -rf bootstrap/cache/*.php

# Compile assets (Tailwind, Filament, Vite)
RUN npm run build

# Optimize Composer autoload map
RUN composer dump-autoload \
    --optimize \
    --no-dev \
    --classmap-authoritative \
    --ignore-platform-reqs

# =========================================================
# Stage 2: Production Runtime
# =========================================================
FROM php:8.4-fpm-alpine

WORKDIR /var/www

# Pull the installer utility directly from its official image layer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install base packages and compile the extensions natively inside the container
RUN apk add --no-cache bash curl && \
    install-php-extensions \
        pdo_mysql \
        mysqli \
        mbstring \
        bcmath \
        intl \
        zip \
        exif \
        pcntl \
        opcache \
        gd

# Copy application data directly from base stage
COPY --from=base /var/www /var/www

# Re-assign proper ownership and permissions for Laravel's log/cache folders
RUN mkdir -p storage/logs bootstrap/cache && \
    chown -R www-data:www-data /var/www && \
    chmod -R 775 storage bootstrap/cache

# Switch to non-root application user
USER www-data

EXPOSE 9000

CMD ["php-fpm"]
