# Gunakan base image resmi PHP 8.4 FPM
FROM php:8.4-fpm-alpine

WORKDIR /var/www

# TAMBAHKAN icu-dev di sini
RUN apk add --no-cache \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    jpeg-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev \
    curl \
    git \
    icu-dev;

# Install ekstensi PHP yang dibutuhkan Laravel
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl;

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ganti ke user non-root
USER www-data

EXPOSE 9000