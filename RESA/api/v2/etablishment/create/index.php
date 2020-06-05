<?php
 header("Access-Control-Allow-Origin: *");
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
*   - $p : le numéro de téléphone
*   - $m : l'adresse email
*   - $street : le nom de la rue + le numéro
*   - $town : la ville
*   - $npa : npa de l'adresse
*   - $country : l'id du pays
*/
function CreateEtablishment($n, $p, $m, $street, $town, $npa, $country, $subs){
    static $query = null;

    if ($query == null) {
      $req = 'INSERT INTO `establishment`(`name`, `phone`, `email`, `street`, `npa`, `city`, `country`, `id_subscription`) VALUES (:n, :p, :m, :street, :npa, :town, :country, :s)';
      $query = database()->prepare($req);
    }
  
    try {
        $query->bindParam(':n', $n, PDO::PARAM_STR);
        $query->bindParam(':p', $p, PDO::PARAM_STR);
        $query->bindParam(':m', $m, PDO::PARAM_STR);
        $query->bindParam(':street', $street, PDO::PARAM_STR);
        $query->bindParam(':town', $town, PDO::PARAM_STR);
        $query->bindParam(':npa', $npa, PDO::PARAM_INT);
        $query->bindParam(':country', $country, PDO::PARAM_INT);
        $query->bindParam(':s', $subs, PDO::PARAM_INT);
        
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

if(isset($_GET['name']) && isset($_GET['phone']) && isset($_GET['email']) && isset($_GET['creatorID']) && isset($_GET['street']) && isset($_GET['town']) && isset($_GET['npa']) && isset($_GET['country']) && isset($_GET['subs'])){
    $name = $_GET['name'];
    $phone = $_GET['phone'];
    $email = $_GET['email'];
    $creator = $_GET['creatorID'];
    $street = $_GET['street'];
    $town = $_GET['town'];
    $npa = $_GET['npa'];
    $country = $_GET['country'];
    $subs = $_GET['subs'];

    if(CreateEtablishment($name, $phone, $email, $street, $town, $npa, $country, $subs)){
        $json = json_decode(file_get_contents($FullPathToAPI."etablishment/get/?last"));
        $lastid = $json->last;
        CreateIsInAs((int)$lastid, (int)$creator, "2");
    }
}
// Vérifie qu'il y aie bien le nom, l'adresse, le numéro de téléphone et l'email dans les paramètres
else if(isset($_GET['name']) && isset($_GET['phone']) && isset($_GET['email'])  && isset($_GET['street']) && isset($_GET['town']) && isset($_GET['npa']) && isset($_GET['country']) && isset($_GET['subs'])){
    $name = $_GET['name'];
    $phone = $_GET['phone'];
    $email = $_GET['email'];
    $street = $_GET['street'];
    $town = $_GET['town'];
    $npa = $_GET['npa'];
    $country = $_GET['country'];

    if(CreateEtablishment($name, $phone, $email, $street, $town, $npa, $country)){
        echo json_encode("OK");
        var_dump($_GET);
    }else{
        echo json_encode("Une erreur est survenue");
    }
}
else{
    echo json_encode(false);
}