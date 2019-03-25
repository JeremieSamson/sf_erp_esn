# ERP - ESN Lille

[![Build Status](https://travis-ci.org/JeremieSamson/sf_erp_esn.svg?branch=master)](https://travis-ci.org/JeremieSamson/sf_erp_esn)

## Installation

### Installation en local

Récupérez le projet depuis github :

```shell
git clone git@github.com:ylly/sf_erp_esn/.git
```
Créez les fichiers de configuration, puis éditez-les avec vos propres paramètres :

```shell
cp app/config/parameters.yml.dist app/config/parameters.yml
```

Installez [composer](https://getcomposer.org) :

```shell
curl -sS https://getcomposer.org/installer | php
```

Mettez à jour les librairies avec composer :

```shell
php composer.phar install
```

Vous devez ensuite mettre à jours la base de données :

```shell
php app/console doctrine:migrations:migrate
```

Configurez les permissions des répertoires du projet. Si vous êtes sur une machine Mac :

```shell
HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
sudo chmod +a "$HTTPDUSER allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs 
sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs 
```

Sinon, il est recommandé d'utiliser les ACL comme suit :

```shell
HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwXapp/cache app/logs
```
