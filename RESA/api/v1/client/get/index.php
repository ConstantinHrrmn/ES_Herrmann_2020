<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
DESCRIPTION : Ce script contient toutes les fonctions pour effectuer des READ sur la table 'client'
VERSION     : 1.0
*******************************************************************************/

// On inclu le connecteur de la base de données
include '../../pdo.php';

// Récupère tous les clients de la liste de clients
// cette fonction peut prendre beaucoup de temps en fonction du nombre de clients inscrits
function GetAllClients(){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT `id`, `first_name`, `last_name`, `phone`, `email` FROM `client`';
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

// Récupère un client en fonction de son id passé en paramètre
function GetClientById($id){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT `id`, `first_name`, `last_name`, `phone`, `email` FROM `client` WHERE `id` = :id';
      $query = database()->prepare($req);
    }

    try {
      $query->bindParam(':id', $id, PDO::PARAM_INT);
      $query->execute();
      $res = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      $res = false;
    }

    return $res;
}

// Récupère les clients en fonction du nom de famille passé en paramètre
function GetClientByLastname($lastname){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT `id`, `first_name`, `last_name`, `phone`, `email` FROM `client` WHERE `last_name` = :lastname';
      $query = database()->prepare($req);
    }

    try {
      $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
      $query->execute();
      $res = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      $res = false;
    }

    return $res;
}

// Récupère les clients en fonction du prénom passé en paramètre
function GetClientByFirstname($firstname){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT `id`, `first_name`, `last_name`, `phone`, `email` FROM `client` WHERE `first_name` = :firstname';
      $query = database()->prepare($req);
    }

    try {
      $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
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
    echo json_encode(GetAllClients());
}

else if(isset($_GET['id'])){
    echo json_encode(GetClientById($_GET['id']));
}

else if(isset($_GET['lastname'])){
    echo json_encode(GetClientByLastname($_GET['lastname']));
}

else if(isset($_GET['firstname'])){
    echo json_encode(GetClientByFirstname($_GET['firstname']));
}