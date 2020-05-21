<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
VERSION     : 1.0
*******************************************************************************/

// On inclu le connecteur de la base de données
require_once '../../../pdo.php';

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

function GetDaySchudles($idEtab, $day){
  

  static $query = null;

    if ($query == null) {
      $req = 'SELECT s.id, s.begin,s.end FROM opening as o INNER JOIN schudle as s ON s.id = o.idSchudle WHERE o.idEtablishement = :e AND o.idDay = :d';
      $query = database()->prepare($req);
    }
  
    try {
        $query->bindParam(':e', $idEtab, PDO::PARAM_INT);
        $query->bindParam(':d', $day, PDO::PARAM_INT);

        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
    }
}

function GetSchudlesWithPlaces($idEtab, $date){
    $yourDate = DateTime::createFromFormat("Y-m-d", $date);
    $dateday = $yourDate->format("w");

    $schudles = GetDaySchudles($idEtab, $dateday);
    $hour = 1;
    $quarter = 15;

    foreach($schudles as $schudle){
      $tempsBegin = explode(':', $schudle['begin']);
      $tempsEnd = explode(':', $schudle['end']);
      for($i = $tempsBegin[0]; $i <= 2; $i+=$hour){
        for($j = $tempsBegin[1]; $j <= $tempsEnd[1]; $j+=$quarter){
          $arrival = $i.":".$j;
          $duration = $i < 17 ? 3600 : 7200;
          echo $i;
          //GetReservationForDateAndTime($arrival, $duration, $date, $idEtab);
          //echo json_encode(GetReservationForDateAndTime($arrival, $duration, $date, $idEtab));
        }
      }
      var_dump($tempsBegin);
      var_dump($tempsEnd);
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
// etablishment/schudle/get?todayschudles&idEtab=XX
// Récupère tous les horaires du restaurant pour la journée
else if(isset($_GET['todayschudles']) && isset($_GET['idEtab'])){
  $id = $_GET['idEtab'];
  $date = getdate();
  $date = $date['wday'];
  echo json_encode(GetDaySchudles($id,$date));
}
// etablishment/schudle/get?todayschudlesandplaces&idEtab=XX&date=YYYY-MM-DD
// Récupère tous les horaires du restaurant pour la journée avec les places disponbiles
else if(isset($_GET['todayschudlesandplaces']) && isset($_GET['idEtab']) && isset($_GET['date'])){
  $id = $_GET['idEtab'];
  $date = $_GET['date'];
  //echo json_encode(GetDaySchudles($id));
  GetSchudlesWithPlaces($id, $date);
}
// etablishment/schudle/get?today
// Récupère le jour de la semaine
else if(isset($_GET['today'])){
    $date = getdate();
    echo json_encode(GetWeekDay($date));
}
// etablishment/schudle/get?open&idEtab=XX
// Récupère le statut actuel du restaurant si il est ouvert ou non 
else if(isset($_GET['open']) && isset($_GET['idEtab'])){
    $id = $_GET['idEtab'];
    echo json_encode(GetActualOpeningStatus($id));
}
// etablishment/schudle/get?id=XX
else if(isset($_GET['id'])){
    $id = $_GET['id'];
    echo json_encode(ForEtablishement($id));
}