#!/bin/sh

echo "📦 Starting Laravel setup..."

# If .env exists, cache config and routes
if [ -f ".env" ]; then
  echo "⚙️ Caching config and routes..."
  php artisan config:cache || true
  php artisan route:cache || true
else
  echo "⚠️ .env not found — skipping artisan caching"
fi

# Start Laravel development server
echo "🚀 Starting Laravel on port ${PORT:-8000}..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
