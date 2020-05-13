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

// etablishment/schudle/get?id=XX
if(isset($_GET['id'])){
    $id = $_GET['id'];
    echo json_encode(ForEtablishement($id));
}