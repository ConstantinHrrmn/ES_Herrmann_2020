<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
VERSION     : 1.0
*******************************************************************************/

// On inclu le connecteur de la base de données
include '../../pdo.php';

/*
* Récupère tous les établissements
*/
function GetAllEtablishements(){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT e.id, e.name, e.address, e.phone, e.email, m.name as menu_name, m.description as menu_descritpion FROM `establishment` as e LEFT JOIN menu as m ON e.id = m.id';
      $query = database()->prepare($req);
    }
  
    try {
      $query->execute();
      $res = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      $res = false;
    }
  
    return $res;
}

/*
* Récupère tous les établissement dont l'utilisateur passé en paramètre est le manager
* Params:
*     - idUser : l'id de l'utilisateur
*/
function GetAllEtablishementsForManager($idUser){
  static $query = null;

    if ($query == null) {
      $req = 'SELECT e.id, e.name, e.address, e.phone FROM `is_in_as` as iia INNER JOIN `establishment` as e ON e.id = iia.idEtablishement WHERE iia.idUser = :u AND iia.idPermission = 2';
      $query = database()->prepare($req);
    }
  
    try {
        $query->bindParam(':u', $idUser, PDO::PARAM_INT);

        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
    }
}

/*
* Récupère un établissement d'après son id
* Params:
*     - idEtablishement : l'id de l'établissement dont on veut les infos
*/
function GetEtablishementById($idEtablishement){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT e.id, e.name, e.address, e.phone, e.email, m.name as menu_name, m.description as menu_descritpion FROM `establishment` as e LEFT JOIN menu as m ON e.id = m.id WHERE e.id = '.$idEtablishement;
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
* Récupère l'id du dernier établissement ajouté
*/
function GetLastInsertedEtablishement(){
  static $query = null;

  if ($query == null) {
    $req = 'SELECT MAX(id) as last FROM `establishment`';
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


// exemple : etablishment/get/?id=XX
if(isset($_GET['id'])){
    $id = $_GET['id'];
    if(is_numeric($id)){
        echo json_encode(GetEtablishementById($id));
    }else{  
        echo json_encode('Non-numeric input');
    }
}
// exemple : etablishment/get/?last
else if(isset($_GET['last'])){
  echo json_encode(GetLastInsertedEtablishement());
}
// exemple : etablishment/get/?manager&iduser=XX
else if(isset($_GET['manager']) && isset($_GET['iduser'])){
  $id = $_GET['iduser'];
  if(is_numeric($id)){
      echo json_encode(GetAllEtablishementsForManager($id));
  }else{  
      echo json_encode('Non-numeric input');
  }
}
else{
    echo json_encode(GetAllEtablishements());
}