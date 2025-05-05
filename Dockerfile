# Étape 1 : Utiliser l'image officielle PHP avec Apache
FROM php:8.2-apache

# Étape 2 : Installer les dépendances système et extensions PHP nécessaires à Symfony
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libicu-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-install \
    intl \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    xml \
    opcache

# Étape 3 : Activer le module Apache rewrite (utile pour Symfony routes)
RUN a2enmod rewrite

# Étape 4 : Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Étape 5 : Définir le répertoire de travail
WORKDIR /var/www/html

# Étape 6 : Copier les fichiers nécessaires pour installer les dépendances
COPY composer.json composer.lock ./

# Étape 7 : Installer les dépendances PHP (en production)
RUN composer install --no-dev --optimize-autoloader

# Étape 8 : Copier tout le reste du code de l'application
COPY . .

# Étape 9 : Définir les permissions pour les dossiers nécessaires
RUN mkdir -p var && chown -R www-data:www-data var

# Étape 10 : Exposer le port utilisé par Apache
EXPOSE 80

# Étape 11 : Lancer Apache au démarrage du conteneur
CMD ["apache2-foreground"]
