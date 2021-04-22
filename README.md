# MatchMaker

Projet démo Symfony de rencontre e-sportives - OpenClassRoom POO PHP

![GIF démonstration MatchMaker](MatchMaker.gif)

## Installer le projet

### PHP

Assurez-vous d'avoir PHP installé dans sa version 8 :)

### Composer

Assurez-vous d'avoir Composer installé dans sa version 2 :)  
**Obtenir Composer :** getcomposer.org

### Yarn

Assurez-vous d'avoir npm et Yarn d'installé dans leur dernière version :)  
**Obtenir npm:** https://www.npmjs.com/package/npm  
**Obtenir Yarn:** https://yarnpkg.com/getting-started/install

### Configurer l'application

Assurez-vous que la configuration de la base de données soit correcte dans le fichier `.env` à la racine du projet aux lignes 25, 26 et 27.

### Installer les composants

Exécutez les commandes suivantes :

Installation des dépendances PHP :
```shell
$ composer install
$ bin/console doctrine:database:create
$ bin/console doctrine:schema:create
```

Installation des JavaScript :
```shell
$ yarn install
$ yarn encore dev
```

Démarrer le serveur local :
```shell
$ symfony serve
```

Rendez-vous sur la page https://127.0.0.1:8000 :)

Créer les rencontres pour les joueurs en attente :
```shell
$ bin/console app:encounters:create
```
    
Vous pouvez utiliser `systemd-timer` pour exécuter cette commande de manière régulière ;)

## Problèmes connus

### Liste à vérifier en cas d'erreurs

- Vérifiez que vous n'avez pas déjà un serveur sur les ports 8000, 8001, etc.
- Vérifiez que PHP est installé correctement et accessible en ligne de commande
- Vérifiez que PHP est en version 8.0.3 minimum
- Vérifiez que le module PHP PDO est activé
- Vérifiez que le module PHP Curl est activé
- vérifiez que votre base de données est accessible

## Envie d'améliorer ce projet ?

Si vous n'avez pas encore appris à manipuler le framework Symfony,  
Il existe un cours sur OpenClassRoom :) 

Des idées pour pratiquer ?
- Vous pouvez utiliser turbo + mercure pour remplacer les rechargements automatiques de page.
- Vous pouvez créer un système multi lobby.
- Vous pouvez créer une API REST pour qu'un jeu externe puisse récupérer les parties en cours avec les joueurs associés, et soumettre les résultats de la partie.
- Vous pouvez améliorer authentification pour proposer de se connecter avec son compte google/github/fb/twitter.
- ...
