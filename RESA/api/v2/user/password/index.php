<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
DESCRIPTION : Ce script contient toutes les fonctions pour effectuer des READ sur la table 'user'
VERSION     : 1.0
*******************************************************************************/

/*
* Génère un mot de passé hashé avec une clé
* Params :
*   - $password : Le mot de passe hashé en sha256 que l'on souhaite sécurisé
*   - $key      : Une clé pour hashé
*/
function GeneratePassword($password, $key){
    $pass = hash('sha256', hash('sha256', $key).$password);
    return $pass;
}
