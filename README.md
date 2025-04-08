# Laravel Hackathon Project

Bienvenue sur notre projet de hackathon Laravel ! Ce README vous guidera à travers les étapes nécessaires pour installer et configurer correctement l'environnement de développement.

## Prérequis

Assurez-vous d'avoir installé :
- PHP 8.1 ou supérieur
- Composer
- Node.js et NPM
- MySQL ou autre SGBD compatible
- Git

## Configuration initiale

Suivez ces étapes pour configurer le projet après l'avoir cloné :

### 1. Cloner le projet

```bash
git clone [URL_DU_REPO] nom-du-projet
cd nom-du-projet
```

### 2. Installation des dépendances PHP

```bash
composer install
```

### 3. Configuration de l'environnement

```bash
# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```
ouvrer mysql ou xampp

-- Créer une base de données
CREATE DATABASE hackaton_db;

-- Créer l'utilisateur
CREATE USER 'hackaton'@'localhost' IDENTIFIED BY 'hackaton';

-- Donner les droits sur la base hackaton_db
GRANT ALL PRIVILEGES ON hackaton_db.* TO 'hackaton'@'localhost';

-- Appliquer les changements
FLUSH PRIVILEGES;


Ouvrez ensuite le fichier `.env` et configurez votre connexion à la base de données :

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hackaton_db
DB_USERNAME=hackaton
DB_PASSWORD=hackaton
```

### 4. Migration de la base de données

```bash
php artisan migrate
```

### 5. Installation des dépendances front-end

```bash
npm install
```

### 6. Compilation des assets

```bash
# Pour le développement (avec hot reload)
npm run dev

# OU pour la production
npm run build
```

## Démarrage du serveur

```bash
# Lancer le serveur de développement Laravel
php artisan serve
```

Le serveur sera accessible à l'adresse [http://localhost:8000](http://localhost:8000).

## Fonctionnalités

- **Authentification** : Implémentée avec Laravel Breeze
- [Ajoutez ici les fonctionnalités principales de votre projet]

## Structure du projet

- `/app` - Contient les modèles, contrôleurs, etc.
- `/resources/views` - Contient les templates Blade
- `/routes` - Définit les routes de l'application
- [Complétez selon les spécificités de votre projet]

## Commandes utiles

```bash
# Créer un contrôleur
php artisan make:controller NomController

# Créer un modèle avec migration
php artisan make:model Nom -m

# Lancer les tests
php artisan test

# Effacer le cache
php artisan cache:clear
```

## Contribution

1. Créez votre branche à partir de `main`
2. Effectuez vos modifications
3. Soumettez une pull request

## Problèmes courants

- **Les migrations échouent** : Vérifiez les paramètres de connexion à la base de données dans votre fichier `.env`
- **Les assets ne se chargent pas** : Assurez-vous d'avoir exécuté `npm run dev` ou `npm run build`
- **Erreur 500** : Vérifiez les logs dans `storage/logs/laravel.log`

Bon hackathon à tous ! 🚀