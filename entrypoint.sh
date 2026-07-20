#!/bin/sh
set -e

# Ensure public storage symlink exists
php artisan storage:link --force || true

# Run database migrations
php artisan migrate --force

php artisan db:seed --class=ProductionSeeder --force

# Cache configs, routes, and views for production performance
if [ "$APP_ENV" = "production" ]; then
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

# Execute CMD passed to container
exec "$@"