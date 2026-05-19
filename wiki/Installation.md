# Installation

## Prérequis

| Logiciel   | Version minimale |
|------------|-----------------|
| PHP        | 8.2             |
| Composer   | 2.x             |
| Node.js    | 18+             |
| MySQL      | 5.7+ (ou MariaDB 10.3+) |
| Redis      | 6+              |

La base de données doit déjà exister et contenir les tables `hlstats_*` générées par le daemon Perl (voir [SnipeZilla/HLSTATS-2](https://github.com/SnipeZilla/HLSTATS-2)).

---

## Installation

```bash
# 1. Cloner le dépôt
git clone https://github.com/Royal-Multi-Gamers/hlstatsx-community-edition.git
cd hlstatsx-community-edition

# 2. Dépendances PHP
composer install --no-dev --optimize-autoloader

# 3. Dépendances JavaScript
npm install

# 4. Fichier d'environnement
cp .env.example .env
php artisan key:generate

# 5. Éditer .env (voir page Configuration)
nano .env

# 6. Build des assets
npm run build

# 7. Liaison du storage (si nécessaire)
php artisan storage:link
```

---

## Migration de mot de passe admin

Les comptes admin sont stockés dans `hlstats_Admins`. Lors de la première connexion avec un ancien compte `hlstats_Users` (mot de passe MD5), le système propose une migration automatique vers bcrypt :

```
/admin/migrate-password
```

---

## Planificateur cron

Ajouter dans le crontab du serveur :

```cron
* * * * * cd /var/www/hlstatsx && php artisan schedule:run >> /dev/null 2>&1
```

---

## Serveur de développement

```bash
# Terminal 1 — Laravel
php artisan serve

# Terminal 2 — Vite (hot reload)
npm run dev
```

---

## Vérification post-installation

| URL | Vérification |
|-----|-------------|
| `/` | Page d'accueil avec stats globales |
| `/players` | Liste des joueurs classés |
| `/admin` | Panneau d'administration |
| `/admin/login` | Authentification admin |
