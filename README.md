<div align="center">

# 🎮 TechQuest RH — Plateforme de Gamification de la Formation

**Former et faire évoluer les collaborateurs en transformant l'apprentissage en parcours ludique.**

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3-38B2AC?logo=tailwindcss&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3-8BC0D0?logo=alpinedotjs&logoColor=white)

</div>

---

## 📖 Présentation

**TechQuest RH** est une application web de **montée en compétences gamifiée** destinée aux employés d'une entreprise. Chaque collaborateur suit des **formations** (Excel, Microsoft Teams, ERP, Email professionnel) découpées en **modules**, gagne de l'**XP**, débloque des **badges** et progresse à travers des **niveaux** (Débutant → Intermédiaire → Expert).

Projet réalisé dans le cadre de notre formation à l'**ENSIAS**.

---

## ✨ Fonctionnalités

### 🎓 Formations & modules
- Catalogue de formations avec **logo** et **niveaux de difficulté** par module.
- Chaque module se compose d'**éléments de cours** numérotés (façon Coursera) — marqués comme **lus** au fil de la lecture — suivis d'un **test du module**.
- Suivi de progression par formation et reprise **« Continuer »** exactement là où l'employé s'est arrêté.

### 🧩 Quiz interactif
- **Question par question**, avec barre de progression.
- **Tentatives illimitées et non pénalisantes** : on rejoue la question jusqu'à la bonne réponse.
- **Bouton « Indice »** d'aide à la demande.
- **Messages d'encouragement** en cas d'erreur et de **félicitations** à la réussite.
- **Sauvegarde du point de situation** (question en cours) en base de données.

### 🔒 Progression verrouillée
- Un niveau supérieur reste **verrouillé** tant que le niveau inférieur n'est pas **entièrement validé**.

### 🏅 Badges & test final
- Attribution **automatique de badges** selon les accomplissements (premier défi, assiduité, maîtrise, formation terminée).
- **Test global** en fin de formation (questions dédiées) débloquant un **badge secret**.
- Notifications de félicitations à chaque badge débloqué.

### 👥 Rôles & espaces
- **Employé** : formations, quiz, badges, tableau de bord personnel.
- **Manager RH** : tableau de bord RH et export.
- **Administrateur** : gestion des formations, défis, badges et utilisateurs.

---

## 🛠️ Stack technique

| Couche | Technologie |
|---|---|
| Back-end | **Laravel 12** (PHP 8.2) |
| Base de données | **MySQL** |
| Front-end | **Blade**, **Tailwind CSS**, **Alpine.js** (via **Vite**) |
| Authentification | **Laravel Breeze** + middleware de rôles personnalisé (`CheckRole`) |
| ORM | **Eloquent** (relations 1-n et n-n via tables pivot) |

---

## 🚀 Installation

### Prérequis
PHP 8.2+, Composer, Node.js + npm, MySQL.

```bash
# 1. Cloner le dépôt
git clone https://github.com/mouadrca042-ops/techquestrh.git
cd techquestrh

# 2. Dépendances PHP et JS
composer install
npm install

# 3. Configuration de l'environnement
cp .env.example .env
php artisan key:generate
```

Dans le fichier **`.env`**, configurez la base de données :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306          # 3307 selon votre configuration XAMPP
DB_DATABASE=techquest_rh
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# 4. Créer la base "techquest_rh" puis lancer migrations + données de démo
php artisan migrate:fresh --seed

# 5. Compiler les assets
npm run build

# 6. Démarrer le serveur
php artisan serve
```

L'application est disponible sur **http://127.0.0.1:8000**.

> 💡 En développement, vous pouvez utiliser `npm run dev` (rechargement automatique) à la place de `npm run build`.

---

## 🔑 Comptes de démonstration

| Rôle | Email | Mot de passe |
|---|---|---|
| Administrateur | `admin@techquest.com` | `password123` |
| Manager RH | `manager@techquest.com` | `password123` |
| Employé | `employe@techquest.com` | `password123` |

---

## 🗂️ Architecture (aperçu)

```
app/
 ├── Http/Controllers/   # Dashboard, Parcours, Defi, Badge, Positionnement, Admin, RH
 ├── Models/             # Parcours, Defi, Progression, Badge, User
 ├── Http/Middleware/    # CheckRole (gestion des rôles)
 └── Support/            # TestGlobal (questions des examens finaux)
database/
 ├── migrations/         # Schéma de la base
 └── seeders/            # Données : utilisateurs, formations, modules, badges
resources/views/         # Vues Blade (dashboard, parcours, defis, badges, layouts, composants)
```

**Modèle de données (relations principales)** : une `Parcours` **a plusieurs** `Defi` (modules) ; un `User` **suit** des `Parcours` (pivot `parcours_user`) et **obtient** des `Badge` (pivot `user_badges`) ; chaque réussite est tracée dans `Progression`.

---

## 👨‍💻 Équipe

| Membre | Responsabilité |
|---|---|
| **Moad Gounbarek** | Gestion des **parcours** (catalogue, détails, inscriptions, administration) |
| **Ali Kharbouche** | **Défis & progression** : modules, quiz interactif, verrouillage, badges, test final |
| **Aymen Klimantine** | **XP**, **Dashboard RH** et gestion de session utilisateur |

---

## 🔄 Workflow Git

Le projet suit un flux collaboratif par branches :

```
branche de fonctionnalité  →  Pull Request  →  dev  →  (validation)  →  main
```

- Une branche par fonctionnalité (ex. `formations`, `badges`), créée à partir d'un `dev` à jour.
- Intégration via **Pull Request** vers `dev`.
- Le responsable d'intégration fusionne `dev` dans `main`.

---

<div align="center">
<sub>© 2026 TechQuest RH — Projet ENSIAS · Votre progression, à votre rythme 🌟</sub>
</div>
