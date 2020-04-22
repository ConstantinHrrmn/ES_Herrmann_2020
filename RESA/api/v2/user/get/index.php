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

/*
* Récupère les users d'après leur permission
* Params :
*   - $idPermission : L'id de la permission recherchée
*/
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

/*
* Récupère les informations sur les permissions d'un user d'après son id
* Params :
*   - $id : l'id de l'utilisateur recherché
*/
function GetUserPermissionById($id){
  static $query = null;

  if ($query == null) {
    $req = 'SELECT IFNULL(e.name, "-") etablishment_name, IFNULL(p.name, "-") as permission_name FROM user as u LEFT JOIN is_in_as as iia ON iia.idUser = u.id LEFT JOIN establishment as e ON e.id = iia.idEtablishement LEFT JOIN permission as p ON p.id = iia.idPermission WHERE u.id ='.$id;
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
* Récupère les données d'un utilisateur d'après son id 
* Params :
*   - $id : l'id de l'utilisateur recherché
*/
function GetUser($id){
  static $query = null;

  if ($query == null) {
    $req = 'SELECT `id`, `first_name`, `last_name`, `phone`, `email`, `username` FROM `user` WHERE `id` = '.$id;
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


if(isset($_GET['byPermission'])){
  $idPermission = $_GET['byPermission'];
  // Vérification qu'il s'agit bien d'un int
  if(is_numeric($idPermission)){
    echo json_encode(GetUsersByPermission($idPermission));
  }else{
    echo json_encode("Valeur non integer");
  }
}
else if(isset($_GET['permissions']) && isset($_GET['id'])){
  $id = $_GET['id'];
  // Vérification qu'il s'agit bien d'un int
  if(is_numeric($id)){
    echo json_encode(GetUserPermissionById($id));
  }else{
    echo json_encode("Valeur non integer");
  }
}
else if(isset($_GET['user']) && isset($_GET['id'])){
  $id = $_GET['id'];
  // Vérification qu'il s'agit bien d'un int
  if(is_numeric($id)){
    echo json_encode(GetUser($id));
  }else{
    echo json_encode("Valeur non integer");
  }
}
else if(isset($_GET['id'])){
  $id = $_GET['id'];
  // Vérification qu'il s'agit bien d'un int
  if(is_numeric($id)){
    $user = GetUser($id);
    $permissions = GetUserPermissionById($id);

    $user['permissions']= $permissions;
    echo json_encode($user);
  }else{
    echo json_encode("Valeur non integer");
  }
}
else{
  echo json_encode(GetAllUsers());
}