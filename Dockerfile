FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libicu-dev libxml2-dev libzip-dev unzip git \
    && docker-php-ext-install intl pdo pdo_mysql zip mbstring xml opcache

RUN a2enmod rewrite

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Copier tous les fichiers
COPY . .

# Debug temporaire pour afficher les erreurs
RUN composer install || true

RUN chown -R www-data:www-data var vendor

EXPOSE 80

CMD ["apache2-foreground"]
