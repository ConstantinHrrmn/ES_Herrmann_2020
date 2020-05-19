<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
VERSION     : 1.0
*******************************************************************************/

// On inclu le connecteur de la base de données
include '../../../pdo.php';

/*
* Récupère les horaires du restaurant pour la semaine
* Params:
*     - id : l'id du restaurant
*/
function ForEtablishement($id){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT d.id as did, d.name as dname,  s.id as sid, s.begin as sbegin, s.end as send FROM opening as o LEFT JOIN schudle as s ON s.id = o.idSchudle LEFT JOIN days as d ON d.id = o.idDay WHERE o.idEtablishement = :i';
      $query = database()->prepare($req);
    }
  
    try {
        $query->bindParam(':i', $id, PDO::PARAM_INT);

        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        $days = GetWeekDays();
        $final = $res;
        $index = 0;
        foreach($days as $day){
            $found = false;
            foreach($res as $open){
                if($day['id'] == $open['did']){
                    $found = true;
                }
            }
            if(!$found){
                array_splice($final, $index, 0, array(array('did' => $day['id'], 'dname' => $day['name'], 'closed' => 'closed')));
            }
            $index++;
        }
        return $final;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
    }
}

/*
* Récupère les horaires du restaurant pour chaque zone
* Params:
*     - id : l'id du restaurant
*/
function ForAllHisZones($id){
    
}

function GetWeekDay($day){
    $id = $day['wday'];

    static $query = null;

    if ($query == null) {
      $req = 'SELECT * FROM days WHERE id = '.$id;
      $query = database()->prepare($req);
    }
  
    try {
        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
    }
}

function GetActualOpeningStatus($idEtab){
    $date = getdate();
    $idDay = $date['wday'];

    static $query = null;

    if ($query == null) {
      $req = 'SELECT s.id FROM opening as o INNER JOIN schudle as s ON s.id = o.idSchudle WHERE o.idDay = :d AND o.idEtablishement = :e AND UNIX_TIMESTAMP(s.begin) < UNIX_TIMESTAMP(NOW()) AND UNIX_TIMESTAMP(s.end) > UNIX_TIMESTAMP(NOW())';
      $query = database()->prepare($req);
    }
  
    try {
        $query->bindParam(':d', $idDay, PDO::PARAM_INT);
        $query->bindParam(':e', $idEtab, PDO::PARAM_INT);

        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
    }
}

/*
* Récupère tous les jours stockés dans la base de données
*/
function GetWeekDays(){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT * FROM days';
      $query = database()->prepare($req);
    }
  
    try {
        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
    }
}

// etablishment/schudle/get?zones&id=XX
if(isset($_GET['zones']) && isset($_GET['id'])){
    $id = $_GET['id'];
    echo json_encode(ForAllHisZones($id));
}
else if(isset($_GET['today'])){
    $date = getdate();
    echo json_encode(GetWeekDay($date));
}
else if(isset($_GET['open']) && isset($_GET['idEtab'])){
    $id = $_GET['idEtab'];
    echo json_encode(GetActualOpeningStatus($id));
}
else if(isset($_GET['id'])){
    $id = $_GET['id'];
    echo json_encode(ForEtablishement($id));
}