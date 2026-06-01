FROM php:8.3-apache

# ── Dependencias del sistema ──────────────────────────────────────────────────
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    libzip-dev zip unzip nodejs npm default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ── Composer ──────────────────────────────────────────────────────────────────
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ── Apache ────────────────────────────────────────────────────────────────────
RUN a2enmod rewrite

RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf \
    && echo 'ServerName localhost' >> /etc/apache2/apache2.conf

# ── Código fuente ─────────────────────────────────────────────────────────────
WORKDIR /var/www/html
COPY . /var/www/html

# ── Dependencias PHP y assets (solo en build) ─────────────────────────────────
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && npm ci && npm run build \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# ── Entrypoint (se ejecuta cada vez que arranca el contenedor) ────────────────
# Solo tareas rápidas: migraciones + limpiar caché
RUN printf '#!/bin/bash\n\
set -e\n\
\n\
echo ">>> Generando APP_KEY si no existe..."\n\
# php artisan key:generate --force\n\
\n\
echo ">>> Ejecutando migraciones..."\n\
# php artisan migrate --force\n\
\n\
echo ">>> Limpiando y optimizando cache..."\n\
php artisan config:clear\n\
php artisan route:clear\n\
php artisan view:clear\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
\n\
echo ">>> Ajustando permisos..."\n\
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache\n\
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache\n\
\n\
echo ">>> Iniciando Apache..."\n\
apache2-foreground\n\
' > /usr/local/bin/docker-entrypoint.sh \
    && chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80
ENTRYPOINT ["docker-entrypoint.sh"]
