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

function GetEtablishmentFloors($idEtablishement){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT f.id as floor_id, f.name as floor_name, z.name as zone_name, s.begin, s.end FROM `floor` as f JOIN `has_zone` as hz ON hz.idFloor = f.id JOIN `zone` as z ON z.id = hz.idZone JOIN `zone_has_schudle` as zhs ON zhs.idZone = z.id JOIN `schudle` as s ON s.id = zhs.idSchudle WHERE f.idEtablishment = '.$idEtablishement;
      $query = database()->prepare($req);
    }
  
    try {
      $query->execute();
      $res = $query->fetchAll(PDO::FETCH_ASSOC);

      // Création d'un tableau provisoire
      $floors = array();

      // On parcours toutes les données envoyées par la base de données
      foreach ($res as $value){
        // On vérifie si le tableau est à 0 ou si la clé (l'id de l'étage) n'est pas déjà utilisé comme clé dans le tableau provisoire
        if(count($floors)<0 || !IsFloorInArray($floors, $value['floor_id'])){
          // On créer un enregistrement dans le tableau avec comme clé l'id de l'étage et comme valeurs le nom de l'étages et les zones
          $floors[$value['floor_id']] = array("name" => $value['floor_name'], "zones" => array());
        }
        // On ajoute la zone et ses horaires dans le tableau
        array_push($floors[$value['floor_id']]["zones"], array($value['zone_name'], $value['begin'], $value['end']));
      }
      return $floors;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      $res = false;
      return $res;
    }
}

// Retourne true si la valeur est utilisée comme clé dans le tableau donné
function IsFloorInArray($array, $value){
  if(array_key_exists($value, $array)){
    return true;
  }else{
    return false;
  }
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    if(is_numeric($id)){
        echo json_encode(GetEtablishmentFloors($id));
    }else{  
        echo json_encode('Non-numeric input');
    }
}