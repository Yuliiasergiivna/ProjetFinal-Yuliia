# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Symfony 7.3 application for exploring Ukrainian tourist attractions. It features user authentication, attraction management with geolocation (latitude/longitude), photo uploads, favorites, routes/itineraries, and a map interface.

**Database:** MySQL (database name: `yuliia`)

## Development Commands

### Database Management

**Complete database reset (recommended):**
```bash
./databaseRestart.sh
```
This script:
- Removes old migrations
- Drops and recreates the database
- Creates new migrations
- Applies migrations
- Loads fixtures

**Manual database operations:**
```bash
# Drop and recreate database
symfony console doctrine:database:drop --force
symfony console doctrine:database:create

# Create and run migrations
symfony console make:migration
symfony console doctrine:migration:migrate

# Load fixtures (clears existing data)
symfony console doctrine:fixtures:load

# Load fixtures without clearing (append mode - may cause duplicates)
symfony console doctrine:fixtures:load --append
```

### Running the Application

```bash
# Start Symfony development server
symfony server:start

# Alternative: PHP built-in server
php -S localhost:8000 -t public
```

### Testing

```bash
# Run all tests
vendor/bin/phpunit

# Run specific test file
vendor/bin/phpunit tests/path/to/TestFile.php

# Run with coverage (if xdebug enabled)
vendor/bin/phpunit --coverage-html coverage
```

### Code Generation

```bash
# Generate a new entity
symfony console make:entity

# Generate a new controller
symfony console make:controller

# Generate a new form type
symfony console make:form

# Generate fixtures
symfony console make:fixtures
```

### Cache Management

```bash
# Clear cache
symfony console cache:clear

# Warm up cache
symfony console cache:warmup
```

## Architecture

### Core Domain Model

The application centers around Ukrainian tourist attractions with the following key entities:

**Attraction** - Tourist attractions with:
- Basic info: name, description, route
- Geolocation: latitude, longitude (DECIMAL 10,7 precision)
- Relationships: photos, favorites, routes, likes
- Category association

**Utilisateur** (User) - User accounts implementing Symfony UserInterface:
- Authentication: email (unique identifier), password
- Profile: nom, dateNaissance
- User-generated content: photos, comments, favorites, routes
- Social features: likes on comments and attractions

**Photo** - User-uploaded images:
- File storage: `public/uploads/photos/` directory
- Photo entity stores the URL path
- Associated with attractions and users
- Includes optional slug field

**Route** - User-created itineraries:
- Links multiple attractions via RouteAttraction join entity
- Owned by a user
- Has name and description

**Category** - Classification system for attractions

**Favorite** - Many-to-many relationship tracking user favorites

**Comment** - User comments on attractions with like functionality

### Key Relationships

- `Utilisateur` ↔ `Attraction`: ManyToMany for likes (attractionLikes)
- `Utilisateur` → `Photo/Comment/Favorite/Route`: OneToMany (user owns these)
- `Attraction` → `Photo/Favorite`: OneToMany
- `Attraction` ↔ `Route`: ManyToMany through `RouteAttraction` join table
- `Category` → `Attraction`: OneToMany

### Controllers & Routes

**PhotoController** (`/photo`):
- Handles photo upload with file validation (max 5MB, JPEG/PNG/GIF/WEBP)
- Requires authentication (`IS_AUTHENTICATED_FULLY`)
- Stores files in `public/uploads/photos/`

**MapController** (`/map`, `/api/points-of-interest`):
- Displays interactive map with attractions
- JSON API endpoint for point-of-interest data

**AttractionController** - Manages attraction CRUD operations

**SecurityController** - Login/logout functionality

**RegistrationController** - User registration

**AccueilController** - Homepage

**FormsController** - Form handling

**CategoryController** - Category management

**FavoriteController** - User favorites

**RouteController** - Route/itinerary management

**ProfilController** - User profile

**AjaxContollerController** - AJAX endpoints

### Forms

All form types are in `src/Form/`:
- `PhotoType`: File upload with validation constraints
- `AttractionType`: Attraction creation/editing with latitude/longitude
- `RegistrationFormType`: User registration with password confirmation
- `UtilisateurType`: User profile editing
- `CommentType`: Comment forms
- `CategorieType`: Category management

### Data Fixtures

Comprehensive fixtures in `src/DataFixtures/`:
- `UkraineAttractionFixtures`: Pre-populated Ukrainian attractions
- `AttractionFixtures`: General attraction data
- `UtilisateurFixtures`: Test users
- `CategorieFixtures`: Categories
- `PhotoFixtures`, `CommentFixtures`, `FavoriteFixtures`, `RouteFixtures`, `RouteAttractionFixtures`

Load fixtures after migrations using `symfony console doctrine:fixtures:load`

### Configuration

**Services** (`config/services.yaml`):
- `photo_directory` parameter: `%kernel.project_dir%/public/uploads/photos`

**Security** (`config/packages/security.yaml`):
- User provider: Utilisateur entity
- Password hashing configured
- Form login authentication

**Asset Management**:
- Uses Symfony AssetMapper (no webpack/encore)
- Configuration in `config/packages/asset_mapper.yaml`
- Import map in `importmap.php`

### Templates

Twig templates organized by controller in `templates/`:
- `base.html.twig`: Main layout template
- Feature-specific directories: `accueil/`, `attraction/`, `category/`, `photo/`, `map/`, `profil/`, `registration/`, `security/`, etc.

## Important Notes

### Photo Upload System
- Upload directory: `public/uploads/photos/`
- Ensure directory exists and is writable (775 permissions on Linux/Mac)
- File validation in PhotoType form
- URL field in Photo entity stores relative path (e.g., `/uploads/photos/filename.jpg`)
- Refer to `PHOTO_UPLOAD_SETUP.md` for detailed configuration

### Geolocation
- Attractions have `latitude` and `longitude` fields (DECIMAL 10,7)
- Used for map display via MapController

### Authentication
- Most features require authentication
- Controllers use `$this->denyAccessUnlessGranted()` for access control
- User identifier: email address

### Database Conventions
- Use `symfony console make:migration` after entity changes
- Always review migrations before applying
- Use fixtures for consistent test data
- The `databaseRestart.sh` script is the fastest way to reset everything during development

### Testing Environment
- Test environment configured in `phpunit.dist.xml`
- Uses separate APP_ENV=test
- Test directory: `tests/`

## Common Workflows

### Adding a New Feature with Database Changes
1. Create/modify entity: `symfony console make:entity EntityName`
2. Generate migration: `symfony console make:migration`
3. Review migration file in `migrations/`
4. Apply migration: `symfony console doctrine:migration:migrate`
5. (Optional) Create fixtures: `symfony console make:fixtures`
6. Load fixtures: `symfony console doctrine:fixtures:load`

### Creating a New Controller with Routes
1. Generate controller: `symfony console make:controller ControllerName`
2. Add route attributes to controller methods
3. Create corresponding Twig templates in `templates/controller_name/`

### Working with Forms
1. Generate form type: `symfony console make:form`
2. Reference entity relationships use `EntityType` field
3. For Attraction: use `choice_label: 'name'`
4. For Utilisateur: use `choice_label: 'email'`
