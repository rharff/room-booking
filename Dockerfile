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

# System deps + PHP extensions (IMPORTANT)
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

# Install PHP deps first (cache-friendly)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy application code
COPY . .

# Copy frontend build output
COPY --from=build /app/public/build ./public/build

# Create SQLite database (CRITICAL)
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
