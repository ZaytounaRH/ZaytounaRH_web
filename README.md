
# ZaytounaRH Système de Gestion des Ressources Humaines🌿

## 📝 Overview

**ZaytounaRH** est une application web développée avec *Symfony 6.4* dans le cadre du module PIDEV 3A à *Esprit School of Engineering*.  Elle vise à moderniser la gestion des ressources humaines en entreprise en intégrant des modules essentiels comme le recrutement, la formation, la présence et la gestion des réclamations,le budget et plus encore, le tout avec une interface intuitive et modulaire.
 
 ## 📌 Table des Matières

 - [🎯 overview]
- [✨ Features]
- [🧰 Tech Stack]
- [🗂️ Structure du projet]
- [🚀 Mise en route ]
- [🤝 Remerciment]

## ✨ Features

🔍 Gestion des recrutements
👤 Gestion des utilisateurs 
🎓 Gestion des formation 
🕒 Suivi de présence 
💬 Réclamations et assurance
💵 Gestion financière 

## 🧰 Tech Stack

### Backend
PHP 8.2
Symfony 6.4
Doctrine ORM
MySQL / MariaDB


### Frontend
Twig
HTML/CSS
Bootstrap 5


### Outils et Services
Git & GitHub
Postman (tests API)

## 🗂️ Structure du projet

├── assets/              # Fichiers JS/CSS/SCSS (frontend)
├── bin/                 # Fichiers d'exécution (ex: console)
├── config/              # Configuration de Symfony (routes, services, etc.)
├── migrations/          # Migrations de base de données
├── public/              # Racine publique du projet (index.php, assets compilés)
├── src/                 # Code source de l'application
│   ├── Controller/      # Contrôleurs MVC
│   ├── Entity/          # Entités Doctrine (modèles)
│   ├── Repository/      # Requêtes personnalisées vers la base de données
│   ├── Form/            # Classes de formulaire Symfony
│   ├── Service/         # Services métiers
├── templates/           # Vues HTML via Twig
├── tests/               # Tests unitaires / fonctionnels
├── translations/        # Fichiers de traduction
├── var/                 # Fichiers temporaires (cache, logs)
├── vendor/              # Dépendances installées via Composer

# Fichiers de configuration et d’environnement :
├── .env                 # Variables d'environnement par défaut
├── .env.dev            # Variables d'environnement pour le dev
├── .env.test           # Variables pour les tests
├── .gitignore          # Fichiers/dossiers ignorés par Git
├── composer.json       # Déclaration des dépendances PHP
├── composer.lock       # Version verrouillée des dépendances
├── phpunit.xml.dist    # Configuration de PHPUnit
├── importmap.php       # Configuration des imports JS (si utilisé)
├── compose.override    # Config Docker (optionnelle)
├── compose             # Fichier Docker Compose (optionnel)
##  Mise en route 

# 1. Cloner le dépôt
git clone https://github.com/ton-org/zaytouna-rh.git
cd zaytouna-rh

# 2. Installer les dépendances PHP
composer install

# 3. Configurer l’environnement
cp .env .env.local
# Modifier les variables de connexion à la base de données dans .env.local

# 4. Créer la base et exécuter les migrations
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# 5. Lancer le serveur Symfony
symfony serve

# Remerciment
Ce projet a été réalisé sous la supervision du professeur Amir Yazidi dans le cadre d’un travail pédagogique collaboratif.

Nous remercions :

Toute l’équipe de développement de Zaytouna RH

Les enseignants et encadrants qui nous ont guidés

