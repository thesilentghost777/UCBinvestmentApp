#!/bin/bash

# Script d'installation pour le projet Ict4Hackaton
# Ce script installe tous les prérequis et configure l'application

echo "=== Script d'installation pour le projet Ict4Hackaton ==="
echo "Ce script va installer les dépendances nécessaires et configurer l'application."

# Vérification des prérequis
echo -e "\n=== Vérification des prérequis ==="

# Vérifier si PHP est installé
if ! command -v php &> /dev/null; then
    echo "PHP n'est pas installé. Installation..."
    sudo apt update
    sudo apt install -y php php-cli php-fpm php-mbstring php-xml php-zip php-mysql php-curl php-gd
else
    echo "✓ PHP est déjà installé: $(php -v | head -n 1)"
fi

# Vérifier si Composer est installé
if ! command -v composer &> /dev/null; then
    echo "Composer n'est pas installé. Installation..."
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    php -r "unlink('composer-setup.php');"
else
    echo "✓ Composer est déjà installé: $(composer --version)"
fi

# Vérifier si Node.js et NPM sont installés
if ! command -v node &> /dev/null; then
    echo "Node.js n'est pas installé. Installation..."
    curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
    sudo apt install -y nodejs
else
    echo "✓ Node.js est déjà installé: $(node -v)"
fi

if ! command -v npm &> /dev/null; then
    echo "NPM n'est pas installé. Installation..."
    sudo apt install -y npm
else
    echo "✓ NPM est déjà installé: $(npm -v)"
fi

# Vérifier si Git est installé
if ! command -v git &> /dev/null; then
    echo "Git n'est pas installé. Installation..."
    sudo apt install -y git
else
    echo "✓ Git est déjà installé: $(git --version)"
fi

echo -e "\n=== Clonage du projet ==="
# Vérifier si le dossier existe déjà
if [ -d "Ict4Hackaton" ]; then
    echo "Le dossier Ict4Hackaton existe déjà. Voulez-vous le supprimer et continuer? (O/n)"
    read -r response
    if [[ "$response" =~ ^([oO]|oui|Oui|OUI|)$ ]]; then
        rm -rf Ict4Hackaton
    else
        echo "Installation annulée."
        exit 1
    fi
fi

# Cloner le projet
git clone https://github.com/thesilentghost777/Ict4Hackaton.git
cd Ict4Hackaton

echo -e "\n=== Installation des dépendances PHP ==="
composer install

echo -e "\n=== Configuration de l'environnement ==="
# Copier le fichier .env.example en .env
if [ -f ".env.example" ]; then
    cp .env.example .env
    echo "✓ Fichier .env créé"
else
    echo "⚠️  Le fichier .env.example est manquant. Création d'un .env basique..."
    cat > .env << EOL
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:gK4t5TtyZ6k9KmRaivQoLLdxuyk0hbNMxxeOAcjLNog=
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hackaton_db
DB_USERNAME=hackaton
DB_PASSWORD=hackaton

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
# CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

EOL
fi

# Générer la clé d'application
php artisan key:generate
echo "✓ Clé d'application générée"

echo -e "\n=== Configuration de la base de données ==="
echo "Veuillez entrer les informations de votre base de données:"
echo -n "Nom de la base de données (par défaut: laravel): "
read -r db_name
db_name=${db_name:-laravel}

echo -n "Utilisateur MySQL (par défaut: root): "
read -r db_user
db_user=${db_user:-root}

echo -n "Mot de passe MySQL (laisser vide si aucun): "
read -rs db_password
echo ""

# Mettre à jour le fichier .env avec les informations de la base de données
sed -i "s/DB_DATABASE=.*/DB_DATABASE=$db_name/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=$db_user/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$db_password/" .env

echo "✓ Configuration de la base de données mise à jour"

# Demander si l'utilisateur veut créer la base de données
echo -n "Voulez-vous créer la base de données '$db_name'? (O/n): "
read -r create_db
if [[ "$create_db" =~ ^([oO]|oui|Oui|OUI|)$ ]]; then
    echo "Création de la base de données..."
    mysql -u "$db_user" ${db_password:+-p"$db_password"} -e "CREATE DATABASE IF NOT EXISTS $db_name;"
    echo "✓ Base de données créée"
fi

echo -e "\n=== Migration de la base de données ==="
php artisan migrate --force

echo -e "\n=== Installation des dépendances front-end ==="
npm install

echo -e "\n=== Compilation des assets ==="
npm run dev &
dev_pid=$!
echo "Le processus npm run dev est en cours d'exécution (PID: $dev_pid)"
echo "Appuyez sur CTRL+C pour l'arrêter quand vous avez terminé"

echo -e "\n=== Lancement du serveur Laravel ==="
echo "Le serveur Laravel va démarrer. Vous pourrez accéder à l'application à l'adresse http://localhost:8000"
echo "Appuyez sur CTRL+C pour arrêter le serveur quand vous avez terminé"

# Démarrer le serveur Laravel
php artisan serve

# Arrêter npm run dev quand php artisan serve est arrêté
kill $dev_pid 2>/dev/null

echo -e "\n=== Installation terminée ! ==="
echo "Votre application Laravel est prête. Profitez de votre hackathon !"