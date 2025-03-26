# Stage 1: Build with Composer and PHP 8.2
FROM php:8.2-cli AS builder

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libonig-dev libxml2-dev libpng-dev \
    && docker-php-ext-install pdo mbstring zip gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

# ✅ Copy full app source including artisan before running Composer
COPY . .

# Install PHP dependencies (without dev packages)
RUN composer install --no-dev --optimize-autoloader

# Stage 2: Runtime environment with PHP 8.2
FROM php:8.2-cli

# Install runtime dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libonig-dev libxml2-dev libpng-dev \
    && docker-php-ext-install pdo_mysql mbstring zip gd

WORKDIR /app

# Copy built app from builder stage
COPY --from=builder /app /app

EXPOSE 8000

# Cache config, routes, and serve the app
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
