# syntax=docker/dockerfile:1.7

# --------------------------------------------------------------------------
# TrustFlow CRM - production-grade multi-stage Dockerfile
#
# Stages:
#   1. composer      -> install PHP dependencies with cache-mounts
#   2. node          -> build front-end assets (vite)
#   3. runtime       -> slim PHP-FPM image with OPcache + non-root user
#
# Designed for local Docker Compose, Jenkins and Kubernetes.
# --------------------------------------------------------------------------

ARG PHP_VERSION=8.2
ARG NODE_VERSION=20

# ============================================================================
# 1. Composer dependencies
#
# Built on the same PHP version as the runtime stage so the platform-req
# checks during `composer install` match production. The upstream
# `composer:2` image currently ships with PHP 8.5 which breaks packages
# still pinned to ~8.4, so we install the composer binary ourselves.
# ============================================================================
FROM php:${PHP_VERSION}-cli-bookworm AS composer

WORKDIR /app

RUN apt-get update && apt-get install -y --no-install-recommends \
        git curl ca-certificates unzip zip \
        libicu-dev libonig-dev libzip-dev libpng-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring bcmath gd zip intl exif pcntl \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && curl -fsSL https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin --filename=composer

COPY composer.json composer.lock ./
# INSTALL_DEV=true  → includes dev packages (fakerphp/faker, phpunit, pint…)
#                     needed for local development, seeders, tests.
# INSTALL_DEV=false → lean production build (adds --no-dev).
ARG INSTALL_DEV=true
RUN --mount=type=cache,target=/tmp/composer-cache \
    if [ "$INSTALL_DEV" = "true" ]; then \
        COMPOSER_ALLOW_SUPERUSER=1 composer install \
            --no-interaction --prefer-dist \
            --no-scripts --no-autoloader --no-progress; \
    else \
        COMPOSER_ALLOW_SUPERUSER=1 composer install \
            --no-dev --no-interaction --prefer-dist \
            --no-scripts --no-autoloader --no-progress; \
    fi

# Copy full app for autoloader finalisation (scripts deferred to runtime).
COPY . .
RUN COMPOSER_ALLOW_SUPERUSER=1 composer dump-autoload --optimize --classmap-authoritative

# ============================================================================
# 2. Front-end assets
#
# This stage is tolerant of projects that do not (yet) ship a root
# package.json / vite.config.* — it simply produces an empty public/build
# directory so the runtime stage COPY below remains valid.
# ============================================================================
FROM node:${NODE_VERSION}-alpine AS node

WORKDIR /app

# Copy the full source tree so the conditional logic below can inspect
# the repository without failing on a missing file.
COPY . .

RUN set -eux; \
    if [ -f package.json ]; then \
        if [ -f package-lock.json ]; then \
            npm ci --no-audit --no-fund; \
        elif [ -f yarn.lock ]; then \
            yarn install --frozen-lockfile; \
        elif [ -f pnpm-lock.yaml ]; then \
            corepack enable && pnpm install --frozen-lockfile; \
        else \
            npm install --no-audit --no-fund; \
        fi; \
        if [ -f vite.config.js ] || [ -f vite.config.ts ] || [ -f webpack.mix.js ]; then \
            npm run build || true; \
        fi; \
    else \
        echo "[node] No root package.json found — skipping frontend build."; \
    fi; \
    mkdir -p public/build

# ============================================================================
# 3. Runtime
# ============================================================================
FROM php:${PHP_VERSION}-fpm-bookworm AS runtime

LABEL org.opencontainers.image.title="TrustFlow CRM"
LABEL org.opencontainers.image.description="Enterprise B2B Growth Engine (Laravel 11 + Filament)"
LABEL org.opencontainers.image.source="https://github.com/sherzot/TrustFlowCRM"

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    PHP_OPCACHE_ENABLE=1 \
    PHP_MEMORY_LIMIT=512M \
    PHP_UPLOAD_MAX_FILESIZE=40M \
    PHP_POST_MAX_SIZE=40M \
    PHP_MAX_EXECUTION_TIME=300

WORKDIR /var/www/html

# System deps (runtime only).
RUN apt-get update && apt-get install -y --no-install-recommends \
        git curl ca-certificates \
        libpng-dev libonig-dev libxml2-dev libzip-dev libicu-dev \
        zip unzip \
        supervisor \
        nginx \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl opcache \
    && pecl install redis \
    && docker-php-ext-enable redis opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# PHP runtime configuration.
COPY docker/php/php.ini        /usr/local/etc/php/conf.d/zz-trustflow.ini
COPY docker/php/www.conf       /usr/local/etc/php-fpm.d/www.conf
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf   /etc/supervisor/conf.d/trustflow.conf

# Application payload from previous stages.
COPY --from=composer --chown=www-data:www-data /app            /var/www/html
COPY --from=node     --chown=www-data:www-data /app/public/build /var/www/html/public/build

# Pre-create writable dirs and fix perms.
RUN mkdir -p storage/framework/{cache,data,sessions,testing,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwX storage bootstrap/cache

# Nginx runtime directories must be writable by the non-root www-data user.
# Without this the master process fails with:
#   mkdir() "/var/lib/nginx/body" failed (13: Permission denied)
RUN mkdir -p /var/lib/nginx/body \
             /var/lib/nginx/fastcgi \
             /var/lib/nginx/proxy \
             /var/lib/nginx/scgi \
             /var/lib/nginx/uwsgi \
             /var/log/nginx \
             /var/cache/nginx \
    && touch /var/run/nginx.pid \
    && chown -R www-data:www-data /var/lib/nginx /var/log/nginx /var/cache/nginx /var/run/nginx.pid \
    && chmod -R u+rwX /var/lib/nginx /var/log/nginx /var/cache/nginx

# Healthcheck hits the Laravel app through nginx on 8080.
HEALTHCHECK --interval=30s --timeout=5s --start-period=30s --retries=3 \
    CMD curl -fsS http://127.0.0.1:8080/up || exit 1

USER www-data
EXPOSE 8080 9000

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/trustflow.conf"]
