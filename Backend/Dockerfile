# Stage 1: Composer Build
FROM composer:2 as builder

WORKDIR /app

# Copy only composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the application
COPY . .

# Stage 2: Laravel Runtime
FROM php:8.1-cli

WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring

# Copy Laravel app from builder
COPY --from=builder /app /app

# Copy entrypoint script
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expose Railway-compatible port
EXPOSE 8000

# Start using entrypoint
CMD ["/entrypoint.sh"]
