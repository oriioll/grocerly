# Usa la versión de PHP de tu proyecto (8.2 o 8.3 son las recomendadas)
FROM php:8.3-fpm

# Instalar dependencias necesarias del sistema operativo (incluye soporte para MySQL y PostgreSQL)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    libpq-dev \
    zip \
    unzip \
    nginx \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configurar e instalar extensiones PHP exigidas por Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# Copiar ejecutable oficial de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www

# Copiar el código del proyecto
COPY . /var/www

# Instalar dependencias PHP optimizadas para producción
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Ajustar permisos de directorios de almacenamiento de Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copiar configuraciones de Nginx y script de arranque
COPY .docker/nginx.conf /etc/nginx/sites-available/default
COPY .docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]