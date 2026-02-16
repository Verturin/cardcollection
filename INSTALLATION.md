# 🚀 Guide d'Installation - Card Collection

## 📋 Prérequis

### Serveur
- **phpBB** : Version 3.3.0 ou supérieure
- **PHP** : Version 7.1 ou supérieure (7.4+ recommandé)
- **Base de données** : MySQL 5.6+ ou MariaDB 10.1+
- **Extensions PHP** :
  - PDO MySQL
  - GD ou Imagick (pour traitement d'images)
  - JSON
  - cURL (pour widget)

### Hébergement
- Espace disque : 10 MB minimum pour l'extension + espace pour images
- Permissions : Possibilité de créer des dossiers et fichiers

---

## 🔧 Installation

### Méthode 1 : Via Git (Recommandé)

```bash
# Aller dans le dossier ext de phpBB
cd /chemin/vers/phpBB/ext

# Créer le dossier vendor si nécessaire
mkdir -p verturin

# Aller dans le dossier vendor
cd verturin

# Cloner le repository
git clone https://github.com/verturin/cardcollection.git

# Vérifier la structure
ls -la
# Vous devriez voir : cardcollection/
```

**Structure finale :**
```
phpBB/
└── ext/
    └── verturin/
        └── cardcollection/
            ├── composer.json
            ├── ext.php
            ├── migrations/
            ├── controller/
            ├── language/
            └── ...
```

### Méthode 2 : Téléchargement manuel

1. **Télécharger la dernière release**
   - Aller sur https://github.com/verturin/cardcollection/releases
   - Télécharger le fichier `.zip` ou `.tar.gz`

2. **Extraire l'archive**
   ```bash
   unzip cardcollection-v1.0.0.zip
   # ou
   tar -xzf cardcollection-v1.0.0.tar.gz
   ```

3. **Uploader sur le serveur**
   - Via FTP/SFTP : Uploader le dossier `cardcollection` dans `/ext/verturin/`
   - Via File Manager : Upload et extraction directe

4. **Vérifier les permissions**
   ```bash
   chmod -R 755 /chemin/vers/phpBB/ext/verturin/cardcollection
   ```

---

## ⚙️ Activation de l'Extension

### 1. Se connecter à l'ACP

- Aller sur votre forum
- Se connecter en tant qu'administrateur
- Accéder à **ACP** (Administration)

### 2. Activer l'extension

1. **ACP** > **Personnaliser** > **Gérer les extensions**
2. Trouver **"Card Collection"** dans la liste
3. Cliquer sur **"Activer"**
4. Attendre la fin de l'activation

**L'extension va automatiquement :**
- ✅ Créer les tables de base de données
- ✅ Installer les permissions
- ✅ Créer les modules ACP/UCP
- ✅ Configurer les paramètres par défaut

### 3. Vérifier l'activation

Vous devriez voir :
```
✅ Extension activée avec succès
```

Si erreur, voir la section [Dépannage](#dépannage).

---

## 🔐 Configuration des Permissions

### 1. Permissions utilisateurs

**ACP** > **Permissions** > **Permissions des groupes**

Pour **Utilisateurs enregistrés** :

| Permission | Valeur | Description |
|------------|--------|-------------|
| `u_cards_view` | ✅ Oui | Voir les cartes |
| `u_cards_create` | ✅ Oui | Créer des cartes |
| `u_cards_edit_own` | ✅ Oui | Modifier ses cartes |
| `u_cards_manage_collection` | ✅ Oui | Gérer sa collection |
| `u_cards_trade` | ✅ Oui | Proposer des échanges |
| `u_cards_claim_ownership` | ✅ Oui | Revendiquer des cartes |

### 2. Permissions modérateurs

**ACP** > **Permissions** > **Permissions des modérateurs**

| Permission | Valeur | Description |
|------------|--------|-------------|
| `m_cards_edit` | ✅ Oui | Modifier toutes cartes |
| `m_cards_delete` | ✅ Oui | Supprimer cartes |
| `m_cards_review_claims` | ✅ Oui | Examiner revendications |

### 3. Permissions administrateurs

Les administrateurs ont automatiquement toutes les permissions.

---

## ⚙️ Configuration de l'Extension

### 1. Paramètres généraux

**ACP** > **Extensions** > **Card Collection** > **Paramètres**

| Paramètre | Valeur recommandée | Description |
|-----------|-------------------|-------------|
| Cartes par page | 24 | Nombre de cartes affichées |
| Activer échanges | ✅ Oui | Système d'échanges |
| Activer export PDF | ✅ Oui | Export PDF collections |
| Taille max fichier | 10 MB | Limite upload |
| Dossier upload | files/cards | Chemin stockage |

### 2. Affichage sur l'index

| Paramètre | Valeur | Description |
|-----------|--------|-------------|
| Afficher sur index | ✅ Oui | Bloc sur page accueil |
| Nombre de cartes | 6 | Cartes affichées |
| Position | after_online | Emplacement |

### 3. Widget public

| Paramètre | Valeur | Description |
|-----------|--------|-------------|
| Activer widget | ✅ Oui | Widget embeddable |
| Limite widget | 6 | Cartes par défaut |
| Cache | 3600 | Durée cache (1h) |

### 4. Revendications

| Paramètre | Valeur | Description |
|-----------|--------|-------------|
| Exiger preuve | ✅ Oui | Photo obligatoire |
| Auto-approuver après | 7 jours | Si créateur inactif |
| Notifier créateur | ✅ Oui | Email changement |

---

## 📁 Structure des Dossiers

### Créer le dossier d'upload

```bash
# Depuis la racine de phpBB
mkdir -p files/cards
mkdir -p files/cards/proofs
chmod -R 755 files/cards
```

### Fichiers de protection

**Créer `files/cards/.htaccess` :**
```apache
# Bloquer l'exécution de scripts
<FilesMatch "\.(php|php3|php4|php5|phtml|pl|py|jsp|asp|sh|cgi)$">
    Order Allow,Deny
    Deny from all
</FilesMatch>

# Autoriser seulement les images
<FilesMatch "\.(jpg|jpeg|png|gif|webp|pdf)$">
    Order Allow,Deny
    Allow from all
</FilesMatch>
```

**Créer `files/cards/index.html` :**
```html
<!DOCTYPE html>
<html>
<head><title>403 Forbidden</title></head>
<body><h1>Forbidden</h1></body>
</html>
```

---

## ✅ Vérification de l'Installation

### Checklist complète

- [ ] Extension activée sans erreur
- [ ] Tables créées dans la base de données
- [ ] Permissions configurées
- [ ] Dossier `files/cards/` créé avec bonnes permissions
- [ ] Fichiers `.htaccess` et `index.html` créés
- [ ] Module visible dans ACP > Extensions
- [ ] Module UCP visible pour les utilisateurs
- [ ] Affichage sur index fonctionne
- [ ] Widget accessible (si activé)

### Tests rapides

**1. Créer une carte de test :**
- Se connecter en tant qu'utilisateur
- Aller sur le catalogue
- Créer une nouvelle carte
- Uploader une image

**2. Ajouter à sa collection :**
- Voir la carte créée
- Ajouter à sa collection
- Vérifier dans "Ma collection"

**3. Tester le widget :**
```html
<!-- Sur une page HTML externe -->
<div id="cards-widget" data-limit="3"></div>
<script src="https://votre-forum.com/app.php/cards/widget/script"></script>
```

---

## 🔄 Mise à Jour

### Depuis une version précédente

```bash
# Aller dans le dossier de l'extension
cd /chemin/vers/phpBB/ext/verturin/cardcollection

# Sauvegarder (au cas où)
cd ..
cp -r cardcollection cardcollection.backup

# Récupérer la nouvelle version
cd cardcollection
git pull origin main

# Désactiver puis réactiver l'extension
# ACP > Extensions > Card Collection > Désactiver
# ACP > Extensions > Card Collection > Activer

# Vider le cache phpBB
# ACP > Général > Purger le cache
```

---

## 🔧 <a name="dépannage"></a>Dépannage

### Extension n'apparaît pas

**Vérifier :**
1. Structure des dossiers correcte : `/ext/verturin/cardcollection/`
2. Fichier `composer.json` présent
3. Fichier `ext.php` présent
4. Permissions : `chmod -R 755 ext/verturin/cardcollection`

### Erreur lors de l'activation

**"Version phpBB insuffisante"**
```
→ Mettre à jour phpBB vers 3.3.0+
```

**"Erreur base de données"**
```
→ Vérifier permissions MySQL
→ Vérifier que les tables n'existent pas déjà
```

### Images ne s'uploadent pas

**Vérifier :**
1. Dossier `files/cards/` existe
2. Permissions : `chmod 755 files/cards`
3. Propriétaire : `chown www-data:www-data files/cards` (sur Linux)
4. Taille max PHP : `upload_max_filesize = 10M` dans php.ini

### Widget ne fonctionne pas

**Vérifier :**
1. Widget activé dans ACP
2. URL du script correcte
3. CORS non bloqué
4. Au moins 1 carte dans la base

### Traductions manquantes

**Solution :**
```bash
# Vérifier que les fichiers existent
ls -la language/fr/
ls -la language/en/

# Vider le cache
# ACP > Général > Purger le cache
```

---

## 📞 Support

### Documentation
- [README principal](README.md)
- [Guide widget](WIDGET_PUBLIC.md)
- [Guide revendication](REVENDICATION_PROPRIETE.md)
- [Comparaison versions](COMPARAISON.md)

### Communauté
- [GitHub Issues](https://github.com/verturin/cardcollection/issues)
- [GitHub Discussions](https://github.com/verturin/cardcollection/discussions)

### Rapporter un bug
1. Vérifier que le bug n'est pas déjà rapporté
2. Créer une issue sur GitHub
3. Fournir :
   - Version phpBB
   - Version PHP
   - Message d'erreur complet
   - Steps pour reproduire

---

## 🎉 Installation Terminée !

Votre extension **Card Collection** est maintenant prête à l'emploi !

**Prochaines étapes :**
1. ✅ Créer votre première carte
2. ✅ Personnaliser les paramètres
3. ✅ Inviter vos membres
4. ✅ Configurer le widget (optionnel)
5. ✅ Lire la documentation complète

**Bon usage !** 🎴
