#!/bin/bash

# Création des migrations
php artisan make:migration create_packages_table --create=packages
php artisan make:migration create_investissements_table --create=investissements
php artisan make:migration create_taches_table --create=taches
php artisan make:migration create_taches_journalieres_table --create=taches_journalieres
php artisan make:migration create_retraits_table --create=retraits
php artisan make:migration create_parrainages_table --create=parrainages
php artisan make:migration create_transactions_table --create=transactions
php artisan make:migration create_soldes_table --create=soldes

# Création des modèles
php artisan make:model Package -m
php artisan make:model Investissement -m
php artisan make:model Tache -m
php artisan make:model TacheJournaliere -m
php artisan make:model Retrait -m
php artisan make:model Parrainage -m
php artisan make:model Transaction -m
php artisan make:model Solde -m

# Création des controllers
php artisan make:controller FirstLoginController

# Instructions après création
echo "Fichiers générés avec succès!"
echo "N'oubliez pas d'exécuter les migrations avec: php artisan migrate"
echo "Et de configurer l'authentification selon vos besoins."
