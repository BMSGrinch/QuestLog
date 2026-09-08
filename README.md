# QuestLog — Plateforme ATS de Gestion du Recrutement

## Présentation
est une plateforme de recrutement à double rôle candidat/recruteur, intégrant une API REST sécurisée avec Sanctum, une architecture orientée services, une gestion fine des rôles et permissions ainsi que des tests unitaires avec PHPUnit.

## Fonctionnalités
### Côté Candidat
- Authentification 
- Créer , Modifier & Supprimer une candidature
- Tableau de bord permettant d'avoir des statistiques pertinentes pour aider le candidat a mieux orienter ses candidatures

### Côté Recruteur
- Authentification
- Créer , Modifier & Supprimer une offre d'emploi
- Gérer le processus de recrutement 
- Tableau de bord permettant d'avoir des statistiques pertinentes pour aider le recruteur de mieux étudier le profil des candidats 

## Stack Technique
- Backend : Laravel 12, PHP 8, MySQL
- Auth : Laravel Sanctum
- Frontend : Blade, TailwindCSS, Chart.js
- Tests : PHPUnit
- Outils : Git, Postman

## Architecture
- Pattern Service Layer
- API REST
- RBAC (gestion des rôles)

## Installation
```bash
git clone ...
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

## Comptes de test
| Rôle | Email | Password |
|------|-------|----------|
| Admin | admin@questlog.test | password123 |
| Recruteur | recruiter@questlog.test | password123 |
| Candidat | candidate@questlog.test | password123 |

## Screenshots
https://github.com/BMSGrinch/QuestLog/issues/1#issue-5386504921
