<img src='./assets/images/logo_car_title.png' width="80">

## Projet Garage V. Parrot Index

- [Projet Garage V. Parrot Index](#projet-garage-v-parrot-index)
- [Projet Garage Parrot](#projet-garage-parrot)
- [Le client](#le-client)
- [Objectif du projet](#objectif-du-projet)
- [Les outils pour le projet](#les-outils-pour-le-projet)
- [LE SITE GARAGE V. PARROT](#le-site-garage-v-parrot)
- [Pour travailler en local](#pour-travailler-en-local)
- [Les diagrammes](#les-diagrammes)
- [Se connecter](#se-connecter) - [\*\* Attention, pour question de securité, les codes d'accès au site internet garage v. parrot ne sont pas le même que dans le fichier gparrot.sql. Les codes d'accès seront disponible seulement dans le fichier officiel du projet pour Studi.](#-attention-pour-question-de-securité-les-codes-daccès-au-site-internet-garage-v-parrot-ne-sont-pas-le-même-que-dans-le-fichier-gparrotsql-les-codes-daccès-seront-disponible-seulement-dans-le-fichier-officiel-du-projet-pour-studi)
- [Les liens du projet](#les-liens-du-projet)
- [Les liens perso](#les-liens-perso)

## Projet Garage Parrot

Le Projet Garage Parrot (PEP) c'est un page internet d'une garage fictif développé comme projet d’études du cours Graduate Fullstack de la formation Studi. La page est totalement dynamique. Dans la partie connexion, l'administrateur du site peut ajouter, modifier ou supprimer les informations du site.

## Le client

Vincent Parrot a 15 années d'expérience dans le marché de la réparation automobile. Il a décidé d'ouvrir son propre garage à Toulouse en 2021. Depuis 2 ans, il propose un large gamme de services: réparation de la carrosserie et la mécanique des voitures ainsi que leur entretien régulier. En plus de ses services, il met en vente des véhicules d'occasion afin d'agrandir son chiffre d'affaires. Il considère son atelier comme un véritable lieu de confiance pour ses clients. Alors il veut que son garage soit visible sur internet et se faire une place parmi les concurrents.

## Objectif du projet

Créer une application web vitrine pour le Garage V. Parrot en mettant en avant la qualité des services délivrés par son garage.

## Les outils pour le projet

1. **SERVEUR**

- Hostinger
- PHP 8.2.4
- Extension PHP: PDO
- MariaDB 10.4.28
  <br>

2. **FRONT**

- HTML 5
- CSS 3
- JavaScript
- Bootstrap 4.3.1
- jQuery 3.3.1
- jQuery UI 1.13.2
  <br>

3. **BACK**

- PHP 8.2.4 sous PDO
- MYSQL

  <hr>

## LE SITE GARAGE V. PARROT

https://garageparrot.net/

  <hr>

## Pour travailler en local

1.  <u>Cloner le projet</u>
    <br>
2.  <u>Communiquer avec le backend</u>
    Pour travailler avec la base de donnée (bdd), vous devez faire un petit configuration dans le fichier configGarage.php dans le dossier lib.
    <br>

    - changer le nom du fichier configGarage.php par config.php
    - changer **lemotutilisateur** pour votre mot d'utilisateur de la bdd si vous avez.
    - changer **votremotdepasse** si vous avez un pour la bdd.
    - changer **votreemail**. (en local il n'envoie pas des e-mails)
      <br>

          define("_DOMAIN_", "localhost");
          define("_GARAGE_IMAGES_FOLDER_", '/uploads/images/');
          define("_ASSETS_IMAGES_FOLDER_", '/assets/images/');
          define("_ADMIN_ITEM_PER_PAGE_",5);
          define("_DB_NAME_",'garageparrot');
          define("_DB_USER_",'lemotutilisateur');
          define("_DB_PASSWORD_",'votremotdepasse');
          define("_APP_EMAIL_",'votreemail');

3.  Dans xampp, wamp ou mamp activez Apache et Mysql.
4.  Importer dans phpAdmin le fichier gparrot.sql
5.  Pour lancer votre projet en local, ecrivez dans le terminal de votre IDE:

    - php -S localhost:3000

6.  Cliquez sur le lien localhost:3000 pour ouvrir le projet dans votre navigateur ou ecrivez localhost:3000 dans votre navigateur.

<hr>

## Les diagrammes

Si vous avez VSCode comme IDE, vous pouvez téléchargé l'extension **Draw.io integration** et voir les fichiers dans les dossiers diagrammes du projet. Dans le cas de n'est pas avoir cette extension, vous pouvez aller sur le site https://app.diagrams.net/ et ouvrir les fichiers .drawio

<hr>

## Se connecter

**Utilisateurs concernés:** <u>Administrateur</u> (Vincent Parrot) et <u>employés du garage</u> . Seulement ces deux on le droit de se connecter sur le site.

1- **Vincent Parrot**
Vincent comme cheffe de l'entreprise, gère absolument tous les informations du site web (services, voitures, employés, avis client et les horaires du garage). Il peut ajouter, modifier ou supprimer des informations du garage.

2- **Les employés**
Les employés du garage on aussi accès à la connexion du site, mais seulement les voitures et les avis des client. Ils peuvent ajouter, modifier ou même supprimer des voitures ou des avis client.

<hr>

##### \*\* Attention, pour question de securité, les codes d'accès au site internet garage v. parrot ne sont pas le même que dans le fichier gparrot.sql. Les codes d'accès seront disponible seulement dans le fichier officiel du projet pour Studi.

<hr>

## Les liens du projet

- [Garage V. Parrot - Mockup - Mobile](https://www.figma.com/file/QtBWhE3LKxJgYLePTYG9k4/Garage-Vincent-Parrot---MOCKUPS?type=design&node-id=0-1&mode=design&t=nY2uAAb2qvCw4MwX-0)
- [Garage V. Parrot - Mockup - Desktop](https://www.figma.com/file/QtBWhE3LKxJgYLePTYG9k4/Garage-Vincent-Parrot---MOCKUPS?type=design&node-id=12-2&mode=design&t=nY2uAAb2qvCw4MwX-0)
- [Garage V. Parrot - Trello](https://trello.com/b/fM2qOOkH/garage-vicent-parrot)
- [Le site Garage V. Parrot](https://garageparrot.net/)

<hr>

## Les liens perso

- [Portfolio](https://marcosmene.github.io/marcosmeneghetti_portfolio/)
- [LinkedIn](https://www.linkedin.com/in/3dmarcosmeneghetti/)
- [Github](https://github.com/MarcosMene)
