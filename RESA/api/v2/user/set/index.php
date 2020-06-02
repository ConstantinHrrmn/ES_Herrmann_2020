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

// On inclu le fichier que génère le mot de passe pour l'utilisateur
include '../password/index.php';

include '../../vars.php';

function CreateUser($nom, $prenom, $email, $phone, $mdp){
    static $query = null;

    if ($query == null) {
      $req = 'INSERT INTO `user`(`first_name`, `last_name`, `phone`, `email`, `password`) VALUES (:n, :p, :ph, :e, :m)';
      $query = database()->prepare($req);
    }
  
    try {
      $query->bindParam(":n", $nom, PDO::PARAM_STR);
      $query->bindParam(":p", $prenom, PDO::PARAM_STR);
      $query->bindParam(":e", $email, PDO::PARAM_STR);
      $query->bindParam(":ph", $phone, PDO::PARAM_STR);
      $query->bindParam(":m", $mdp, PDO::PARAM_STR);
      $query->execute();
      $query->fetch();
      return true;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      return false;
    }
}

// user/set/?new&n=bob&p=gustave&e=b.gustave@gmail.com&m=bonjour&ph=0798828925
if(isset($_GET['new']) && isset($_GET['n']) && isset($_GET['p']) && isset($_GET['e']) && isset($_GET['m']) && isset($_GET['ph'])){
    $n = $_GET['n'];
    $p = $_GET['p'];
    $e = $_GET['e'];
    $m = $_GET['m'];
    $ph = $_GET['ph'];

    global $key;
    $pass = hash('sha256', hash('sha256', $key).$m);

    echo json_encode(CreateUser($n, $p, $e, $ph, $pass));
}