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
include '../../../../pdo.php';

/* 
* Création d'une zone
*   - $n : le nom 
*/
function CreateZone($n){
    static $query = null;

    if ($query == null) {
      $req = 'INSERT INTO `zone`(`name`) VALUES (:n)';
      $query = database()->prepare($req);
    }
  
    try {
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

/* 
* Lien entre une zone et un étage
*   - idZone : id de la zone à lier
*   - idFloor : id de l'étage à lier
*/
function SetZoneToFloor($idZone, $idFloor){
    static $query = null;

    if ($query == null) {
      $req = 'INSERT INTO `has_zone`(`idFloor`, `idZone`) VALUES (:f, :z)';
      $query = database()->prepare($req);
    }
  
    try {
        $query->bindParam(':f', $idFloor, PDO::PARAM_STR);
        $query->bindParam(':z', $idZone, PDO::PARAM_STR);
        $query->execute();
        $query->fetch();

        return true;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      return false;
    }
    
}


// etablishment/floor/zone/create/?create&name=XXX
if(isset($_GET['create']) && isset($_GET['name'])){
  $zonename = $_GET['name'];
  CreateZone($zonename);
}
// etablishment/floor/zone/create/?link&floor=XX&zone=XX
else if(isset($_GET['link']) && isset($_GET['floor']) && isset($_GET['zone'])){
  $floor = $_GET['floor'];
  $zone = $_GET['zone'];
  if(is_numeric($floor) && is_numeric($zone)){
    SetZoneToFloor($zone, $floor);
  }
}