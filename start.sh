#!/bin/bash

echo "=== Starting NERDINO Application ==="

# Clear caches
echo "Clearing caches..."
php artisan route:clear
php artisan config:clear
php artisan cache:clear

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Start server
echo "Starting server..."
php artisan serve --host=0.0.0.0 --port=$PORT
