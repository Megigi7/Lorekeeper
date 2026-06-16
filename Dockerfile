# PARA LEVANTAR
# docker compose up -d --build

# ==========================================
# STAGE 1: Dependencias de PHP (Composer)
# ==========================================
FROM composer:2.7 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --ignore-platform-reqs --no-interaction --no-plugins --no-scripts --no-dev --prefer-dist


# ==========================================
# STAGE 2: Compilación de Frontend (Vite)
# ==========================================
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
COPY resources/ ./resources/
RUN npm ci && npm run build


# ==========================================
# STAGE 3: Aplicación Final (Modificado para MySQL) 🌟
# ==========================================
FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

# Instalar dependencias del sistema y pdo_mysql
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    libzip-dev \
    unzip \
    git \
    bash \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    # 🌟 CAMBIO: Se elimina 'pdo_sqlite' y se añade 'pdo_mysql'
    && docker-php-ext-install pdo_mysql gd zip bcmath pcntl exif

COPY . .
COPY --from=vendor /app/vendor/ ./vendor/
COPY --from=frontend /app/public/build/ ./public/build/

# 🌟 CAMBIO: Ya no creamos el archivo database.sqlite ni tocamos permisos de la carpeta database
# ¡CRUCIAL PARA LARAVEL! Permisos en storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]