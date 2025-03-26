# Stage 1: Composer Build
FROM composer:2 as builder

WORKDIR /app

# Copy only composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the application
COPY . .

# Stage 2: Runtime Environment
FROM php:8.1-cli

WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring

# Copy application from builder
COPY --from=builder /app /app

# Expose Railway-compatible port
EXPOSE 8000

# Run Laravel commands at runtime
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
