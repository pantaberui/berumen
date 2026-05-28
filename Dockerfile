FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    libzip-dev zip unzip nodejs npm default-mysql-client \
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

RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf

WORKDIR /var/www/html
COPY . /var/www/html

RUN printf '#!/bin/bash\nset -e\necho "Ajustando permisos..."\nchown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache\nchmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache\necho "Optimizando Laravel..."\nphp artisan config:cache\nphp artisan route:cache\nphp artisan view:cache\necho "Iniciando Apache..."\napache2-foreground\n' > /usr/local/bin/docker-entrypoint.sh \
    && chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80
ENTRYPOINT ["docker-entrypoint.sh"]