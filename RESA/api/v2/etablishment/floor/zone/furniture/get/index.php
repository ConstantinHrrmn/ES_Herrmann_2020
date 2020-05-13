<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
VERSION     : 1.0
*******************************************************************************/

// On inclu le connecteur de la base de données
include '../../../../../pdo.php';

/*
* Récupère toutes les fournitures pour une zone
* Params:
*     - id : l'id de la zone recherchée
*/
function GetFurnitureForZone($id){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT f.id as fid, f.name as fname, f.color as fcolor, f.places as fplaces, fs.id as fsid, fs.shape as fsname, ft.id as ftid, ft.type as ftname FROM `has_furniture` as hf LEFT JOIN `furniture` as f ON f.id = hf.idFurniture LEFT JOIN `furniture_type` as ft ON ft.id = f.idType LEFT JOIN `furniture_shape` as fs ON fs.id = f.idShape WHERE hf.idZone = :i';
      $query = database()->prepare($req);
    }
  
    try {
        $query->bindParam(':i', $id, PDO::PARAM_INT);

        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
    }
}

/*
* Récupère toutes les fournitures pour un établissement
* Params:
*     - id : l'id de l'établissement
*/
function GetFurnituresForEtablishment($id){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT f.id as fid, f.name as fname, f.color as fcolor, f.places as fplaces, ft.id as ftid, ft.type as ftname, fs.id as fsid, fs.shape as fsname, z.id as zid, z.name as zname FROM furniture as f LEFT JOIN furniture_type as ft ON ft.id = f.idType LEFT JOIN furniture_shape as fs ON fs.id = f.idShape LEFT JOIN has_furniture as hf ON hf.idFurniture = f.id LEFT JOIN zone as z ON z.id = hf.idZone WHERE f.idEtablishement = :i ORDER BY fid ASC';
      $query = database()->prepare($req);
    }
  
    try {
        $query->bindParam(':i', $id, PDO::PARAM_INT);

        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
    }
}

// etablishment/floor/zone/furniture/get?zone&id=XX
if(isset($_GET['zone']) && isset($_GET['id'])){
    $id = $_GET['id'];
    if(is_numeric($id)){
        echo json_encode(GetFurnitureForZone($id));
    }else{
        echo json_encode("Not a valid number");
    }
}
// etablishment/floor/zone/furniture/get?etablishment&id=XX
else if(isset($_GET['etablishment']) && isset($_GET['id'])){
    $id = $_GET['id'];
    if(is_numeric($id)){
        echo json_encode(GetFurnituresForEtablishment($id));
    }else{
        echo json_encode("Not a valid number");
    }
}
else{
    echo json_encode("Missing parameter, please refer to the Cheat sheet");
}

