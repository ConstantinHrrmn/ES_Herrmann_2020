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
* Récupère tous les horaires d'une zone
* Params:
*     - id : l'id de la zone recherchée
*/
function GetAllSchedulesForZone($id){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT s.id as schedule_id, s.begin as begin, s.end as end FROM `zone_has_schudle` as zhs INNER JOIN `schudle` as s ON s.id = zhs.idSchudle WHERE zhs.idZone = :i';
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

// etablishment/floor/zone/schedule/get?all&id=XX
if(isset($_GET['all']) && isset($_GET['id'])){
    $id = $_GET['id'];
    echo json_encode(GetAllSchedulesForZone($id));
}