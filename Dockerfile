FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    libzip-dev zip unzip nodejs npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite

RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Entrypoint inline para evitar problema CRLF de Windows
RUN printf '#!/bin/bash\nset -e\nif [ -z "$APP_KEY" ]; then php artisan key:generate --force; fi\nphp artisan config:clear\nphp artisan cache:clear\nphp artisan migrate --force\napache2-foreground\n' > /usr/local/bin/docker-entrypoint.sh \
    && chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80
RUN printf '#!/bin/bash\nset -e\nif [ -z "$APP_KEY" ]; then php artisan key:generate --force; fi\nphp artisan migrate --force\nphp artisan config:clear\nphp artisan view:clear\napache2-foreground\n' > /usr/local/bin/docker-entrypoint.sh \
    && chmod +x /usr/local/bin/docker-entrypoint.sh