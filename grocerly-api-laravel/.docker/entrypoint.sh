#!/bin/sh
set -e

# Cachear configuración y rutas para máximo rendimiento
php artisan config:cache
php artisan route:cache

# Iniciar PHP-FPM en segundo plano y Nginx en primer plano
php-fpm -D
nginx -g "daemon off;"