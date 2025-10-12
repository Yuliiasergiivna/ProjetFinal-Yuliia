# Configuration du système de téléchargement de photos

## ✅ Modifications effectuées

### 1. **PhotoController.php** - Contrôleur amélioré
- ✅ Ajout de la sécurité avec `denyAccessUnlessGranted`
- ✅ Gestion correcte du téléchargement de fichiers
- ✅ Messages flash pour informer l'utilisateur
- ✅ Gestion des erreurs avec try/catch
- ✅ Récupération et affichage de toutes les photos

### 2. **Photo.php** - Entité mise à jour
- ✅ Ajout du champ `slug` (nullable)
- ✅ Méthodes `getSlug()` et `setSlug()` ajoutées

### 3. **PhotoType.php** - Formulaire amélioré
- ✅ Ajout du champ `image` de type `FileType`
- ✅ Validation des fichiers (taille max: 5MB)
- ✅ Types MIME autorisés: JPEG, PNG, GIF, WEBP
- ✅ Labels en français pour tous les champs
- ✅ Amélioration des choix pour Attraction et Utilisateur

### 4. **index.html.twig** - Template modernisé
- ✅ Affichage des messages flash
- ✅ Formulaire complet avec tous les champs
- ✅ Affichage des photos en grille avec Bootstrap cards
- ✅ Attribut `enctype="multipart/form-data"` pour le téléchargement

### 5. **Structure de répertoires**
- ✅ Création du répertoire `public/uploads/photos/`
- ✅ Configuration dans `services.yaml` déjà présente

## 📋 Étapes à suivre pour finaliser

### 1. Mettre à jour la base de données

Exécutez cette commande pour créer une migration :

```bash
php bin/console make:migration
```

Puis appliquez la migration :

```bash
php bin/console doctrine:migrations:migrate
```

### 2. Vérifier les entités Attraction et Utilisateur

Le formulaire utilise maintenant :
- `choice_label: 'nom'` pour Attraction
- `choice_label: 'email'` pour Utilisateur

Assurez-vous que ces propriétés existent dans vos entités. Si ce n'est pas le cas, modifiez les lignes 46 et 52 dans `src/Form/PhotoType.php`.

### 3. Permissions du répertoire uploads

Sur certains systèmes, vous devrez peut-être définir les permissions :

```bash
# Linux/Mac
chmod -R 775 public/uploads/photos

# Windows (généralement pas nécessaire avec XAMPP)
```

### 4. Tester l'application

1. Démarrez votre serveur Symfony :
   ```bash
   symfony server:start
   # ou
   php -S localhost:8000 -t public
   ```

2. Accédez à `/photo` dans votre navigateur

3. Testez le téléchargement d'une image

## 🔒 Sécurité

Le contrôleur vérifie maintenant que l'utilisateur est connecté avec :
```php
$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
```

Si vous voulez permettre l'accès sans authentification, supprimez cette ligne (ligne 22 du PhotoController.php).

## 📝 Notes importantes

1. **Champ URL** : Le champ `url` de l'entité Photo stocke le chemin complet de l'image (ex: `/uploads/photos/nom-fichier-123456.jpg`)

2. **Champ slug** : Généré automatiquement à partir du nom de la photo

3. **Validation** : Le formulaire accepte uniquement les images jusqu'à 5MB

4. **Types de fichiers** : JPEG, PNG, GIF, WEBP

## 🐛 Dépannage

### Erreur "Unable to create the directory"
- Vérifiez les permissions du dossier `public/uploads/photos/`

### Erreur "The file could not be uploaded"
- Vérifiez la configuration `upload_max_filesize` dans `php.ini`
- Vérifiez `post_max_size` dans `php.ini`

### Les images ne s'affichent pas
- Vérifiez que le chemin dans la base de données commence par `/uploads/photos/`
- Vérifiez que les fichiers sont bien dans `public/uploads/photos/`

## 📚 Ressources

- [Documentation Symfony - Upload de fichiers](https://symfony.com/doc/current/controller/upload_file.html)
- [Documentation Symfony - Formulaires](https://symfony.com/doc/current/forms.html)
