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
* Récupère tous les abonnements disponibles
*/
function GetAllSubscriptions(){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT `id`, `name`, `price`, `level` FROM `subscriptions`';
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
* Récupère tous les abonnements disponibles
*/
function GetSubscriptionById($id){
  static $query = null;

  if ($query == null) {
    $req = 'SELECT `id`, `name`, `price`, `level` FROM `subscriptions` WHERE id = :i';
    $query = database()->prepare($req);
  }

  try {
    $query->bindParam(':i', $id, PDO::PARAM_INT);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_ASSOC);
  }
  catch (Exception $e) {
    error_log($e->getMessage());
    $res = false;
  }

  return $res;
}


if(isset($_GET['all'])){
    echo json_encode(GetAllSubscriptions());
}else if(isset($_GET['id'])){
    echo json_encode(GetSubscriptionById($_GET['id']));
}