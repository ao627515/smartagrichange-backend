# Documentation API SmartAgriChange Backend

## Vue d'ensemble

L'API SmartAgriChange Backend est une API RESTful construite avec Laravel 12 qui fournit des services pour la gestion agricole intelligente. Cette API permet la gestion des utilisateurs (agriculteurs), des champs, des parcelles et des services d'authentification avec vérification OTP.

### URL de base

```text
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

```text
Authorization: Bearer {votre_jwt_token}
```

**Routes protégées par authentification JWT** :

-   Toutes les routes sous `/api/auth/*` (sauf `/api/auth/login`)
-   Toutes les routes de gestion des champs `/api/fields/*`
-   Toutes les routes de gestion des parcelles `/api/parcels/*`

---

## Endpoints de l'API

### 1. Authentification

#### 1.1 Inscription d'un Agriculteur

**POST** `/api/users/farmers/register`

Crée un nouveau compte agriculteur dans le système et retourne un token JWT.

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

| Paramètre             | Type   | Requis    | Description                                     |
| --------------------- | ------ | --------- | ----------------------------------------------- |
| lastname              | string | Oui       | Nom de famille (max: 255 caractères)            |
| firstname             | string | Oui       | Prénom (max: 255 caractères)                    |
| phone_number          | string | Oui       | Numéro de téléphone unique (max: 20 caractères) |
| password              | string | Oui       | Mot de passe (min: 8 caractères)                |
| password_confirmation | string | Oui       | Confirmation du mot de passe                    |
| calling_code          | string | Optionnel | Code d'appel du pays (max: 10 caractères)       |

**Réponse de succès (201):**

```json
{
    "status": "success",
    "message": "Farmer registered successfully",
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "token_type": "bearer",
        "expires_in": 3600,
        "user": {
            "id": 1,
            "lastname": "Dupont",
            "firstname": "Jean",
            "phone_number": "123456789",
            "calling_code": "+33",
            "created_at": "2024-01-15T10:30:00.000000Z",
            "updated_at": "2024-01-15T10:30:00.000000Z"
        }
    }
}
```

**Réponses d'erreur:**

-   `422 Unprocessable Entity`: Erreurs de validation (numéro de téléphone déjà utilisé, etc.)
-   `500 Internal Server Error`: Erreur serveur

---

#### 1.2 Connexion Utilisateur

**POST** `/api/auth/login`

Authentifie un utilisateur avec son numéro de téléphone et mot de passe, retourne un token JWT.

**Corps de la requête:**

```json
{
    "phone_number": "123456789",
    "password": "motdepasse123"
}
```

**Paramètres:**

| Paramètre    | Type   | Requis | Description                          |
| ------------ | ------ | ------ | ------------------------------------ |
| phone_number | string | Oui    | Numéro de téléphone de l'utilisateur |
| password     | string | Oui    | Mot de passe (min: 8 caractères)     |

**Réponse de succès (200):**

```json
{
    "status": "success",
    "message": "Login successful",
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "token_type": "bearer",
        "expires_in": 3600,
        "user": {
            "id": 1,
            "lastname": "Dupont",
            "firstname": "Jean",
            "phone_number": "123456789",
            "created_at": "2024-01-15T10:30:00.000000Z"
        }
    }
}
```

**Réponses d'erreur:**

-   `401 Unauthorized`: Identifiants incorrects
-   `422 Unprocessable Entity`: Erreurs de validation
-   `500 Internal Server Error`: Erreur JWT

---

#### 1.3 Déconnexion Utilisateur

**POST** `/api/auth/logout`

Révoque le token JWT de l'utilisateur authentifié.

**En-têtes requis:**

```text
Authorization: Bearer {jwt_token}
```

**Réponse de succès (200):**

```json
{
    "status": "success",
    "message": "Logout successful",
    "data": null
}
```

**Réponses d'erreur:**

-   `401 Unauthorized`: Token JWT invalide ou manquant

---

#### 1.4 Actualiser le Token

**POST** `/api/auth/refresh`

Actualise le token JWT existant et retourne un nouveau token.

**En-têtes requis:**

```text
Authorization: Bearer {jwt_token}
```

**Réponse de succès (200):**

```json
{
    "status": "success",
    "message": "Token refreshed successfully",
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "token_type": "bearer",
        "expires_in": 3600
    }
}
```

**Réponses d'erreur:**

-   `401 Unauthorized`: Token JWT invalide
-   `500 Internal Server Error`: Erreur lors de l'actualisation

---

#### 1.5 Profil Utilisateur

**GET** `/api/auth/me`

Récupère les informations du profil de l'utilisateur authentifié.

**En-têtes requis:**

```text
Authorization: Bearer {jwt_token}
```

**Réponse de succès (200):**

```json
{
    "status": "success",
    "message": "User retrieved successfully",
    "data": {
        "id": 1,
        "lastname": "Dupont",
        "firstname": "Jean",
        "phone_number": "123456789",
        "calling_code": "+33",
        "email_verified_at": null,
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-15T10:30:00.000000Z"
    }
}
```

**Réponses d'erreur:**

-   `401 Unauthorized`: Token JWT invalide ou manquant

---

### 2. Gestion OTP (One-Time Password)

#### 2.1 Vérification OTP

**POST** `/api/users/{user}/verify-otp`

Vérifie le code OTP pour un utilisateur spécifique.

**Paramètres d'URL:**

| Paramètre | Type    | Description         |
| --------- | ------- | ------------------- |
| user      | integer | ID de l'utilisateur |

**Corps de la requête:**

```json
{
    "otp_code": "123456"
}
```

**Paramètres:**

| Paramètre | Type   | Requis | Description           |
| --------- | ------ | ------ | --------------------- |
| otp_code  | string | Oui    | Code OTP à 6 chiffres |

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

#### 2.2 Renvoyer un OTP

**POST** `/api/users/{user}/resend-otp`

Renvoie un nouveau code OTP à l'utilisateur spécifié.

**Paramètres d'URL:**

| Paramètre | Type    | Description         |
| --------- | ------- | ------------------- |
| user      | integer | ID de l'utilisateur |

**Réponse de succès (200):**

```json
{
    "status": "success",
    "message": "OTP resent successfully",
    "data": null
}
```

**Réponses d'erreur:**

-   `500 Internal Server Error`: Erreur lors de l'envoi de l'OTP

---

### 3. Gestion des Champs

#### 3.1 Lister les Champs

**GET** `/api/fields`

Récupère la liste de tous les champs de l'utilisateur authentifié, triés par date de création décroissante.

**En-têtes requis:**

```text
Authorization: Bearer {jwt_token}
```

**Réponse de succès (200):**

```json
{
    "status": "success",
    "message": "Fields retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Champ Principal",
            "location": "Bretagne, France",
            "user_id": 1,
            "created_at": "2024-01-15T10:30:00.000000Z",
            "updated_at": "2024-01-15T10:30:00.000000Z"
        }
    ]
}
```

**Réponses d'erreur:**

-   `401 Unauthorized`: Token JWT manquant ou invalide
-   `500 Internal Server Error`: Erreur serveur

---

#### 3.2 Créer un Champ

**POST** `/api/fields`

Crée un nouveau champ pour l'utilisateur authentifié.

**En-têtes requis:**

```text
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

| Paramètre | Type   | Requis | Description                                 |
| --------- | ------ | ------ | ------------------------------------------- |
| name      | string | Oui    | Nom du champ (max: 255 caractères)          |
| location  | string | Oui    | Localisation du champ (max: 255 caractères) |

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

**En-têtes requis:**

```text
Authorization: Bearer {jwt_token}
```

**Paramètres d'URL:**

| Paramètre | Type    | Description |
| --------- | ------- | ----------- |
| field     | integer | ID du champ |

**Réponse de succès (200):**

```json
{
    "status": "success",
    "message": "Field retrieved successfully",
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
-   `404 Not Found`: Champ non trouvé
-   `500 Internal Server Error`: Erreur serveur

---

#### 3.4 Modifier un Champ

**PUT/PATCH** `/api/fields/{field}`

Modifie un champ existant.

**En-têtes requis:**

```text
Authorization: Bearer {jwt_token}
Content-Type: application/json
```

**Paramètres d'URL:**

| Paramètre | Type    | Description |
| --------- | ------- | ----------- |
| field     | integer | ID du champ |

**Corps de la requête:**

```json
{
    "name": "Nouveau Nom du Champ",
    "location": "Nouvelle Localisation"
}
```

**Réponse de succès (200):**

```json
{
    "status": "success",
    "message": "Field updated successfully",
    "data": {
        "id": 1,
        "name": "Nouveau Nom du Champ",
        "location": "Nouvelle Localisation",
        "user_id": 1,
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-15T12:00:00.000000Z"
    }
}
```

**Réponses d'erreur:**

-   `401 Unauthorized`: Token JWT manquant ou invalide
-   `404 Not Found`: Champ non trouvé
-   `422 Unprocessable Entity`: Erreurs de validation
-   `500 Internal Server Error`: Erreur serveur

---

#### 3.5 Supprimer un Champ

**DELETE** `/api/fields/{field}`

Supprime un champ existant.

**En-têtes requis:**

```text
Authorization: Bearer {jwt_token}
```

**Paramètres d'URL:**

| Paramètre | Type    | Description |
| --------- | ------- | ----------- |
| field     | integer | ID du champ |

**Réponse de succès (200):**

```json
{
    "status": "success",
    "message": "Field deleted successfully",
    "data": null
}
```

**Réponses d'erreur:**

-   `401 Unauthorized`: Token JWT manquant ou invalide
-   `404 Not Found`: Champ non trouvé
-   `500 Internal Server Error`: Erreur serveur

---

#### 3.6 Récupérer les Parcelles d'un Champ

**GET** `/api/fields/{field}/parcels`

Récupère toutes les parcelles associées à un champ spécifique.

**En-têtes requis:**

```text
Authorization: Bearer {jwt_token}
```

**Paramètres d'URL:**

| Paramètre | Type    | Description |
| --------- | ------- | ----------- |
| field     | integer | ID du champ |

**Réponse de succès (200):**

```json
{
    "status": "success",
    "message": "Parcels retrieved successfully",
    "data": [
        {
            "id": 1,
            "field_id": 1,
            "created_at": "2024-01-15T10:30:00.000000Z",
            "updated_at": "2024-01-15T10:30:00.000000Z"
        }
    ]
}
```

**Réponses d'erreur:**

-   `401 Unauthorized`: Token JWT manquant ou invalide
-   `404 Not Found`: Champ non trouvé
-   `500 Internal Server Error`: Erreur serveur

---

### 4. Gestion des Parcelles

#### 4.1 Lister les Parcelles

**GET** `/api/parcels`

Récupère la liste de toutes les parcelles, triées par date de création décroissante.

**En-têtes requis:**

```text
Authorization: Bearer {jwt_token}
```

**Réponse de succès (200):**

```json
{
    "status": "success",
    "message": "Parcels retrieved successfully",
    "data": [
        {
            "id": 1,
            "field_id": 1,
            "created_at": "2024-01-15T10:30:00.000000Z",
            "updated_at": "2024-01-15T10:30:00.000000Z"
        }
    ]
}
```

**Réponses d'erreur:**

-   `401 Unauthorized`: Token JWT manquant ou invalide
-   `500 Internal Server Error`: Erreur serveur

---

#### 4.2 Créer une Parcelle

**POST** `/api/parcels`

Crée une nouvelle parcelle associée à un champ.

**En-têtes requis:**

```text
Authorization: Bearer {jwt_token}
Content-Type: application/json
```

**Corps de la requête:**

```json
{
    "field_id": 1
}
```

**Paramètres:**

| Paramètre | Type    | Requis | Description        |
| --------- | ------- | ------ | ------------------ |
| field_id  | integer | Oui    | ID du champ parent |

**Réponse de succès (201):**

```json
{
    "status": "success",
    "message": "Parcel created successfully",
    "data": {
        "id": 1,
        "field_id": 1,
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-15T10:30:00.000000Z"
    }
}
```

**Réponses d'erreur:**

-   `401 Unauthorized`: Token JWT manquant ou invalide
-   `422 Unprocessable Entity`: Erreurs de validation (field_id invalide)
-   `500 Internal Server Error`: Erreur serveur

---

#### 4.3 Afficher une Parcelle

**GET** `/api/parcels/{parcel}`

Récupère les détails d'une parcelle spécifique.

**En-têtes requis:**

```text
Authorization: Bearer {jwt_token}
```

**Paramètres d'URL:**

| Paramètre | Type    | Description       |
| --------- | ------- | ----------------- |
| parcel    | integer | ID de la parcelle |

**Réponse de succès (200):**

```json
{
    "status": "success",
    "message": "Parcel retrieved successfully",
    "data": {
        "id": 1,
        "field_id": 1,
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-15T10:30:00.000000Z"
    }
}
```

**Réponses d'erreur:**

-   `401 Unauthorized`: Token JWT manquant ou invalide
-   `404 Not Found`: Parcelle non trouvée
-   `500 Internal Server Error`: Erreur serveur

---

#### 4.4 Modifier une Parcelle

**PUT/PATCH** `/api/parcels/{parcel}`

Modifie une parcelle existante.

**En-têtes requis:**

```text
Authorization: Bearer {jwt_token}
Content-Type: application/json
```

**Paramètres d'URL:**

| Paramètre | Type    | Description       |
| --------- | ------- | ----------------- |
| parcel    | integer | ID de la parcelle |

**Corps de la requête:**

```json
{
    "field_id": 2
}
```

**Réponse de succès (200):**

```json
{
    "status": "success",
    "message": "Parcel updated successfully",
    "data": {
        "id": 1,
        "field_id": 2,
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-15T12:00:00.000000Z"
    }
}
```

**Réponses d'erreur:**

-   `401 Unauthorized`: Token JWT manquant ou invalide
-   `404 Not Found`: Parcelle non trouvée
-   `422 Unprocessable Entity`: Erreurs de validation
-   `500 Internal Server Error`: Erreur serveur

---

#### 4.5 Supprimer une Parcelle

**DELETE** `/api/parcels/{parcel}`

Supprime une parcelle existante.

**En-têtes requis:**

```text
Authorization: Bearer {jwt_token}
```

**Paramètres d'URL:**

| Paramètre | Type    | Description       |
| --------- | ------- | ----------------- |
| parcel    | integer | ID de la parcelle |

**Réponse de succès (200):**

```json
{
    "status": "success",
    "message": "Parcel deleted successfully",
    "data": null
}
```

**Réponses d'erreur:**

-   `401 Unauthorized`: Token JWT manquant ou invalide
-   `404 Not Found`: Parcelle non trouvée
-   `500 Internal Server Error`: Erreur serveur

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

### Token JWT

```json
{
    "access_token": "string",
    "token_type": "bearer",
    "expires_in": 3600,
    "user": {
        // Objet utilisateur
    }
}
```

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
    "message": "Authentication failed",
    "errors": "Invalid credentials"
}
```

### Erreurs JWT

```json
{
    "status": "error",
    "message": "JWT error",
    "errors": "Token has expired"
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

## Exemples d'Utilisation

### Workflow d'Inscription et Authentification

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

# Connexion (si l'utilisateur existe déjà)
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "phone_number": "0123456789",
    "password": "motdepasse123"
  }'

# 3. Récupération du profil
curl -X GET http://localhost:8000/api/auth/me \
  -H "Authorization: Bearer {jwt_token}"

# 4. Actualisation du token
curl -X POST http://localhost:8000/api/auth/refresh \
  -H "Authorization: Bearer {jwt_token}"

# 5. Déconnexion
curl -X POST http://localhost:8000/api/auth/logout \
  -H "Authorization: Bearer {jwt_token}"
```

### Vérification et Renvoi OTP

```bash
# Vérification OTP (remplacer {user_id} par l'ID retourné lors de l'inscription)
curl -X POST http://localhost:8000/api/users/{user_id}/verify-otp \
  -H "Content-Type: application/json" \
  -d '{
    "otp_code": "123456"
  }'

# Renvoyer un OTP
curl -X POST http://localhost:8000/api/users/{user_id}/resend-otp \
  -H "Content-Type: application/json"
```

### Gestion Complète des Champs

```bash
# 1. Créer un champ
curl -X POST http://localhost:8000/api/fields \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {jwt_token}" \
  -d '{
    "name": "Champ Bio Nord",
    "location": "Normandie, France"
  }'

# 2. Lister tous les champs
curl -X GET http://localhost:8000/api/fields \
  -H "Authorization: Bearer {jwt_token}"

# 3. Afficher un champ spécifique
curl -X GET http://localhost:8000/api/fields/1 \
  -H "Authorization: Bearer {jwt_token}"

# 4. Mettre à jour un champ
curl -X PUT http://localhost:8000/api/fields/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {jwt_token}" \
  -d '{
    "name": "Champ Bio Nord Modifié",
    "location": "Normandie, France - Zone Est"
  }'

# 5. Supprimer un champ
curl -X DELETE http://localhost:8000/api/fields/1 \
  -H "Authorization: Bearer {jwt_token}"

# 6. Récupérer les parcelles d'un champ
curl -X GET http://localhost:8000/api/fields/1/parcels \
  -H "Authorization: Bearer {jwt_token}"
```

### Gestion Complète des Parcelles

```bash
# 1. Créer une parcelle
curl -X POST http://localhost:8000/api/parcels \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {jwt_token}" \
  -d '{
    "field_id": 1
  }'

# 2. Lister toutes les parcelles
curl -X GET http://localhost:8000/api/parcels \
  -H "Authorization: Bearer {jwt_token}"

# 3. Afficher une parcelle spécifique
curl -X GET http://localhost:8000/api/parcels/1 \
  -H "Authorization: Bearer {jwt_token}"

# 4. Mettre à jour une parcelle
curl -X PUT http://localhost:8000/api/parcels/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {jwt_token}" \
  -d '{
    "field_id": 2
  }'

# 5. Supprimer une parcelle
curl -X DELETE http://localhost:8000/api/parcels/1 \
  -H "Authorization: Bearer {jwt_token}"
```

### Vérification OTP

```bash
# Vérification OTP (remplacer {user_id} par l'ID retourné lors de l'inscription)
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

## Notes de Développement

### Statut des Contrôleurs

| Contrôleur                     | Statut     | Fonctionnalités implémentées                    |
| ------------------------------ | ---------- | ----------------------------------------------- |
| `AuthController`               | ✅ Complet | login, logout, refresh, me                      |
| `RegisterController`           | ✅ Complet | registerFarmer                                  |
| `UserOtpController`            | ✅ Complet | verifyOtp, resendOtp                            |
| `FieldController`              | ✅ Complet | index, store, show, update, destroy, getParcels |
| `ParcelController`             | ✅ Complet | index, store, show, update, destroy             |
| `CountryCallingCodeController` | ❌ Vide    | Aucune méthode implémentée                      |
| `RoleController`               | ❌ Vide    | Aucune méthode implémentée                      |
| `UserController`               | 🔄 Partiel | Méthodes définies mais non implémentées         |

### Fonctionnalités Implémentées

-   ✅ Inscription des agriculteurs avec JWT
-   ✅ Authentification complète (login/logout/refresh/me)
-   ✅ Vérification et renvoi OTP
-   ✅ CRUD complet pour les champs
-   ✅ CRUD complet pour les parcelles
-   ✅ Récupération des parcelles d'un champ
-   ✅ Système de réponses standardisées
-   ✅ Validation des requêtes avec Form Requests
-   ✅ Middlewares d'authentification JWT sur routes protégées

### Fonctionnalités en Développement

-   🔄 Gestion des rôles utilisateurs
-   🔄 Endpoints de listing avec pagination
-   🔄 Gestion des codes d'appel de pays
-   🔄 Filtrage et recherche avancés

### Routes Disponibles (selon routes/api.php)

**Routes d'inscription et OTP**:

-   `POST /api/users/farmers/register` → RegisterController@registerFarmer ✅
-   `POST /api/users/{user}/verify-otp` → UserOtpController@verifyOtp ✅
-   `POST /api/users/{user}/resend-otp` → UserOtpController@resendOtp ✅

**Routes d'authentification**:

-   `POST /api/auth/login` → AuthController@login ✅
-   `POST /api/auth/logout` → AuthController@logout ✅ (protégée)
-   `POST /api/auth/refresh` → AuthController@refresh ✅ (protégée)
-   `GET /api/auth/me` → AuthController@me ✅ (protégée)

**Routes de gestion des champs** (toutes protégées par auth:api):

-   `GET /api/fields` → FieldController@index ✅
-   `POST /api/fields` → FieldController@store ✅
-   `GET /api/fields/{field}` → FieldController@show ✅
-   `PUT /api/fields/{field}` → FieldController@update ✅
-   `DELETE /api/fields/{field}` → FieldController@destroy ✅
-   `GET /api/fields/{field}/parcels` → FieldController@getParcels ✅

**Routes de gestion des parcelles** (toutes protégées par auth:api):

-   `GET /api/parcels` → ParcelController@index ✅
-   `POST /api/parcels` → ParcelController@store ✅
-   `GET /api/parcels/{parcel}` → ParcelController@show ✅
-   `PUT /api/parcels/{parcel}` → ParcelController@update ✅
-   `DELETE /api/parcels/{parcel}` → ParcelController@destroy ✅

### Améliorations Suggérées

1. **Pagination**: Ajouter la pagination pour les listes d'entités (fields, parcels)
2. **Filtrage et tri**: Ajouter des paramètres de filtrage et de tri personnalisés
3. **Documentation Swagger**: Générer une documentation Swagger/OpenAPI interactive
4. **Tests**: Implémenter des tests unitaires et d'intégration complets
5. **Cache**: Implémenter un système de cache Redis pour les requêtes fréquentes
6. **Rate Limiting**: Ajouter une limitation du taux de requêtes par IP/utilisateur
7. **Logs structurés**: Améliorer le système de logging avec des logs structurés
8. **Notifications**: Implémenter un système de notifications temps réel
9. **Permissions granulaires**: Ajouter un système de permissions basé sur les rôles
10. **Endpoints statistiques**: Créer des endpoints pour les statistiques et rapports

### Sécurité

-   ✅ Authentification JWT
-   ✅ Validation des données d'entrée
-   ✅ Hachage des mots de passe
-   ✅ Unicité des numéros de téléphone
-   🔄 Rate limiting (à implémenter)
-   🔄 CORS policy (à configurer)

### Problèmes Connus et Limitations

1. **Absence de pagination**: Les endpoints de listing ne supportent pas encore la pagination, ce qui peut causer des problèmes de performance avec de grandes quantités de données.

2. **Gestion des rôles limitée**: Bien que des modèles de rôles existent, aucun endpoint n'est disponible pour leur gestion et les permissions ne sont pas implémentées.

3. **Codes d'appel de pays**: Le `CountryCallingCodeController` existe mais n'a aucune méthode implémentée.

4. **Validation des relations**: La validation des relations entre champs et parcelles pourrait être renforcée (vérifier que l'utilisateur possède le champ lors de la création d'une parcelle).

5. **Soft deletes**: Les suppressions sont définitives, pas de soft delete implémenté.

6. **Gestion d'erreurs**: La gestion d'erreurs pourrait être améliorée avec des codes d'erreur personnalisés et des messages plus descriptifs.

### Notes de Déploiement

-   Assurez-vous que les variables d'environnement JWT sont correctement configurées
-   Exécutez `php artisan migrate` pour créer les tables de base de données
-   Configurez les queues si vous utilisez les événements et listeners
-   Vérifiez la configuration des CORS selon vos besoins frontend

### Architecture et Technologies

**Backend Framework**: Laravel 12.x

-   **Authentification**: JWT (tymon/jwt-auth v2.2)
-   **Validation**: Laravel Form Requests avec traits personnalisés
-   **Architecture**: Repository Pattern + Service Layer
-   **Ressources**: API Resources pour la transformation des données
-   **Events & Listeners**: Système d'événements pour les actions utilisateur

**Dépendances principales**:

-   `laravel/framework: ^12.0`
-   `tymon/jwt-auth: ^2.2`
-   `spatie/laravel-data: ^4.17`
-   `laravel/sanctum: ^4.0`

**Structure du projet**:

-   `app/Services/`: Logique métier
-   `app/Repositories/`: Accès aux données
-   `app/Http/Resources/`: Transformation des réponses API
-   `app/Http/Requests/`: Validation des requêtes
-   `app/Events/` & `app/Listeners/`: Gestion des événements
-   `app/DTO/`: Data Transfer Objects

---

**Version de l'API**: 1.0  
**Dernière mise à jour**: 15 octobre 2025  
**Framework**: Laravel 12  
**Base de données**: Configurée via migrations Laravel  
**Authentification**: JWT (tymon/jwt-auth)
