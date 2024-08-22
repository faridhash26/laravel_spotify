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
COPY --from=laravel_base /var/www/tmp /var/www/tmp
RUN npm install && \
    npm run production && \
    rm -rf node_modules

# Main Laravel Application
FROM laravel_base
RUN a2enmod rewrite
COPY --from=node_dependencies --chown=www-data:www-data /var/www/tmp/ /var/www/html/
COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf

# Run Composer install and set permissions
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy and set entrypoint
COPY ./docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
