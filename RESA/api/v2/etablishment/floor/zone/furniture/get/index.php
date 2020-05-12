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

// etablishment/floor/zone/furniture/get?id=XX
if(isset($_GET['id'])){
    $id = $_GET['id'];
    if(is_numeric($id)){
        echo json_encode(GetFurnitureForZone($id));
    }else{
        echo json_encode("Not a valid number");
    }
}
else{
    echo json_encode("Missing parameter, please refer to the Cheat sheet");
}

