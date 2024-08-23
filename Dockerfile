# Base Image for Laravel
FROM php:8.2-fpm

# نصب Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update && apt-get install -y nano
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
    nginx

RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    pdo_mysql
# تنظیمات PHP-FPM
RUN sed -i 's!listen = /run/php/php8.2-fpm.sock!listen = 127.0.0.1:9000!g' /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www/html

COPY . /var/www/html

# تنظیمات Nginx
COPY ./nginx.conf /etc/nginx/nginx.conf

RUN chmod +x /var/www/html/docker-entrypoint.sh

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

ENTRYPOINT [ "./docker-entrypoint.sh" ]

# اجرا و راه‌اندازی Nginx و PHP-FPM
CMD ["sh", "-c", "nginx && php-fpm"]

# پورت‌های قابل استفاده
EXPOSE 80
