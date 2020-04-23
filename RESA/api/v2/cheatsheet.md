# Cheat sheet API RESA V2
Ce fichier est la pour vous aider à utiliser l'API de RESA développée par Constantin Herrmann dans le cadre du travail de diplôme Technicien ES au CFPT-I (2020).

---
#### IMPORTANT : TOUTES LES DONNEES SONT RETOURNES EN JSON
---

## User
Lien : ```/api/v2/user/get/```

1. **Récupérer les informations d'un user avec ses permissions**
   - Paramètres : 
     - ```id``` : l'id de l'utilisateur recherché
   - Lien avec paramètres : ```/api/v2/user/get/?id=[id de l'utilisateur]```
   - Retour : 
     - Un tableau avec les champs :
       - ```id``` : l'id de l'utilisateur
       - ```first_name``` : le prénom de l'utilisateur
       - ```last_name``` : le nom de famille de l'utilisateur
       - ```phone``` : le numéro de téléphone de l'utilisateur
       - ```email``` : l'email de l'utilisateur
       - ```username``` : le code à 4 chiffre d'identification de l'utilisateur
       - ```permissions``` : un tableau avec toutes ses permissions. Chaque permission contient :
           - ```etablishment_name``` : le nom de l'établissement (si il y en à un, sinon "-")
           - ```permission_name``` : le nom de la permission (ex: manager)
  
2. **Récupérer les informations de base d'un user**
   - Paramètres : 
     - ```user``` : (il n'y à pas besoin de valeur)
     - ```id``` : l'id de l'utilisateur recherché
   - Lien avec paramètres : ```/api/v2/user/get/?user&id=[id de l'utilisateur]```
   - Retour : 
     - Un tableau avec les champs :
       - ```id``` : l'id de l'utilisateur
       - ```first_name``` : le prénom de l'utilisateur
       - ```last_name``` : le nom de famille de l'utilisateur
       - ```phone``` : le numéro de téléphone de l'utilisateur
       - ```email``` : l'email de l'utilisateur
       - ```username``` : le code à 4 chiffre d'identification de l'utilisateur

3. **Récupérer tous les utilisateurs avec une certaine permission**
   - Paramètres : 
     - ```byPermission``` : l'id de la permission recherchée
   - Lien avec paramètres : ```/api/v2/user/get/?byPermission=[id de la permission]```
   - Retour : 
     - Un tableau de users, ou chaque user possède les champs :
       - ```first_name``` : le prénom de l'utilisateur
       - ```last_name``` : le nom de famille de l'utilisateur
       - ```phone``` : le numéro de téléphone de l'utilisateur
       - ```email``` : l'email de l'utilisateur
       - ```username``` : le code à 4 chiffre d'identification de l'utilisateur

4. **Récupérer toutes les permissions d'un utilisateur**
   - Paramètres : 
     - ```permissions``` : (il n'y à pas besoin de valeur)
     - ```id``` : l'id de l'utilisateur recherché
   - Lien avec paramètres : ```/api/v2/user/get/?permissions&id=[id de l'utilisateur]```
   - Retour : 
     - Un tableau de permissions, ou chaque permissions possède les champs :
       - ```etablishment_name``` : le nom de l'établissement (si il y en à un, sinon "-")
       - ```permission_name``` : le nom de la permission (ex: manager)

5. **Récupérer tous les utilisateurs**
   - Lien avec paramètres : ```/api/v2/user/get/```
   - Retour : 
     - Un tableau de users, ou chaque user possède les champs :
       - ```id``` : l'id de l'utilisateur
       - ```first_name``` : le prénom de l'utilisateur
       - ```last_name``` : le nom de famille de l'utilisateur
       - ```phone``` : le numéro de téléphone de l'utilisateur
       - ```email``` : l'email de l'utilisateur
       - ```username``` : le code à 4 chiffre d'identification de l'utilisateur
  
6. **Login d'un utilisateur**
   - Paramètres : 
     - ```login``` : (il n'y à pas besoin de valeur)
     - ```username``` : l'identifiant à 4 chiffres de l'utilisateur
     - ```password``` : le mot de passe hashé en sha256
   - Lien avec paramètres : ```/api/v2/user/get/?login&username=[identifiant 4 chiffres]&password=[mot de passe hashé (sha256)]```
   - Retour : 
       - Un tableau avec les champs :
       - ```id``` : l'id de l'utilisateur
       - ```first_name``` : le prénom de l'utilisateur
       - ```last_name``` : le nom de famille de l'utilisateur
       - ```phone``` : le numéro de téléphone de l'utilisateur
       - ```email``` : l'email de l'utilisateur
