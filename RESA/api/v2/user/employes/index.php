<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
DESCRIPTION : Ce script va travailler sur les employés de la table "is_in_for"
VERSION     : 1.0
*******************************************************************************/

// On inclu le connecteur de la base de données
include '../../pdo.php';

/*
* Récupère les users qui travaillent dans un établissement donné
* Params :
*   - $idEtablishement : L'id de l'établissement
*/
function GetEmployesForEtablishement($idEtablishement){
  static $query = null;

  if ($query == null) {
    $req = 'SELECT u.id as id,  u.first_name as user_firstname, u.last_name as user_lastname, p.name as permission_name, p.level as permission_level, u.username as user_username, u.email as email, u.phone as phone FROM is_in_as as iis INNER JOIN permission as p ON p.id = iis.idPermission INNER JOIN user as u ON u.id = iis.idUser WHERE iis.idEtablishement = '.$idEtablishement;
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

if(isset($_GET['workingFor'])){
    $idEtablishement = $_GET['workingFor'];
    // Vérification qu'il s'agit bien d'un int
    if(is_numeric($idEtablishement)){
      echo json_encode(GetEmployesForEtablishement($idEtablishement));
    }else{
      echo json_encode("Valeur non integer");
    }
}