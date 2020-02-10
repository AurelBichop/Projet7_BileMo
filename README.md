# Projet7_BileMo
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/426dd56dd404481080a51e926abe35d6)](https://app.codacy.com/manual/AurelBichop/Projet7_BileMo?utm_source=github.com&utm_medium=referral&utm_content=AurelBichop/Projet7_BileMo&utm_campaign=Badge_Grade_Settings)

Bichotte Aurélien

Exemple d'une application web fournissant des API. Ce projet a été créé dans l'intérêt de se former au développement en php avec le framework Symfony, il fait parti du projet 7 de la formation Développeur d'application - PHP / Symfony d'openclassroom. https://openclassrooms.com/fr/paths/59-developpeur-dapplication-php-symfony

Le projet est actuellement en phase de test.

###Installation de l'application ###

Installer tous les fichiers sur le serveur en utilisant la commande :

# git clone https://github.com/AurelBichop/Projet7_BileMo.git

### Configuration de l'application ###
Renseigner la base de données dans le fichier .env

## Pour l'authentification avec jwt ##
Creer le repertoire jwt dans /config.

Créer la clef privé avec la commande
# openssl genrsa -out config/jwt/private.pem -aes256 4096

Renseigner le JWT_PASSPHRASE(que vous avez fourni au moment de la génération de la clef privé) dans le .env 

Créer la clef public avec la commande 
# openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem


### Mise en place des migrations###
php bin/console d:m:m

### Mise en place des fixtures ###
php bin/console d:f:l

### Pour un hébergement avec OVH ###
Ajouter un .htaccess dans public/

===================================================

SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1

RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php [QSA,L]

==================================================

Technologie utilisée : Symfony 5, MYSQL v.5.6 ou MariaDB-10.4.6, langage PHP 7.2
