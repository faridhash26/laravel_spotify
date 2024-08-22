#!/bin/bash

set -e

php artisan migrate --force || { echo 'Migration failed'; exit 1; }
php artisan storage:link || { echo 'Storage link failed'; exit 1; }
php artisan config:cache || { echo 'Config cache failed'; exit 1; }
php artisan route:cache || { echo 'Route cache failed'; exit 1; }

exec apache2-foreground
