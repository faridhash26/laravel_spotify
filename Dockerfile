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
    libzip-dev \
    && docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    pdo_mysql \
    zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Main Laravel Application
FROM laravel_base
RUN a2enmod rewrite
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Run Composer install and set permissions
RUN composer install --no-dev --optimize-autoloader -vvv
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy and set entrypoint
COPY ./docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
