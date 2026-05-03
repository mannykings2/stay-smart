#!/usr/bin/env bash
set -euo pipefail

echo "Running composer"
composer install --no-dev --working-dir=/var/www/html --no-interaction --prefer-dist --optimize-autoloader

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "Starting nginx/php-fpm..."
exec /start.sh
