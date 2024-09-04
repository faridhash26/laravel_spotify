#!/bin/sh

# اجرای migration
php artisan migrate --force

# اجرای php-fpm
exec php-fpm