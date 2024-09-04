FROM php:8.2-fpm-alpine

# نصب ابزارهای لازم
RUN apk add --no-cache \
    libzip-dev \
    unzip \
    oniguruma-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install \
    pdo_mysql \
    zip \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# نصب Composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    rm composer-setup.php
# ایجاد دایرکتوری برای پروژه
RUN mkdir -p /var/www/html

# کپی کردن کل پروژه به کانتینر
COPY ../ /var/www/html
# نصب وابستگی‌ها با Composer
RUN composer install --no-interaction --prefer-dist


# تنظیم کاربری
RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

# تغییر مالکیت دایرکتوری
RUN chown -R laravel:laravel /var/www/html

# تنظیم دایرکتوری کاری
WORKDIR /var/www/html

CMD ["php-fpm"]
