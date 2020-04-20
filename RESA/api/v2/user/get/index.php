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
include '../../pdo.php';

// Get all users permet de récupérer tous les users de la base de données
function GetAllUsers(){
  static $query = null;

  if ($query == null) {
    $req = 'SELECT `user`.`id`, `user`.`first_name`, `user`.`last_name`, `user`.`phone`, `user`.`email`, `user`.`username` FROM `user`';
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

function GetUsersByPermission($idPermission){
  static $query = null;

  if ($query == null) {
    $req = 'SELECT `user`.`first_name`, `user`.`last_name`, `user`.`phone`, `user`.`email`, `user`.`username` FROM `user` WHERE `user`.`id` IN (SELECT `is_in_as`.`idUser` FROM `is_in_as` WHERE `is_in_as`.`idPermission` = '.$idPermission.')';
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

if(isset($_GET['all'])){
    echo json_encode(GetAllUsers());
}
else if(isset($_GET['byPermission'])){
  $idPermission = $_GET['byPermission'];
  // Vérification qu'il s'agit bien d'un int
  if(is_numeric($idPermission)){
    echo json_encode(GetUsersByPermission($idPermission));
  }else{
    echo json_encode("Valeur non integer");
  }
}