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

function GetAllEtablishements(){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT e.name, e.address, e.phone, e.email, m.name as menu_name, m.description as menu_descritpion FROM `establishment` as e INNER JOIN menu as m ON e.id = m.id';
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

function GetEtablishementById($idEtablishement){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT e.name, e.address, e.phone, e.email, m.name as menu_name, m.description as menu_descritpion FROM `establishment` as e INNER JOIN menu as m ON e.id = m.id WHERE e.id = '.$idEtablishement;
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

if(isset($_GET['id'])){
    $id = $_GET['id'];
    if(is_numeric($id)){
        echo json_encode(GetEtablishementById($id));
    }else{  
        echo json_encode('Non-numeric input');
    }
}
else{
    echo json_encode(GetAllEtablishements());
}