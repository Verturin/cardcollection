# 🎴 Card Collection - Extension phpBB

## 📋 Description

**Card Collection** est une extension complète pour phpBB 3.3+ qui transforme votre forum en une plateforme de gestion de collections de cartes.

### ✨ Fonctionnalités principales :

- 🎴 **Gestion de cartes** : Créer et gérer des cartes avec images/PDF
- 📚 **Collections personnelles** : Gérer sa collection avec quantités
- ⭐ **Wantlist (Mancolist)** : Lister les cartes recherchées avec priorités
- 🔄 **Système d'échanges** : Proposer et gérer des échanges entre membres
- 🖨️ **Export PDF** : Imprimer sa collection (9 cartes/page A4)
- 🌍 **Multilingue** : Français et Anglais intégrés
- 📊 **Quantités limitées** : Gestion des éditions limitées
- 🔐 **Système de permissions** : Contrôle d'accès granulaire
- 📱 **Responsive** : Compatible mobile, tablette, desktop

### 🎯 Cas d'usage :

- **Geocaching** : Cartes d'événements, cartes de géocacheurs
- **Trading Cards** : Pokemon, Magic, Yu-Gi-Oh, etc.
- **Cartes personnalisées** : Tout type de collection
- **Badges d'événements** : Conventions, meetups
- **Cartes de visite** : Networking professionnel

---

## 🚀 Installation

### Prérequis :

- phpBB 3.3.0 ou supérieur
- PHP 7.1 ou supérieur
- MySQL 5.6+ ou MariaDB
- Extensions PHP : GD ou Imagick (pour traitement images)

### Étape 1 : Téléchargement

Téléchargez l'archive de l'extension et extrayez-la.

### Étape 2 : Upload

Uploadez le dossier `cardcollection` dans :
```
/ext/cardcollection/cardcollection/
```

Structure finale :
```
phpBB/
├── ext/
│   └── cardcollection/
│       └── cardcollection/
│           ├── composer.json
│           ├── ext.php
│           ├── migrations/
│           ├── controller/
│           ├── language/
│           └── ...
```

### Étape 3 : Activation

1. Connectez-vous à votre **ACP** (Admin Control Panel)
2. Allez dans **Customize** > **Manage extensions**
3. Trouvez **Card Collection**
4. Cliquez sur **Enable**

L'extension va :
- ✅ Créer les tables de base de données
- ✅ Installer les permissions
- ✅ Ajouter les modules ACP et UCP
- ✅ Configurer les paramètres par défaut

### Étape 4 : Permissions

Allez dans **Permissions** et vérifiez/ajustez :

**Permissions utilisateurs :**
- `u_cards_view` - Voir les cartes
- `u_cards_create` - Créer des cartes
- `u_cards_edit_own` - Modifier ses propres cartes
- `u_cards_manage_collection` - Gérer sa collection
- `u_cards_trade` - Proposer des échanges

**Permissions modérateurs :**
- `m_cards_edit` - Modifier toutes les cartes
- `m_cards_delete` - Supprimer des cartes

**Permissions administrateurs :**
- `a_cards_manage` - Administration complète

### Étape 5 : Configuration

**ACP** > **Extensions** > **Card Collection** > **Settings**

Paramètres disponibles :
- Nombre de cartes par page (défaut: 24)
- Activer les échanges (oui/non)
- Activer l'export PDF (oui/non)
- Taille max fichier (défaut: 10 MB)
- Dossier d'upload (défaut: files/cards)

---

## 📂 Structure de l'extension

```
cardcollection/
├── composer.json                 # Métadonnées Composer
├── ext.php                       # Classe de base
├── LICENSE                       # Licence GPL-2.0
├── README.md                     # Documentation
│
├── adm/                          # Admin Control Panel
│   └── style/                    # Templates ACP
│
├── acp/                          # Modules ACP
│   └── main_module.php
│
├── config/                       # Services
│   └── services.yml
│
├── controller/                   # Contrôleurs
│   ├── main.php                  # Contrôleur principal
│   ├── catalog.php               # Catalogue public
│   ├── collection.php            # Collection utilisateur
│   ├── trade.php                 # Échanges
│   └── admin.php                 # Administration
│
├── event/                        # Event listeners
│   └── main_listener.php
│
├── language/                     # Traductions
│   ├── en/
│   │   ├── common.php
│   │   ├── info_acp_main.php
│   │   └── permissions_cards.php
│   └── fr/
│       ├── common.php
│       ├── info_acp_main.php
│       └── permissions_cards.php
│
├── migrations/                   # Migrations base de données
│   ├── install_schema.php
│   └── install_permissions.php
│
├── styles/                       # Templates et CSS
│   └── prosilver/
│       ├── template/
│       │   ├── catalog.html
│       │   ├── card_detail.html
│       │   ├── collection.html
│       │   └── trade.html
│       └── theme/
│           └── cards.css
│
└── ucp/                          # User Control Panel
    └── main_module.php
```

---

## 🎯 Utilisation

### Pour les utilisateurs :

**Voir le catalogue :**
```
https://votre-forum.com/app.php/cards/catalog
```

**Gérer sa collection :**
```
UCP > Card Collection > My Collection
```

**Voir sa wantlist :**
```
UCP > Card Collection > My Wantlist
```

**Gérer les échanges :**
```
UCP > Card Collection > Trades
```

### Pour les administrateurs :

**Administration :**
```
ACP > Extensions > Card Collection
```

Options disponibles :
- **Settings** : Configuration générale
- **Manage Cards** : Gérer toutes les cartes
- **Statistics** : Statistiques globales

---

## 🔧 Intégration phpBB

### Avantages de l'extension :

✅ **Système de permissions phpBB**
- Contrôle d'accès granulaire
- Intégration avec les groupes
- Gestion des rôles

✅ **Authentification unifiée**
- Un seul compte pour forum + collection
- Pas de double connexion
- Gestion utilisateurs centralisée

✅ **Interface cohérente**
- Style prosilver natif
- Responsive comme phpBB
- Même navigation

✅ **Notifications phpBB**
- Notifications d'échanges
- Alertes de messages
- Système unifié

✅ **Liens vers profils**
- Intégration avec les profils phpBB
- Voir les cartes d'un membre
- Statistiques dans le profil

✅ **Recherche intégrée**
- Recherche de cartes
- Filtres avancés
- Indexation phpBB

---

## 🌍 Multilingue

L'extension est entièrement traduite en :
- 🇫🇷 **Français**
- 🇬🇧 **English**

### Ajouter une langue :

1. Créer `/language/CODE/common.php`
2. Copier le contenu de `en/common.php`
3. Traduire toutes les clés
4. Rafraîchir le cache phpBB

Fichiers de langue :
```
language/
├── en/
│   ├── common.php              # Traductions générales
│   ├── info_acp_main.php       # ACP
│   └── permissions_cards.php   # Permissions
└── fr/
    ├── common.php
    ├── info_acp_main.php
    └── permissions_cards.php
```

---

## 📊 Base de données

### Tables créées :

| Table | Description |
|-------|-------------|
| `phpbb_cards` | Cartes |
| `phpbb_card_collections` | Collections utilisateurs |
| `phpbb_card_wantlists` | Listes de recherche |
| `phpbb_card_trades` | Propositions d'échange |
| `phpbb_card_trade_items` | Détails des échanges |

**Note :** Le préfixe `phpbb_` dépend de votre configuration.

---

## 🔐 Sécurité

L'extension respecte les standards phpBB :

✅ **Protection CSRF** - Tokens de formulaire
✅ **SQL Injection** - Requêtes préparées
✅ **XSS** - Échappement des sorties
✅ **Upload sécurisé** - Validation types MIME
✅ **Permissions** - Vérification à chaque action
✅ **Validation** - Toutes les entrées utilisateur

---

## 🎨 Personnalisation

### CSS personnalisé :

Modifier `/styles/prosilver/theme/cards.css`

Ou créer un style enfant :
```
/styles/votre_style/
└── theme/
    └── cards.css
```

### Templates personnalisés :

Créer un style personnalisé basé sur prosilver :
```
/styles/votre_style/
└── template/
    ├── catalog.html
    ├── card_detail.html
    └── ...
```

---

## 🆘 Dépannage

### L'extension ne s'active pas :

1. Vérifier la version phpBB (>= 3.3.0)
2. Vérifier les permissions des fichiers
3. Consulter les logs d'erreur phpBB
4. Vider le cache : `ACP > General > Purge cache`

### Les images ne s'uploadent pas :

1. Vérifier les permissions du dossier `/files/cards/`
2. Chmod 755 ou 777 selon configuration
3. Vérifier `upload_max_filesize` dans php.ini
4. Vérifier `post_max_size` dans php.ini

### Tables non créées :

1. Réactiver l'extension
2. Vérifier les permissions MySQL
3. Exécuter manuellement les migrations :
```
php bin/phpbbcli.php extension:migrate cardcollection/cardcollection
```

### Traductions manquantes :

1. Vérifier que les fichiers existent dans `/language/`
2. Vider le cache phpBB
3. Régénérer le cache : `ACP > General > Purge cache`

---

## 📈 Performance

### Optimisations recommandées :

**Base de données :**
- Index sur `player_username`, `card_year`, `card_series`
- Index sur `user_id`, `card_id` pour les collections

**Cache :**
- Activer le cache phpBB
- Utiliser APCu ou Redis si disponible

**Images :**
- Compresser avant upload (<1 MB)
- Utiliser Imagick pour optimisation auto

**Serveur :**
- PHP 7.4+ recommandé
- OPcache activé
- MySQL 5.7+ ou MariaDB 10.3+

---

## 🔄 Mise à jour

### Depuis le package :

1. **Désactiver** l'extension (ne pas désinstaller !)
2. Remplacer les fichiers dans `/ext/cardcollection/`
3. **Réactiver** l'extension
4. Vider le cache phpBB

Les données sont préservées.

### Migration des données :

Si vous aviez le site standalone, créez une migration personnalisée ou contactez le support.

---

## 🎯 Roadmap

### Version 1.1 (prévue) :

- [ ] Import/Export CSV
- [ ] Graphiques de statistiques
- [ ] API REST
- [ ] Application mobile
- [ ] Scan QR codes
- [ ] Notifications push

### Version 1.2 (future) :

- [ ] Marketplace intégré
- [ ] Évaluation des cartes
- [ ] Historique des prix
- [ ] Recommandations IA

---

## 🤝 Support

### Documentation :

- README : `/ext/cardcollection/cardcollection/README.md`
- Wiki : https://github.com/cardcollection/wiki
- FAQ : https://cardcollection.com/faq

### Communauté :

- Forum officiel phpBB
- GitHub Issues
- Support email

### Contribution :

Pull requests bienvenues !

---

## 📄 Licence

**GNU General Public License v2.0**

Voir le fichier `LICENSE` pour plus de détails.

---

## 👥 Crédits

Développé par l'équipe Card Collection.

Basé sur phpBB 3.3+ Framework.

---

## 🎉 Merci d'utiliser Card Collection !

Transformez votre forum phpBB en plateforme de collection de cartes complète.

**Support :** contact@cardcollection.com
**Site web :** https://cardcollection.com
**GitHub :** https://github.com/cardcollection/cardcollection

