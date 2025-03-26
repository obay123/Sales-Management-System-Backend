# Stage 1: Build
FROM composer:2 as builder

# Set working directory
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the application
COPY . .

# Generate application key (optional: you can also do this on Railway)
RUN php artisan key:generate --force

# Cache config and routes
RUN php artisan config:cache && php artisan route:cache

# Stage 2: Run
FROM php:8.1-fpm

# Set working directory
WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring

# Copy the built application from the builder stage
COPY --from=builder /app /app

# Expose port (Railway will map its dynamic $PORT to this container port)
EXPOSE 8000

# Run the Laravel development server on the specified port or default to 8000.
CMD sh -c "php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"
