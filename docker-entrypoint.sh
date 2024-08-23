
#!/bin/bash

set -e

# اجرای دستورات اولیه
composer install --no-dev --optimize-autoloader
php artisan migrate --force || { echo 'Migration failed'; exit 1; }
php artisan storage:link || { echo 'Storage link failed'; exit 1; }
php artisan config:cache || { echo 'Config cache failed'; exit 1; }
php artisan route:cache || { echo 'Route cache failed'; exit 1; }

# شروع PHP-FPM در پس‌زمینه
php-fpm &

# شروع Nginx به صورت foreground
nginx -g 'daemon off;'
