# 🎯 Projet Symfony – Académie WS

Ce projet a été réalisé dans le cadre du cours [SYMFONY – Académie WS](https://academiews.fr/course/10) dispensé par Samih Habbani. L'objectif était de maîtriser les fondamentaux du framework Symfony en développant une application web complète.

## ✅ Fonctionnalités

- Application web développée avec Symfony  
- Architecture MVC  
- Routing et contrôleurs personnalisés  
- Templates Twig  
- Gestion d'une base de données avec Doctrine ORM  
- Entités, relations et migrations  
- Génération de données avec Faker  
- Création de formulaires  
- Interface utilisateur responsive avec Bootstrap  

## 🛠️ Technologies utilisées

- PHP 8.x  
- Symfony 6.x  
- Composer  
- Doctrine ORM  
- Twig  
- Faker  
- Bootstrap 5  
- MySQL ou SQLite  

## 🚀 Installation

1. Cloner le projet :
git clone https://github.com/ton-utilisateur/nom-du-projet.git  
cd nom-du-projet

2. Installer les dépendances :
composer install

3. Configurer l’environnement :
cp .env .env.local  
Modifier DATABASE_URL dans `.env.local` :
DATABASE_URL="mysql://user:password@127.0.0.1:3306/nom_de_la_base?serverVersion=8.0"

4. Préparer la base de données :
php bin/console doctrine:database:create  
php bin/console doctrine:migrations:migrate

5. (Optionnel) Charger les fixtures :
php bin/console doctrine:fixtures:load

6. Démarrer le serveur :
symfony server:start  
Ou avec PHP :
php -S localhost:8000 -t public

## 🧭 Structure du projet

config/ - Fichiers de configuration  
public/ - Fichiers accessibles publiquement  
src/ - Code source (Controllers, Entities, Forms, etc.)  
templates/ - Templates Twig  
migrations/ - Fichiers de migration  
fixtures/ - Données de test  
.env - Variables d’environnement  
composer.json - Dépendances du projet

## 👤 Auteur

Projet réalisé par HDevv dans le cadre du cours [SYMFONY – Académie WS](https://academiews.fr/course/10).

## 📄 Licence

Ce projet est sous licence MIT.
