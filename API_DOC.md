# Documentation API SmartAgriChange Backend

## Vue d'ensemble

L'API SmartAgriChange Backend est une API RESTful construite avec Laravel 11 qui fournit des services pour la gestion agricole intelligente. Cette API permet la gestion des utilisateurs (agriculteurs), des champs, des parcelles et des services d'authentification avec vérification OTP.

### URL de base

```
http://localhost:8000/api
```

### Format de réponse

Toutes les réponses de l'API suivent un format standardisé :

**Réponse de succès:**

```json
{
    "status": "success",
    "message": "Message descriptif",
    "data": {
        // Données de la réponse
    }
}
```

**Réponse d'erreur:**

```json
{
    "status": "error",
    "message": "Message d'erreur",
    "errors": {
        // Détails des erreurs
    }
}
```

### Authentification

L'API utilise JWT (JSON Web Tokens) pour l'authentification. Incluez le token dans l'en-tête Authorization :

```
Authorization: Bearer {votre_jwt_token}
```

---

## Endpoints de l'API

### 1. Gestion des Utilisateurs

#### 1.1 Inscription d'un Agriculteur

**POST** `/api/users/farmers/register`

Crée un nouveau compte agriculteur dans le système.

**Corps de la requête:**

```json
{
    "lastname": "Dupont",
    "firstname": "Jean",
    "phone_number": "123456789",
    "password": "motdepasse123",
    "password_confirmation": "motdepasse123",
    "calling_code": "+33"
}
```

**Paramètres:**
| Paramètre | Type | Requis | Description |
|-----------|------|--------|-------------|
| lastname | string | Oui | Nom de famille (max: 255 caractères) |
| firstname | string | Oui | Prénom (max: 255 caractères) |
| phone_number | string | Oui | Numéro de téléphone (max: 20 caractères) |
| password | string | Oui | Mot de passe (min: 8 caractères) |
| password_confirmation | string | Oui | Confirmation du mot de passe |
| calling_code | string | Optionnel | Code d'appel du pays (max: 10 caractères) |

**Réponse de succès (201):**

```json
{
    "status": "success",
    "message": "User created successfully",
    "data": {
        "id": 1,
        "lastname": "Dupont",
        "firstname": "Jean",
        "phone_number": "123456789",
        "calling_code": "+33",
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-15T10:30:00.000000Z"
    }
}
```

**Réponses d'erreur:**

-   `422 Unprocessable Entity`: Erreurs de validation
-   `500 Internal Server Error`: Erreur serveur

---

#### 1.2 Connexion Utilisateur

**POST** `/api/users/login`

Authentifie un utilisateur et retourne un token JWT.

> **Note**: Cette fonctionnalité est définie dans les routes mais n'est pas encore implémentée dans le contrôleur.

**Corps de la requête:**

```json
{
    "phone_number": "123456789",
    "password": "motdepasse123"
}
```

---

#### 1.3 Déconnexion Utilisateur

**POST** `/api/users/logout`

Révoque le token JWT de l'utilisateur authentifié.

> **Note**: Cette fonctionnalité est définie dans les routes mais n'est pas encore implémentée dans le contrôleur.

**En-têtes requis:**

```
Authorization: Bearer {jwt_token}
```

---

### 2. Gestion OTP (One-Time Password)

#### 2.1 Vérification OTP

**POST** `/api/users/{user}/verify-otp`

Vérifie le code OTP pour un utilisateur spécifique.

**Paramètres d'URL:**
| Paramètre | Type | Description |
|-----------|------|-------------|
| user | integer | ID de l'utilisateur |

**Corps de la requête:**

```json
{
    "otp_code": "123456"
}
```

**Paramètres:**
| Paramètre | Type | Requis | Description |
|-----------|------|--------|-------------|
| otp_code | string | Oui | Code OTP à 6 chiffres |

**Réponse de succès (200):**

```json
{
    "status": "success",
    "message": "OTP verified successfully",
    "data": null
}
```

**Réponse d'échec (200):**

```json
{
    "status": "success",
    "message": "OTP verification failed",
    "data": null
}
```

**Réponses d'erreur:**

-   `422 Unprocessable Entity`: Code OTP invalide ou inexistant
-   `500 Internal Server Error`: Erreur serveur

---

### 3. Gestion des Champs

#### 3.1 Lister les Champs

**GET** `/api/fields`

Récupère la liste de tous les champs.

> **Note**: Cette fonctionnalité n'est pas encore implémentée.

---

#### 3.2 Créer un Champ

**POST** `/api/fields`

Crée un nouveau champ pour l'utilisateur authentifié.

**En-têtes requis:**

```
Authorization: Bearer {jwt_token}
Content-Type: application/json
```

**Corps de la requête:**

```json
{
    "name": "Champ Principal",
    "location": "Bretagne, France"
}
```

**Paramètres:**
| Paramètre | Type | Requis | Description |
|-----------|------|--------|-------------|
| name | string | Oui | Nom du champ (max: 255 caractères) |
| location | string | Oui | Localisation du champ (max: 255 caractères) |

**Réponse de succès (201):**

```json
{
    "status": "success",
    "message": "Field created successfully",
    "data": {
        "id": 1,
        "name": "Champ Principal",
        "location": "Bretagne, France",
        "user_id": 1,
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-15T10:30:00.000000Z"
    }
}
```

**Réponses d'erreur:**

-   `401 Unauthorized`: Token JWT manquant ou invalide
-   `422 Unprocessable Entity`: Erreurs de validation
-   `500 Internal Server Error`: Erreur serveur

---

#### 3.3 Afficher un Champ

**GET** `/api/fields/{field}`

Récupère les détails d'un champ spécifique.

> **Note**: Cette fonctionnalité n'est pas encore implémentée.

---

#### 3.4 Modifier un Champ

**PUT/PATCH** `/api/fields/{field}`

Modifie un champ existant.

> **Note**: Cette fonctionnalité n'est pas encore implémentée.

---

#### 3.5 Supprimer un Champ

**DELETE** `/api/fields/{field}`

Supprime un champ existant.

> **Note**: Cette fonctionnalité n'est pas encore implémentée.

---

### 4. Gestion des Parcelles

#### 4.1 Lister les Parcelles

**GET** `/api/parcels`

Récupère la liste de toutes les parcelles.

> **Note**: Cette fonctionnalité n'est pas encore implémentée.

---

#### 4.2 Créer une Parcelle

**POST** `/api/parcels`

Crée une nouvelle parcelle.

> **Note**: Cette fonctionnalité n'est pas encore implémentée.

---

#### 4.3 Afficher une Parcelle

**GET** `/api/parcels/{parcel}`

Récupère les détails d'une parcelle spécifique.

> **Note**: Cette fonctionnalité n'est pas encore implémentée.

---

#### 4.4 Modifier une Parcelle

**PUT/PATCH** `/api/parcels/{parcel}`

Modifie une parcelle existante.

> **Note**: Cette fonctionnalité n'est pas encore implémentée.

---

#### 4.5 Supprimer une Parcelle

**DELETE** `/api/parcels/{parcel}`

Supprime une parcelle existante.

> **Note**: Cette fonctionnalité n'est pas encore implémentée.

---

## Codes de Statut HTTP

| Code | Description                                  |
| ---- | -------------------------------------------- |
| 200  | OK - Requête réussie                         |
| 201  | Created - Ressource créée avec succès        |
| 400  | Bad Request - Requête malformée              |
| 401  | Unauthorized - Authentification requise      |
| 403  | Forbidden - Accès interdit                   |
| 404  | Not Found - Ressource non trouvée            |
| 422  | Unprocessable Entity - Erreurs de validation |
| 500  | Internal Server Error - Erreur serveur       |

---

## Modèles de Données

### Utilisateur (User)

```json
{
    "id": 1,
    "lastname": "string",
    "firstname": "string",
    "phone_number": "string",
    "calling_code": "string",
    "email_verified_at": "timestamp|null",
    "created_at": "timestamp",
    "updated_at": "timestamp"
}
```

**Relations:**

-   `roles`: Relation many-to-many avec les rôles
-   `countryCallingCode`: Relation belongsTo avec les codes d'appel

### Champ (Field)

```json
{
    "id": 1,
    "name": "string",
    "location": "string",
    "user_id": 1,
    "created_at": "timestamp",
    "updated_at": "timestamp"
}
```

**Relations:**

-   `parcels`: Relation hasMany avec les parcelles

### Parcelle (Parcel)

```json
{
    "id": 1,
    "field_id": 1,
    "created_at": "timestamp",
    "updated_at": "timestamp"
}
```

**Relations:**

-   `field`: Relation belongsTo avec le champ

---

## Gestion des Erreurs

### Erreurs de Validation

Les erreurs de validation retournent un objet détaillé avec les champs en erreur :

```json
{
    "status": "error",
    "message": "The given data was invalid.",
    "errors": {
        "lastname": ["Le champ nom de famille est requis."],
        "phone_number": [
            "Le numéro de téléphone doit contenir au maximum 20 caractères."
        ]
    }
}
```

### Erreurs d'Authentification

```json
{
    "status": "error",
    "message": "Unauthenticated",
    "errors": null
}
```

### Erreurs Serveur

```json
{
    "status": "error",
    "message": "Une erreur interne s'est produite",
    "errors": "Message d'erreur détaillé"
}
```

---

## Notes de Développement

### Fonctionnalités Implémentées

-   ✅ Inscription des agriculteurs
-   ✅ Vérification OTP
-   ✅ Création de champs
-   ✅ Système de réponses standardisées
-   ✅ Validation des requêtes

### Fonctionnalités en Développement

-   🔄 Authentification JWT complète (login/logout)
-   🔄 CRUD complet pour les champs
-   🔄 CRUD complet pour les parcelles
-   🔄 Gestion des rôles utilisateurs
-   🔄 Endpoints de listing avec pagination

### Améliorations Suggérées

1. **Authentification**: Implémenter les méthodes login/logout dans UserController
2. **Pagination**: Ajouter la pagination pour les listes d'entités
3. **Filtrage**: Ajouter des paramètres de filtrage et de recherche
4. **Documentation**: Ajouter une documentation Swagger/OpenAPI
5. **Tests**: Implémenter des tests unitaires et d'intégration
6. **Middleware**: Ajouter des middlewares de validation et d'authentification
7. **Cache**: Implémenter un système de cache pour les requêtes fréquentes

---

## Exemples d'Utilisation

### Inscription et Vérification OTP

```bash
# 1. Inscription d'un agriculteur
curl -X POST http://localhost:8000/api/users/farmers/register \
  -H "Content-Type: application/json" \
  -d '{
    "lastname": "Martin",
    "firstname": "Pierre",
    "phone_number": "0123456789",
    "password": "motdepasse123",
    "password_confirmation": "motdepasse123",
    "calling_code": "+33"
  }'

# 2. Vérification OTP (remplacer {user_id} par l'ID retourné)
curl -X POST http://localhost:8000/api/users/{user_id}/verify-otp \
  -H "Content-Type: application/json" \
  -d '{
    "otp_code": "123456"
  }'
```

### Création d'un Champ

```bash
curl -X POST http://localhost:8000/api/fields \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {jwt_token}" \
  -d '{
    "name": "Champ Bio Nord",
    "location": "Normandie, France"
  }'
```

---

**Version de l'API**: 1.0  
**Dernière mise à jour**: 13 octobre 2025  
**Framework**: Laravel 11  
**Base de données**: Configurée via migrations Laravel
