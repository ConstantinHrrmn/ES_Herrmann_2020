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

// etablishment/floor/zone/get?last
if(isset($_GET['last'])){
    echo json_encode(GetLastInsertedZone());
}