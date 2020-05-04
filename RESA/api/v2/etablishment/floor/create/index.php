<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
DESCRIPTION : Ce script contient toutes les fonctions pour effectuer des READ sur la table 'user'
VERSION     : 1.0
*******************************************************************************/

// On inclu le connecteur de la base de données
include '../../../pdo.php';

/* 
* Création d'un étage
*   - n : le nom 
*   - idEtablishment : l'id de l'établissement
*/
function CreateFloor($n, $idEtablishment){
    static $query = null;

    if ($query == null) {
      $req = 'INSERT INTO `floor`(`idEtablishment`, `name`) VALUES (:i, :n)';
      $query = database()->prepare($req);
    }
  
    try {
        $query->bindParam(':i', $idEtablishment, PDO::PARAM_STR);
        $query->bindParam(':n', $n, PDO::PARAM_STR);
        $query->execute();
        $query->fetch();

        return true;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      return false;
    }
}

// etablishment/floor/create/?create&name=XXX&etablishment=XX
if(isset($_GET['create']) && isset($_GET['name']) && isset($_GET['etablishment'])){
    $etab = $_GET['etablishment'];
    $name = $_GET['name'];
    CreateFloor($name, $etab);
  }