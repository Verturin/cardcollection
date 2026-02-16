# 🔧 Guide de Dépannage - Erreurs de Migration

## ❌ Erreur Courante

```
Un problème a été rencontré durant l'opération de mise à jour de la base de données.
L'opération de mise à jour « \verturin\cardcollection\migrations\install_permissions » 
n'est pas complète, il manque la mise à jour « \phpbb\db\migration\data\v33x\v330 ».
```

### 🔍 Cause

Cette erreur se produit quand :
- La migration fait référence à une version de phpBB qui n'existe pas sur votre installation
- Les dépendances de migrations sont incorrectes

### ✅ Solution

L'extension a été corrigée pour utiliser une migration unique compatible avec **phpBB 3.2.0+**.

---

## 🛠️ Si vous avez déjà installé une version qui a échoué

### Étape 1 : Désactiver l'extension (si possible)

**ACP** > **Personnaliser** > **Gérer les extensions** > **Card Collection** > **Désactiver**

### Étape 2 : Nettoyer les tables partielles (si créées)

Connectez-vous à **phpMyAdmin** et vérifiez si des tables ont été créées :

```sql
-- Vérifier les tables
SHOW TABLES LIKE '%card%';

-- Si des tables existent, les supprimer
DROP TABLE IF EXISTS phpbb_cards;
DROP TABLE IF EXISTS phpbb_card_collections;
DROP TABLE IF EXISTS phpbb_card_wantlists;
DROP TABLE IF EXISTS phpbb_card_trades;
DROP TABLE IF EXISTS phpbb_card_trade_items;
DROP TABLE IF EXISTS phpbb_card_ownership_claims;
DROP TABLE IF EXISTS phpbb_card_ownership_history;
```

**⚠️ Attention :** Remplacez `phpbb_` par votre préfixe de tables si différent.

### Étape 3 : Nettoyer les entrées de migration

Dans phpMyAdmin :

```sql
-- Voir les migrations de l'extension
SELECT * FROM phpbb_migrations 
WHERE migration_name LIKE '%verturin%cardcollection%';

-- Supprimer les entrées
DELETE FROM phpbb_migrations 
WHERE migration_name LIKE '%verturin%cardcollection%';
```

### Étape 4 : Mettre à jour les fichiers de l'extension

```bash
# Si installé via Git
cd phpBB/ext/verturin/cardcollection
git pull origin main

# Si installé manuellement
# - Télécharger la dernière version
# - Remplacer les fichiers
```

### Étape 5 : Vider le cache phpBB

**ACP** > **Général** > **Purger le cache**

### Étape 6 : Réactiver l'extension

**ACP** > **Personnaliser** > **Gérer les extensions** > **Card Collection** > **Activer**

---

## 🆕 Installation Propre (Nouvelle Installation)

### Prérequis

Vérifier la version de phpBB :

**ACP** > **Général** > Voir en bas de page

L'extension nécessite **phpBB 3.2.0 ou supérieur**.

### Installation

1. **Uploader l'extension** dans `/ext/verturin/cardcollection/`

2. **Vérifier les permissions**
   ```bash
   chmod -R 755 ext/verturin/cardcollection
   ```

3. **Activer l'extension**
   - **ACP** > **Personnaliser** > **Gérer les extensions**
   - Trouver **"Card Collection"**
   - Cliquer **"Activer"**

4. **Vérifier que tout fonctionne**
   - Aucune erreur ne doit apparaître
   - Les tables doivent être créées
   - Les permissions doivent être ajoutées

---

## 🔍 Vérification Post-Installation

### 1. Vérifier les tables

Dans **phpMyAdmin** :

```sql
-- Doivent toutes retourner des résultats
SHOW TABLES LIKE '%cards%';
SHOW TABLES LIKE '%card_collections%';
SHOW TABLES LIKE '%card_wantlists%';
SHOW TABLES LIKE '%card_trades%';
SHOW TABLES LIKE '%card_ownership%';
```

Vous devriez voir **7 tables** :
- `phpbb_cards`
- `phpbb_card_collections`
- `phpbb_card_wantlists`
- `phpbb_card_trades`
- `phpbb_card_trade_items`
- `phpbb_card_ownership_claims`
- `phpbb_card_ownership_history`

### 2. Vérifier les permissions

```sql
-- Doivent retourner 10 lignes
SELECT * FROM phpbb_acl_options 
WHERE auth_option LIKE '%cards%';
```

Permissions qui doivent exister :
- `u_cards_view`
- `u_cards_create`
- `u_cards_edit_own`
- `u_cards_manage_collection`
- `u_cards_trade`
- `u_cards_claim_ownership`
- `m_cards_edit`
- `m_cards_delete`
- `m_cards_review_claims`
- `a_cards_manage`

### 3. Vérifier la configuration

```sql
-- Doivent retourner 14 lignes
SELECT * FROM phpbb_config 
WHERE config_name LIKE 'cards_%';
```

---

## 💡 Problèmes Courants

### "Extension activée mais rien ne se passe"

**Solution :**
1. Vider le cache : **ACP** > **Général** > **Purger le cache**
2. Vérifier les permissions utilisateur
3. Vérifier que les tables existent

### "Impossible de créer une carte"

**Vérifications :**
1. Permissions : `u_cards_create` activée pour les utilisateurs
2. Dossier upload existe : `/files/cards/` avec permissions 755
3. Taille max upload PHP suffisante (10 MB)

### "Widget ne fonctionne pas"

**Vérifications :**
1. Widget activé : `cards_enable_widget = 1`
2. Au moins 1 carte dans la base
3. CORS non bloqué par le serveur

---

## 📞 Support Complémentaire

### Documentation
- [Installation complète](INSTALLATION.md)
- [README principal](README.md)
- [GitHub Issues](https://github.com/verturin/cardcollection/issues)

### Rapporter un Bug

Si le problème persiste, créer une issue avec :
1. Version phpBB exacte
2. Version PHP
3. Message d'erreur complet
4. Capture d'écran si possible
5. Étapes déjà tentées

---

## ✅ Checklist de Succès

Après installation réussie, vous devez pouvoir :

- [ ] Voir "Card Collection" dans la liste des extensions actives
- [ ] Accéder à **ACP** > **Extensions** > **Card Collection**
- [ ] Les 7 tables sont créées dans la base de données
- [ ] Les 10 permissions existent
- [ ] Les utilisateurs peuvent créer des cartes
- [ ] Le bloc apparaît sur l'index (si activé)
- [ ] Le widget est accessible

Si tous les points sont cochés : **Installation réussie !** 🎉

---

## 🔄 Désinstallation Propre

Si vous devez désinstaller complètement :

1. **Désactiver l'extension**
   - **ACP** > **Extensions** > **Card Collection** > **Désactiver**

2. **Supprimer les données** (si souhaité)
   - Cocher "Supprimer les données"
   - Confirmer

3. **Supprimer les fichiers**
   ```bash
   rm -rf ext/verturin/cardcollection
   ```

4. **Vérifier la base de données**
   - Les tables doivent être supprimées
   - Les permissions doivent être supprimées
   - La config doit être nettoyée

---

**La migration unique simplifie grandement l'installation et évite les problèmes de dépendances !** 🚀
