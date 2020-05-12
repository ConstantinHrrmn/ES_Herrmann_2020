<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
VERSION     : 1.0
*******************************************************************************/

// On inclut le connecteur de la base de données
include '../../../../pdo.php';

/*
* Récupère l'id de la dernière zone ajoutée
*/
function GetLastInsertedZone(){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT MAX(id) as last FROM `zone`';
      $query = database()->prepare($req);
    }
  
    try {
      $query->execute();
      $res = $query->fetch(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      $res = false;
    }
  
    return $res;
}

/*
* Récupère le nombre de places totales pour la zone recherchée
*/
function GetPlaces($id){
  static $query = null;

  if ($query == null) {
    $req = 'SELECT IFNULL(SUM(f.places), 0) as "places_total" FROM `has_furniture` as hf INNER JOIN furniture as f ON f.id = hf.idFurniture WHERE hf.idZone = :i';
    $query = database()->prepare($req);
  }

  try {
      $query->bindParam(':i', $id, PDO::PARAM_INT);

      $query->execute();
      $res = $query->fetchAll(PDO::FETCH_ASSOC);
      return $res;
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}

// etablishment/floor/zone/get?last
if(isset($_GET['last'])){
    echo json_encode(GetLastInsertedZone());
}
// etablishment/floor/zone/get?places&id=XX
else if(isset($_GET['places']) && isset($_GET['id'])){
  $id = $_GET['id'];
  if(is_numeric($id)){
    echo json_encode(GetPlaces($id));
  }else{
    echo json_encode("Not a valid number");
  }
}