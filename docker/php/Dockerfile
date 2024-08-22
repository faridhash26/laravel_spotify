
FROM php:8.1-fpm  as laravel_base

# Base PHP Image
FROM php:7.4-fpm as laravel_base

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

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . /var/www/tmp
RUN cd /var/www/tmp
RUN composer install 


FROM laravel_base
COPY ./nginx.conf /etc/nginx/nginx.conf
EXPOSE 80

CMD service php7.4-fpm start && nginx -g "daemon off;"