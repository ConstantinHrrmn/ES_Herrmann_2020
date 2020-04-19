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

// Get all users permet de récupérer tous les users de la base de données
function GetAllEmployes(){
  static $query = null;

  if ($query == null) {
    $req = '';
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
    echo json_encode(GetAllEmployes());
}