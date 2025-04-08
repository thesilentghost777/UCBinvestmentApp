# Laravel Hackathon Project

Bienvenue sur notre projet de hackathon Laravel ! Ce README vous guidera à travers les étapes nécessaires pour installer et configurer correctement l'environnement de développement.

## nb:

Si vous êtes débutant dans l'utilisation des outils en ligne de commande, téléchargez manuellement le fichier install.sh et exécutez-le en mode super utilisateur (root). puis rdv a la section 7 : Demarrage du serveur


## Prérequis

Assurez-vous d'avoir installé :
- PHP 8.1 ou supérieur
- Composer
- Node.js et NPM
- MySQL ou autre SGBD compatible
- Git

si ce n'est pas le cas , voici la procedure

✅ Mise à jour initiale des paquets

sudo apt update

✅ PHP 8.1 et extensions nécessaires

sudo apt install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install php8.1 php8.1-cli php8.1-mbstring php8.1-xml php8.1-curl php8.1-mysql php8.1-zip unzip

✅ Composer

sudo apt install curl php-cli unzip
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

✅ Node.js et NPM

curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs

✅ MySQL

sudo apt install mysql-server

✅ Git

sudo apt install git


## Configuration initiale

Suivez ces étapes pour configurer le projet après l'avoir cloné :

### 1. Cloner le projet

```bash
git clone https://github.com/thesilentghost777/Ict4Hackaton.git
cd Ict4Hackaton
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

### 7. Démarrage du serveur

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