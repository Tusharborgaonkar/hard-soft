#!/bin/bash

set -e

echo "🚀 Deployment started"

# Set project directory (relative to script location, or absolute)
PROJECT_DIR="$(pwd)"

cd "$PROJECT_DIR" || exit 1

echo "📥 Pulling latest code"
git reset --hard
git pull origin main

echo "📦 Installing composer dependencies"
# Ensure we don't install dev packages on production
composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

echo "🧹 Pre-migration cache cleaning"
# Delete existing cache files manually to prevent PailServiceProvider error
rm -f bootstrap/cache/*.php

# Clear caches BEFORE migration to prevent bootstrap errors
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo "🗄 Running migrations"
php artisan migrate --force

echo "⚡ Optimizing application"
# Rebuild caches for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

echo "✅ Deployment finished successfully"
