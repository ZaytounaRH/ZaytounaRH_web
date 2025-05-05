# Utiliser l'image PHP avec Apache
FROM php:8.2-apache

# Installer les dépendances système nécessaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zlib1g-dev \
    libicu-dev \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxslt1-dev \
    libpq-dev \
    wkhtmltopdf \
    curl

# Installer les extensions PHP nécessaires à Symfony et à tes paquets
RUN docker-php-ext-install \
    intl \
    pdo \
    pdo_mysql \
    zip \
    mbstring \
    xsl \
    gd \
    opcache \
    xml

# Activer mod_rewrite
RUN a2enmod rewrite

# Installer Composer depuis l'image officielle (plus fiable)
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier les fichiers de dépendances uniquement
COPY composer.json composer.lock ./

# Installer les dépendances Composer (avec logs en cas d’échec)
RUN composer install --no-dev --optimize-autoloader || (cat composer.json && false)

# Copier tout le reste du projet
COPY . .

# Donner les bons droits d'accès
RUN chown -R www-data:www-data var/ && chmod -R 755 var/

# Exposer le port Apache
EXPOSE 80

# Lancer Apache
CMD ["apache2-foreground"]
