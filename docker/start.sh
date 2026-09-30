#!/bin/bash

mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/bootstrap/cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

php artisan storage:link --force || true

php artisan migrate --force

php artisan optimize:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground