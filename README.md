## Installation

Cloner le repository
```bash
git clone git@github.com:juliadebray/geeko-api.git
```

Se rendre dans le dossier cloné
```bash
cd geeko-api
```

Créer le container Docker
```bash
docker-compose up --build -d
```

Aller dans l'image Docker
```bash
docker exec -it geeko_api bash
```

Installer les dépendances du projet
```bash
composer install
```

Générer une keypair pour les JWT
```bash
php bin/console lexik:jwt:generate-keypair
```
Créer la base de données
```bash
php bin/console doctrine:database:create
```
Créer les tables
```bash
php bin/console doctrine:migrations:migrate
```
Charger les fixtures
```bash
php bin/console doctrine:fixtures:load
```
Certain endpoints de l'API sont sécurisés.
Pour y accéder, vous aurez besoin d'un compte
administrateur ou utilisateur :

| login                | password   |
|----------------------|------------|
| admin@example.com    | Pa$$w0rd   |
| customer@example.com | Pa$$w0rd   |

Pour vous autentifier sur API Platform :
- Générer un JWT sur le endpoint `api/login_check`
- Cliquez sur "Authorize" (en haut à droite), puis coller le JWT `Bearer <JWT>`

Voici les différentes URL disponibles:
- API: http://localhost:8080/api
- PMA: http://localhost:8081
