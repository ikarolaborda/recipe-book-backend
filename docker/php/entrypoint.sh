#!/bin/sh

set -e

# check if vendor folder exists
if [ ! -d "/var/www/html/vendor" ]; then
    composer install --no-interaction --no-progress --no-suggest
fi

php artisan optimize:clear

exec docker-php-entrypoint php-fpm
