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
* Création d'un établissement avec comme paramètres :
*   - $n : le nom 
*   - $a : l'addresse
*   - $p : le numéro de téléphone
*   - $m : l'adresse email
*/
function CreateEtablishment($n, $a, $p, $m){
    static $query = null;

    if ($query == null) {
      $req = 'INSERT INTO `establishment`(`name`, `address`, `phone`, `email`) VALUES (:n, :a, :p, :m)';
      $query = database()->prepare($req);
    }
  
    try {
        $query->bindParam(':n', $n, PDO::PARAM_STR);
        $query->bindParam(':a', $a, PDO::PARAM_STR);
        $query->bindParam(':p', $p, PDO::PARAM_STR);
        $query->bindParam(':m', $m, PDO::PARAM_STR);

        $query->execute();
        $query->fetch();

        return true;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      return false;
    }
}

// Vérifie qu'il y aie bien le nom, l'adresse, le numéro de téléphone et l'email dans les paramètres
if(isset($_GET['name']) && isset($_GET['address']) && isset($_GET['phone']) && isset($_GET['email'])){
    $name = $_GET['name'];
    $address = $_GET['address'];
    $phone = $_GET['phone'];
    $email = $_GET['email'];
    if(CreateEtablishment($name, $address, $phone, $email)){
        echo json_encode("OK");
    }else{
        echo json_encode("Une erreur est survenue");
    }
}
else{
    echo json_encode("Les informations sont incompletes");
}