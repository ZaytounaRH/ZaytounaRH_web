FROM php:8.2-apache

# Installer les extensions système nécessaires
RUN apt-get update && apt-get install -y \
    libicu-dev zip libzip-dev unzip git \
    && docker-php-ext-install intl pdo pdo_mysql zip opcache

# Activer le module Apache rewrite
RUN a2enmod rewrite

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier tous les fichiers
COPY . .

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Donner les permissions nécessaires
RUN chown -R www-data:www-data var vendor

# Exposer le port 80
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
