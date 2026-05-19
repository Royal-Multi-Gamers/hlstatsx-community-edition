# Pages Frontend

Toutes les pages sont accessibles sans authentification.

---

## Accueil — `/`

Vue d'ensemble globale du site.

**Contenu :**
- Section "Voice Server" (Discord, Steam Group)
- Carte mondiale Leaflet (marqueurs serveurs + top 500 joueurs)
- Tableau des jeux configurés (top joueur, top clan, joueurs connectés)
- Statistiques globales (kills totaux, dernier kill, nombre de joueurs/clans/jeux/serveurs)

---

## Joueurs — `/players`

Classement général des joueurs.

**Filtres disponibles :**

| Paramètre | Description |
|-----------|-------------|
| `game`    | Filtrer par code de jeu |
| `search`  | Recherche par pseudo |
| `sort`    | `skill` (défaut), `kills`, `deaths`, `headshots`, `connection_time` |
| `country` | Filtrer par code pays |
| `view`    | `total` ou autre vue |

**Colonnes affichées :** rang, drapeau, pseudo, clan, kills, deaths, headshots, skill, activité (barre colorée).

### Profil joueur — `/players/{id}`

**Onglets du profil :**

| Onglet | URL | Contenu |
|--------|-----|---------|
| Profil | `/players/{id}` | Stats complètes, avatar Steam, armes, maps, victimes, tueurs, équipes, actions, serveurs, graphique skill |
| Événements | `/players/{id}/events` | Historique des frags récents |
| Sessions | `/players/{id}/sessions` | Historique des sessions de jeu |
| Awards | `/players/{id}/awards` | Prix remportés |
| Chat | `/players/{id}/chat` | Messages en jeu |

---

## Clans — `/clans`

Classement des clans.

**Tri disponible :** `avg_skill` (défaut), `kills`, `deaths`, `headshots`, `members_count`, `total_connection_time`, `name`, `tag`.

### Détail clan — `/clans/{id}`

**Onglets :**
- **Membres** : liste des joueurs du clan
- **Armes** : armes les plus utilisées par le clan
- **Maps** : performances par map
- **Équipes** : équipes les plus jouées
- **Actions** : actions bonus réalisées

---

## Serveurs — `/servers`

Liste des serveurs de jeu avec statut en ligne/hors-ligne.

### Détail serveur — `/servers/{id}`

- Informations du serveur (map actuelle, joueurs connectés)
- Liste des joueurs actuellement connectés
- Graphique d'activité (kills par heure via Chart.js)

### Statut JSON — `/servers/{id}/status`

Retourne en JSON : `online`, `act_players`, `max_players`, `act_map`.

---

## Armes — `/weapons`

Classement des armes par kills, headshots, pourcentages.

### Détail arme — `/weapons/{code}`

- Top joueurs avec cette arme (frags, headshots, HPK)

---

## Maps — `/maps`

Classement des maps par kills, headshots.

### Détail map — `/maps/{map}`

- Top joueurs sur cette map (frags, headshots, HPK)
- Nombre de joueurs uniques

---

## Chat — `/chat`

Historique des messages en jeu, paginés (100/page), filtrables par jeu.

---

## Pays — `/countries`

Classement des pays par joueurs.

- `/countries/clans` — Classement des pays par clans
- `/countries/clans/{flag}` — Détail des clans d'un pays

---

## Awards — `/awards`

Affichage des prix journaliers et globaux par jeu.

- `/awards/{id}/detail` — Classement global pour un award
- `/awards/rank/{id}` — Joueurs ayant atteint ce rang
- `/awards/ribbon/{id}` — Joueurs ayant ce ruban

---

## Rôles — `/roles`

Liste des rôles en jeu (sniper, médic, etc.).

- `/roles/{code}` — Top joueurs pour ce rôle

---

## Actions — `/actions`

Liste des actions bonus (plant bombe, rescue, etc.) avec nombre total.

- `/actions/{id}` — Top joueurs pour cette action

---

## Bans — `/bans`

Liste publique des joueurs bannis.

---

## Aide — `/help`

Documentation utilisateur :
- Présentation de HLStatsX
- Tableau de navigation
- Explication du système de skill
- Commandes in-game (`!statsme`, `!stats`, `!rank`, `!session`, `!top10`)

---

## Jeu — `/game/{code}`

Page dédiée à un jeu (top joueurs, serveurs, stats).

---

## Recherche — `/search`

Recherche globale par pseudo, clan, serveur.

---

## Redirection legacy — `/hlstats.php`

Support des URLs de l'ancienne version :

```
/hlstats.php?mode=players&game=cstrike  →  /players?game=cstrike
/hlstats.php?mode=clans                  →  /clans
/hlstats.php?mode=servers                →  /servers
```

---

## Changement de langue — `/language/{locale}`

Bascule la langue de l'interface (`en` ou `fr`) et redirige vers la page précédente.
