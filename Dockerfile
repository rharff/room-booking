# --------------------
# Frontend build stage
# --------------------
FROM node:20 AS build

WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# --------------------
# Backend runtime stage
# --------------------
FROM php:8.2-apache

# System deps + PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
 && docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_sqlite \
    bcmath \
    zip \
    opcache \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

# Enable Apache rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# --- FIX START ---
# 1. Install PHP deps WITHOUT scripts (avoids the "missing artisan" error)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# 2. Copy the actual application code (including artisan)
COPY . .

# 3. Now that the code is present, finish the composer dump and run scripts
RUN composer dump-autoload --optimize --no-dev
# --- FIX END ---

# Copy frontend build output
COPY --from=build /app/public/build ./public/build

# Create SQLite database
RUN mkdir -p database \
 && touch database/database.sqlite \
 && chown -R www-data:www-data database storage bootstrap/cache

# Apache document root to /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
 && sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/apache2.conf

EXPOSE 80