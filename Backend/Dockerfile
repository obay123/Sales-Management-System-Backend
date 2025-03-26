# Stage 1: Composer Build
FROM composer:2 AS builder

# Use PHP 8.2 instead of the default 8.1 in the composer image
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo mbstring zip

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

COPY . .

# Stage 2: Runtime Environment
FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo_mysql mbstring zip

COPY --from=builder /app /app

EXPOSE 8000

CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
