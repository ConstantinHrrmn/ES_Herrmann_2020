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

include '../../vars.php';

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

function CreateIsInAs($idEtablishment, $idUser, $idPermission){
    static $query = null;

    if ($query == null) {
      $req = 'INSERT INTO `is_in_as`(`idUser`, `idEtablishement`, `idPermission`) VALUES (:u, :e, :p)';
      $query = database()->prepare($req);
    }
  
    try {
        $query->bindParam(':u', $idUser, PDO::PARAM_INT);
        $query->bindParam(':e', $idEtablishment, PDO::PARAM_INT);
        $query->bindParam(':p', $idPermission, PDO::PARAM_INT);

        $query->execute();
        $query->fetch();
    }
    catch (Exception $e) {
      error_log($e->getMessage());
    }
    
}

if(isset($_GET['name']) && isset($_GET['address']) && isset($_GET['phone']) && isset($_GET['email']) && isset($_GET['creatorID'])){
    $name = $_GET['name'];
    $address = $_GET['address'];
    $phone = $_GET['phone'];
    $email = $_GET['email'];
    $creator = $_GET['creatorID'];

    if(CreateEtablishment($name, $address, $phone, $email)){
        $json = json_decode(file_get_contents($FullPathToAPI."etablishment/get/?last"));
        $lastid = $json->last;
        CreateIsInAs((int)$lastid, (int)$creator, "2");
    }
}
// Vérifie qu'il y aie bien le nom, l'adresse, le numéro de téléphone et l'email dans les paramètres
else if(isset($_GET['name']) && isset($_GET['address']) && isset($_GET['phone']) && isset($_GET['email'])){
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
    echo json_encode(false);
}