FROM php:7.4-apache as laravel_base
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/1b137f8bf6db3e79a38a5bc45324414a6b1f9df2/web/installer -O - -q | php -- --quiet
RUN mv composer.phar /usr/local/bin/composer

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
    g++


RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    pdo_mysql
    



FROM node:14 as node_dependencies
WORKDIR /var/www/html
COPY --from=laravel_base /var/www/tmp /var/www/html
RUN npm install && \
    npm run production && \
    rm -rf node_modules

FROM laravel_base
RUN a2enmod rewrite
COPY --from=node_dependencies --chown=www-data:www-data /var/www/html/ /var/www/html/
COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf
RUN chmod +x /var/www/html/docker-entrypoint.sh
ENTRYPOINT [ "./docker-entrypoint.sh" ]
