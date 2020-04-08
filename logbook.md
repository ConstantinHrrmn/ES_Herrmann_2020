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
