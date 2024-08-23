# Use the official PHP image as the base image
FROM php:8.2-fpm
dockerfile

Copy
# Use the official PHP image as the base image
FROM php:8.1-fpm

# Set the working directory
WORKDIR /var/www/html

# Copy the application code
COPY . .

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel dependencies
RUN composer install --no-scripts --no-dev --prefer-dist

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose the port
EXPOSE 9000

# Start the PHP-FPM server
CMD ["php-fpm"]



dockerfile

Copy
# Use the official Nginx image as the base image
FROM nginx:latest

# Set the working directory
WORKDIR /var/www/html

# Copy the Nginx configuration file
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Expose the port
EXPOSE 80

# Start Nginx
CMD ["nginx", "-g", "daemon off;"]
