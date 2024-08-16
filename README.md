[![Codacy Badge](https://app.codacy.com/project/badge/Grade/b2e151dc2c704172921d41d5faab1f3d)](https://app.codacy.com/gh/TonyWTillet/snow-tricks/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)

# CONTEXTE
Projet 7 de mon parcours Développeur d'application PHP/Symfony chez OpenClassrooms.
BileMo permet de fournir à toutes les plateformes qui le souhaitent l’accès a un catalogue de téléphones mobiles via une API (Application Programming Interface).
## Project summary
**BileMo** est une entreprise offrant toute une sélection de téléphones mobiles haut de gamme.

Vous êtes en charge du développement de la vitrine de téléphones mobiles de l’entreprise *BileMo*. Le business modèle de *BileMo* n’est pas de vendre directement ses produits sur le site web, mais de fournir à toutes les plateformes qui le souhaitent l’accès au catalogue via une API (Application Programming Interface). Il s’agit donc de vente exclusivement en B2B (business to business).

Il va falloir que vous exposiez un certain nombre d’API pour que les applications des autres plateformes web puissent effectuer des opérations.

## Project needs
Le premier client a enfin signé un contrat de partenariat avec BileMo ! C’est le branle-bas de combat pour répondre aux besoins de ce premier client qui va permettre de mettre en place l’ensemble des API et de les éprouver tout de suite.

Après une réunion dense avec le client, il a été identifié un certain nombre d’informations. Il doit être possible de :

- consulter la liste des produits BileMo ;
- consulter les détails d’un produit BileMo ;
- consulter la liste des utilisateurs inscrits liés à un client sur le site web ;
- consulter le détail d’un utilisateur inscrit lié à un client ;
- ajouter un nouvel utilisateur lié à un client ;
- supprimer un utilisateur ajouté par un client.

Seuls les clients référencés peuvent accéder aux API. Les clients de l’API doivent être authentifiés via OAuth ou JWT.

Vous avez le choix entre mettre en place un serveur OAuth et y faire appel (en utilisant le [FOSOAuthServerBundle](https://packagist.org/packages/friendsofsymfony/oauth-server-bundle)), et utiliser Facebook, Google ou LinkedIn. Si vous décidez d’utiliser JWT, il vous faudra [vérifier la validité du token](https://github.com/lexik/LexikJWTAuthenticationBundle) ; l’usage d’une librairie est autorisé.

## Deliverables
1. Un fichier au format TXT contenant **un lien vers un repository Github** contenant l’ensemble du projet :
    - Tout le code nécessaire (fichiers PHP/HTML/JS/CSS) ;
    - Un fichier README à la racine du dossier et contenant les instructions pour installer le projet ;
    - Un dossier contenant l’ensemble des diagrammes demandés (modèles de données, classes, séquentiels)
    - Les issues sur le repository GitHub que vous aurez créé
2. Un fichier au format TXT contenant un lien vers **la documentation technique de l’API** à destination des futurs utilisateurs.

# HOW INSTALL THIS PROJECT

## Template
- Demo : https://www.tailwindawesome.com/resources/stablo/demo
- Git : https://github.com/TonyWTillet/bilemo

## Required and technical environment
> Language => PHP 8.3.*

> Database => MySQL 5.7.25

> Web Server 

> Symfony 

> Composer 

> NodeJS 


## Step 1: clone the projet
    git clone https://github.com/TonyWTillet/bilemo.git

## Step 2: install composer
https://getcomposer.org/download/

## Step 3: install Makefile
    https://gnuwin32.sourceforge.net/packages/make.htm

## Step 4: config .env

## Step 5: install dependencies
    make init

## Step 6: install database
    make database-init

## Step 7: start server
    symfony server:start

## Step 10: default user
<table>
    <thead>
        <tr>
            <th>email</th>
            <th align="center">password</th>
            <th align="right">role</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>victoire.raymond@delorme.com</td>
            <td align="center">password</td>
            <td align="right">ROLE_USER</td>
        </tr>
    </tbody>
</table>

# UML DIAGRAMM
[Diagrammes UML](./diagrams_UML)
