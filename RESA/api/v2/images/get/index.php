<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
VERSION     : 1.0
*******************************************************************************/
include '../../pdo.php';

include '../../vars.php';

/*
* Récupère toutes les informations de l'image dans la base de données
* Params:
*   - id : l'id de l'image
*/
function GetImageData($id){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT i.id, i.alt, i.path, u.id as user_id, u.first_name FROM `images` as i LEFT JOIN `user` as u ON u.id = i.postedBy WHERE i.id = :id';
      $query = database()->prepare($req);
    }
  
    try {
        $query->bindParam(':id', $id, PDO::PARAM_STR);

        $query->execute();
        $res = $query->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      return false;
    }
}

/*
* Récupère le chemin d'une image
* Params:
*   - id : l'id de l'image
*/
function GetImagePath($id){
    $path = GetImageData($id);
    return $path['path'];
}

/*
* Récupère tous les paths de toutes les images d'un établissement
* Params:
*   - id : l'id de l'établissement
*   - FullPathToAPI : le chemin complet vers l'API
*/
function GetImagesForEtablishment($id, $FullPathToAPI){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT CONCAT(:f, i.path) as full_path FROM `etablishement_has_image` as ehi INNER JOIN `images` as i ON i.id = ehi.idImages WHERE ehi.idEtablishement = :i';
      $query = database()->prepare($req);
    }
  
    try {
        $query->bindParam(':f', $FullPathToAPI, PDO::PARAM_STR);
        $query->bindParam(':i', $id, PDO::PARAM_STR);

        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      return false;
    }
}

/*
* Récupère tous les paths de toutes les images d'un repas
* Params:
*   - id : l'id du repas
*   - FullPathToAPI : le chemin complet vers l'API
*/
function GetImagesForDish($id, $FullPathToAPI){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT CONCAT(:f, i.path) as full_path FROM `dish_has_image` as dhi INNER JOIN `images` as i ON i.id = dhi.idImages WHERE dhi.idDish = :i';
      $query = database()->prepare($req);
    }
  
    try {
        $query->bindParam(':f', $FullPathToAPI, PDO::PARAM_STR);
        $query->bindParam(':i', $id, PDO::PARAM_STR);

        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      return false;
    }
}

if(isset($_GET['data']) && isset($_GET['id'])){
    echo json_encode(GetImageData($_GET['id']) );
}
else if(isset($_GET['etablishment']) && isset($_GET['id'])){
    echo json_encode(GetImagesForEtablishment($_GET['id'], $FullPathToAPI));
}
else if(isset($_GET['dish']) && isset($_GET['id'])){
    echo json_encode(GetImagesForDish($_GET['id'], $FullPathToAPI));
}
else if(isset($_GET['id'])){
    header("Location: ".$FullPathToAPI.GetImagePath($_GET['id']));
    exit();
}


