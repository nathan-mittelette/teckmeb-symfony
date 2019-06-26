Teckmeb Lyon 1 Symfony Version
==============================

Bienvenue sur le projet Teckmeb visant à être un site de gestion de vie étudiantes modulable en adéquation avec les besoins utilisateurs

Comment l'installer ?
---------------------

Il vous faudra évidemment avoir phpmyadmin d'installer au préalable

Pour l'installer il faudra dans un premier temps cloner le repository git avec cette commande : 

* git clone `https://forge.univ-lyon1.fr/p1708947/info-lyon1-symfony.git`

Il faudra par la suite rentrer dans le dossier clôner et mettre à jour et installer les composants de symfony avec cette commande :

* php -d memory_limit=-1 composer.phar update

Durant cette commande des informations vous seront demandé comme le nom de la BD 

* database_host: 127.0.0.1
* database_port: null
* database_name: info-lyon1
* database_user: root
* database_password: null
* mailer_transport: smtp
* mailer_host: 127.0.0.1
* mailer_user: truc@truc.com
* mailer_password: 123
* secret: ThisTokenIsNotSoSecretChangeIt

Il faudra par le suite créer la base de donnée avec les commandes suivantes :

* php bin/console doctrine:database:create

* php bin/console doctrine:schema:update --force

Il faudra aller chercher le fichier initBD.sql dans le dossier web/assets/database/initBD.sql et l'importer dans la bd

Une fois que l'ajout a été fait il va falloir générer les fichiers JS et CSS du projet il vous faudra donc taper la commande :

* php bin/console assetic:dump

Maintenant que tout est bon vous pouvez lancer le serveur via la commande :

* php bin/console server:run

Le site est maintenant accessible a l'adresse [127.0.0.1:8000](http://127.0.0.1:8000)

Exemples d'utilisateurs
-----------------------

Etudiants :
  * login : p1723568
  * password : 123

Professeurs :
  * login : christophe.jaloux
  * password : 123

Secretariat :
  * login : secretariat
  * password : 123

Administrateur :
  * login : administrateur
  * password : 123

  
