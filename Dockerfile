FROM php:8.2-apache

# Installer les paquets système nécessaires
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libicu-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    zip \
    curl \
    && docker-php-ext-install \
    intl \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    xml \
    opcache

# Activer mod_rewrite Apache
RUN a2enmod rewrite

# Installer Composer via image officielle
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier les fichiers composer
COPY composer.json composer.lock ./

# Debug : Lister le contenu avant installation
RUN ls -la && composer validate

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader || (cat /var/www/html/composer.json && false)

# Copier tout le projet
COPY . .

# Créer et autoriser les bons droits
RUN mkdir -p var && chown -R www-data:www-data var

EXPOSE 80

CMD ["apache2-foreground"]
