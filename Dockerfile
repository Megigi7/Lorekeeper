# PARA LEVANTAR
# docker compose up -d --build

# Por si da error de read only o permision denied, ejecutar:
# docker compose exec app chown -R www-data:www-data /var/www/html/database


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
# STAGE 3: Aplicación Final (Modificado para SQLite)
# ==========================================
FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

# Instalar dependencias del sistema y pdo_sqlite
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    libzip-dev \
    unzip \
    git \
    bash \
    sqlite-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    # 🌟 NUEVO: Añadida la extensión 'exif' al final de la lista de instalación de PHP
    && docker-php-ext-install pdo_sqlite gd zip bcmath pcntl exif
COPY . .
COPY --from=vendor /app/vendor/ ./vendor/
COPY --from=frontend /app/public/build/ ./public/build/

# Asegurar que el archivo sqlite exista si no está creado (para producción)
RUN mkdir -p database && touch database/database.sqlite

# ¡CRUCIAL PARA SQLITE! Permisos en storage, bootstrap/cache Y la carpeta database
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

EXPOSE 9000
CMD ["php-fpm"]