# JOURNAL DE BORD

## 06.04.20
- Création du Github
- Création du Trello 
- Appel avec m. Garcia pour mise en route du travail
- Création du document word pour la documentation

## 07.04.20
- Création du planning 
- Mise à jour du trello en fonction du planning
- UML : Je pense qu'il va manquer quelques tables, mais je n'arrive pas à savoir lesquelles. C'est pourquoi je vais commencer le projet avec les tables actuelles et j'ajouterais les tables au fur et a mesure.

![Resa database v1](/Documentation/Images/resa_db_v1.png)

- Mise en place et branchement du raspberry PI sur mon réseau local
- Mon rapsberry aura une adressen statique sur mon réseau privé afin de pouvoir tester l'âpplication depuis differents appareils

## 08.04.20
- Mise en place des liens entre les tables de la base de données. La base de données n'est pas encore complète. Il manque principalement la structure pour le stockage des position et forme pour l'UI style "drag & drop".
- Création de l'api
- /!\ L'API va me prendre plus de temps que ce que je pensais, je vais donc changer le Trello afin de créer des sous-tâches pour le dévellopement de l'API.

### API V1
Pour le moment mon API est encore très basique. Je n'ai que accès au employés et aux login. Afin de pouvoir accéder à la base de données, voici les logins :
- username : resa_tech_es
- password : WhutMerYmZeR6EHb

### Login avec l'API
Afin de stocker les mot de passe en hashé dans la base de données j'utilise un système de hashage.
1. l'utilisateur entre son mot de passe
2. Le mot de passe est ensuite hashé en sha256
3. la clé (u7csu5qH6Cp9xWkrIgtGvTsOosnKvH9RhQOXteJtNhknqrEHcjp8dCGYuv02SBoHGsBRoN0zGeGeToULmWUDTb2HAgnSGntNJHmg) est aussi hashée en sha256
4. On conquataine les deux chaines 
5. La chaîne finale est encore une fois hashée en sha256
6. Le programme copmpare la chaîne hashée avec la chaîne stockée dans la base

## 09.04.20
- Création de la section READ pour la table client dans l'API

### API : READ Client
- **GetAllCLients** : récupère tous les clients de la base de données
    1. api/client/get/?all
- **GetClientById** : récupère un client en fonction de son **id**
    1. api/client/get/?id=[l'id que l'on cherche] (ex : get/?id=1)
- **GetClientByLastname** : récupère tous les clients avec le nom de famille passé en paramètre
    1. api/client/get/?lastname=[nom que l'on cherche] (ex : get/?lastname=Pala)
- **GetClientByFirstname** : récupère tous les clients avec le prénom passé en paramètre
    1. api/client/get/?firstname=[prénom que l'on cherche] (ex : get/?firstname=Ana)

## 14.04.20
- Mise à jour du Trello et réponses aux remarques de M. Garcia 
- Mise à jour du planning prévisionnel en incluant la mise en place de tests unitaires
- Modification de la base de données 
    - Ajout de la table "is_manager". Cette table permet à un gérant d'avoir plusieurs établissements
    - Ajout des tables de scores afin que les clients et les restaurateurs puissent ce mettre des notes anonymement
- Ajout de données dans la base de données afin de pouvoir faire les tests de l'API
- Les 'username' pour les employés sont générés automatiquement et sont unique à la base de données. Le login est composé d'uniquement 4 chiffres (je ne pense pas qu'un restaurant ai plus de 9999 employés...). Ce choix est fait pour permettre un login rapide en tapant uniquement les 4 chiffres du login et le mot de passe. A voir si je ne vais pas enlever le mot de passe lorsque l'on ce trouve sur le réseau du restaurant afin de pouvoir encore plus rapidement ce connecter lors du service.
- La table "is_manager" permet de stocker l'identifiant de l'employé qui est le manager. Ce manager peut avoir plusieurs restaurant et aussi être employé de ceux-ci ou d'autres (dont il n'est pas le manager).

### Comptes pour les test BDD

#### Employés
##### Administrateur
- username : 2008
- password : admin

##### Manager du Restaurant "Port Martignot"
- username : 3383
- password : manager

##### Employés du Restaurant
###### Olivier
- username : 5243
- password : e1

###### Mathilde
- username : 9902
- password : e2

#### Divers informations pour le restaurant
##### Floors (étages)
###### La térasse
- zone :
    1. Vue mer
    2. Vue village

- horaires : 
    1. Vue mer : 11:00 - 15:00
    2. Vue village : 11:00 - 15:00

###### La salle principale 
- zone :
    1. Piste de danse
    2. Coté bar
    3. Coté fenêtre

- horaires : 
    1. Piste de danse : 11:15 - 19:30
    2. Coté bar : 11:15 - 23:30
    3. Coté fenêtre : 11:15 - 23:30

## 15.04.20
- Discussion avec M. Garcia
    1. Ce focaliser sur la réservation interne 
    2. On est ouvert sur l'évolution de la visibilité exterieur 
    3. Fusionner les tables client et employé
    4. (Tâche future) Simuler de la charge 
- Modification de la base de données
    1. Ajout de la table images
    2. Ajout de la table de liasion entre menu et images + table de liaison entre etablissement et images
    3. Fusion de la table client et employé