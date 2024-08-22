# Base Image for Laravel
FROM php:7.4-apache as laravel_base

# Install necessary packages
RUN apt-get update && apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++ \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Create temporary directory
RUN mkdir -p /var/www/tmp

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Docker Compose
RUN curl -SL https://github.com/docker/compose/releases/download/v2.26.1/docker-compose-linux-x86_64 -o /usr/local/bin/docker-compose \
    && chmod +x /usr/local/bin/docker-compose

# Node Stage for Frontend (Optional)
FROM node:14 as node_dependencies
WORKDIR /var/www/tmp
COPY --from=laravel_base /v
