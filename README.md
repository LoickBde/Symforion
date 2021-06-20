# Symforion
WebAurion 2.0 avec Symfony

## Installation

Creér un .env.local à partir du .env existant et remplacer la ligne ci-dessous par vos informations de bdd :

```bash
DATABASE_URL="postgresql://<user>:<password>@127.0.0.1:5432/<db_name>?serverVersion=12.6&charset=utf8"
```

Ensuite exectuter la commande :

```bash
composer deploy
php bin/console doctrine:fixtures:load;
```

Ou

```bash
composer install;
composer update;
php bin/console doctrine:database:create;
php bin/console doctrine:migration:diff;
php bin/console doctrine:migration:migrate;
php bin/console doctrine:fixtures:load;
```

## Fonctionnalités : 
* Saisie de notes du côté prof
* Visualisation des notes côté élève
* Génération automatique du bulletin en PDF
* Alerte (mail, ou autre...) des élèves à chaque nouvelles notes
* Alerte du professeur quand date limite de rendu
* Enregistrement des élèves/profs/promos par un admin
