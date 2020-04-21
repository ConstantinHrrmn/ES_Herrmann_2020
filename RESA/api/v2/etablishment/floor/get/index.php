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

      $floors = array();

      foreach ($res as $value){
        //if(count($floors)<0 || )
      }
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      $res = false;
    }
    return $res;
}

function IsFloorInArray($array, $value){
  $return = false;
  foreach ($array as $val){
    if($val['floor_id'] == $value){
      $return = true;
    }
  }
  return $return;
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    if(is_numeric($id)){
        //echo json_encode(GetEtablishmentFloors($id));
        GetEtablishmentFloors($id);
    }else{  
        echo json_encode('Non-numeric input');
    }
}