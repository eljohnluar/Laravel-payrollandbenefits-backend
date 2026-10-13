# Payroll & Benefits Laravel API — Render Docker image.
# php artisan serve (php -S under the hood) mirrors the legacy free-tier setup;
# pdo_pgsql + libpq-dev replicate the known Render 503 fix.
FROM php:8.3-bookworm

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt-get update \
 && apt-get install -y --no-install-recommends libpq-dev \
 && docker-php-ext-install pdo_pgsql \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-interaction --prefer-dist --optimize-autoloader --no-progress

COPY . .

RUN composer dump-autoload --optimize --no-dev \
 && php artisan package:discover --ansi \
 && mkdir -p storage/framework/{cache,sessions,views} bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

ENV PORT=8080
EXPOSE 8080

CMD ["sh", "-c", "if [ -z \"$APP_KEY\" ]; then php artisan key:generate --force; fi; exec php artisan serve --host=0.0.0.0 --port=${PORT} --no-reload"]
