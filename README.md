# Installation du Projet #

Dans cette section sera décris la procédure d'installation du projet.

## Prérequis ##

Avant d'installer le projet, plusieurs éléments techniques sont nécessaires.

* Serveur Web Apache
* PHP5
* MySQL
* IDE possédant un plugin de versionning Git (Bitbucket)

## Installation ##

* Ajouter le lien du projet BitBucket dans votre IDE et faite un Pull de la dernière version :

```
#!console

git clone https://AymericBltl@bitbucket.org/ESNLille/esn-lille-administration.git
clic droit sur esn-lille-administration -> Git -> Remote -> Pull..
```

* Télécharger le composer.phar et ajouter le à votre IDE

```
#!console

curl -sS https://getcomposer.org/installer | php
```

* Une fois le projet visible dans votre IDE, effectuer l'action suivante :

```
#!console

clic-droit sur esn-lille-administration -> Composer -> Install (Dev)
```

* Le projet est maintenant en totalité dans votre IDE, il faut maintenant générer la base de donnée avec les commandes suivantes dans le répertoire de votre projet :

```
#!console

php app/console doctrine:database:create
php app/console doctrine:schema:update --force
```

* La dernière étape est de lancer le serveur Symfony 2 avec la commande :

```
#!console

php app/console server:run
```

* Le projet est maintenant accessible à l'adresse : http://localhost:8000/login
