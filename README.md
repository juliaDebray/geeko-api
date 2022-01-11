## Installation

Cloner le repository
```bash
git clone git@github.com:juliadebray/geeko-api.git
```

Créer le container Docker
```bash
docker-compose up --build -d
```

Aller dans l'image Docker
```bash
docker exec -it geeko_api bash
```

Aller dans le dossier app et installer les dépendances du projet
```bash
cd app && composer install
```

Générer une keypair pour les JWT
```bash
php bin/console lexik:jwt:generate-keypair
```

Voici les différentes URL disponibles:
- API: http://localhost:8080/api
- PMA: http://localhost:8081
