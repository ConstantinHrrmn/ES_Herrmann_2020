<?php

/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
VERSION     : 1.0
*******************************************************************************/

// On inclu le connecteur de la base de données
if(file_exists('../../../pdo.php')){
  require_once '../../../pdo.php';
}

$times = array(
  array(0,5,"nuit"),
  array(6,10,"matin"),
  array(11,15,"midi"),
  array(16,18,"après-midi"),
  array(19,23,"soir")
);


/*
* Récupère les horaires du restaurant pour la semaine
* Params:
*     - id : l'id du restaurant
*/
function ForEtablishement($id){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT d.id as did, d.name as dname,  s.id as sid, s.begin as sbegin, s.end as send FROM opening as o LEFT JOIN schudle as s ON s.id = o.idSchudle LEFT JOIN days as d ON d.id = o.idDay WHERE o.idEtablishement = :i ORDER BY d.id';
      $query = database()->prepare($req);
    }
  
    try {
        $query->bindParam(':i', $id, PDO::PARAM_INT);

        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        $days = GetWeekDays();
        $final = $res;
        $index = 0;
        $remeber = array();
        foreach($days as $day){
            $found = false;
            if(!IsRemembered($remeber, $day['id'])){
              array_push($remeber, $day['id']);
              foreach($res as $open){
                  if($day['id'] == $open['did']){
                      $found = true;
                  }
              }
              if(!$found){
                  array_splice($final, $index, 0, array(array('did' => $day['id'], 'dname' => $day['name'], 'closed' => 'closed')));
              }
            }
            
            $index++;
        }
        return $final;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
    }
}

function IsRemembered($array, $id){
  foreach($array as $value){
    if($value['id'] == $id){
      echo "CATCH";
      return true;
    }
  }
  return false;
}

/*
* Récupère les horaires du restaurant pour chaque zone
* Params:
*     - id : l'id du restaurant
*/
function ForAllHisZones($id){
    
}

/*
* Récupère le jour de la semaine
* Params:
*     - day : l'id du jour
*/
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

/*
* Récupère l'état actuel d'ouverture d'un restaurant
* Params:
*     - idEtab : l'id du restaurant
*/
function GetActualOpeningStatus($idEtab){
    $date = getdate();
    $idDay = $date['wday'];

    $idDay = $idDay == 0 ? 7 : $idDay;

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
* Récupère les horaires de la journée d'un établissement
* Params:
*     - idEtab : l'id du restaurant
*     - day : l'id de la journlée
*/
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
/*
function DoesSchudleExists($begin, $end){
  static $query = null;

  if ($query == null) {
    $req = 'SELECT s.id FROM `schudle` as s WHERE s.`begin` = :b AND s.`end`= :e';
    $query = database()->prepare($req);
  }

  try {
      $query->bindParam(':b', $begin, PDO::PARAM_STR);
      $query->bindParam(':e', $end, PDO::PARAM_STR);

      $query->execute();
      $res = $query->fetchAll(PDO::FETCH_ASSOC);
      return $res;
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}
*/

function GetDayById($id){
  static $query = null;

  if ($query == null) {
    $req = 'SELECT `id`, `name` FROM `days` WHERE `id` = :i';
    $query = database()->prepare($req);
  }

  try {
      $query->bindParam(':i', $id, PDO::PARAM_INT);

      $query->execute();
      $res = $query->fetch(PDO::FETCH_ASSOC);
      return $res;
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}

function SetClosed($id_day, $id_etab){
  
  static $query = null;
  if ($query == null) {
    $req = 'DELETE FROM `opening` WHERE `idDay` = :d AND `idEtablishement` = :e';
    $query = database()->prepare($req);
  }

  try {
      $query->bindParam(':d', $id_day, PDO::PARAM_INT);
      $query->bindParam(':e', $id_etab, PDO::PARAM_INT);

      $query->execute();
      $res = $query->fetch(PDO::FETCH_ASSOC);
      return $res;
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}

function SetOpen($id_schudle, $id_day, $id_etab){
  static $query = null;
  if ($query == null) {
    $req = 'INSERT INTO `opening`(`idEtablishement`, `idSchudle`, `idDay`) VALUES (:e,:s,:d)';
    $query = database()->prepare($req);
  }

  try {
    $query->bindParam(':s', $id_schudle, PDO::PARAM_INT);
      $query->bindParam(':d', $id_day, PDO::PARAM_INT);
      $query->bindParam(':e', $id_etab, PDO::PARAM_INT);

      $query->execute();
      $query->fetch(PDO::FETCH_ASSOC);
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}

function UpdateSchudle($id_schudle, $id_day, $id_etab){
  static $query = null;
  if ($query == null) {
    $req = 'UPDATE `opening` SET `idSchudle`= :s WHERE `idDay` = :d AND `idEtablishement` = :e';
    $query = database()->prepare($req);
  }

  try {
    $query->bindParam(':s', $id_schudle, PDO::PARAM_INT);
      $query->bindParam(':d', $id_day, PDO::PARAM_INT);
      $query->bindParam(':e', $id_etab, PDO::PARAM_INT);

      $query->execute();
      $res = $query->fetch(PDO::FETCH_ASSOC);
      return $res;
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}

function CreateSchudle($begin, $end){
  static $query = null;
  if ($query == null) {
    $req = 'INSERT INTO `schudle`(`begin`, `end`) VALUES (:b, :e)';
    $query = database()->prepare($req);
  }

  try {
    $query->bindParam(':b', $begin, PDO::PARAM_INT);
      $query->bindParam(':e', $end, PDO::PARAM_INT);

      $query->execute();
      $query->fetch(PDO::FETCH_ASSOC);
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}


function GetLastCreatedSchudle(){
  static $query = null;
  if ($query == null) {
    $req = 'SELECT MAX(id) as max FROM schudle';
    $query = database()->prepare($req);
  }

  try {
      $query->execute();
      $res = $query->fetch(PDO::FETCH_ASSOC);
      return $res;
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}

/*
function HasSchudleOnDay($id_day, $id_etab){
  static $query = null;
  if ($query == null) {
    $req = 'SELECT `idSchudle` FROM `opening` WHERE `idDay` = :d AND `idEtablishement` = :e';
    $query = database()->prepare($req);
  }

  try {
      $query->bindParam(':d', $id_day, PDO::PARAM_INT);
      $query->bindParam(':e', $id_etab, PDO::PARAM_INT);

      $query->execute();
      $res = $query->fetch(PDO::FETCH_ASSOC);
      return $res;
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}
*/


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
// etablishment/schudle/get?todayschudles&idEtab=XX&date=YYYY-MM-DD
// Récupère tous les horaires du restaurant pour la journée d'une date donnée
else if(isset($_GET['dayschudle']) && isset($_GET['idEtab']) && isset($_GET['date'])){
  $id = $_GET['idEtab'];
  $date = $_GET['date'];
  $timestamp = strtotime($date);
  $day = date('w', $timestamp);

  $schudles = GetDaySchudles($id,$day);

  $times = array();

  foreach($schudles as $s){
    $begin = explode(':', $s['begin']);
    $end = explode(':', $s['end']); 

    if($end[0] < $begin[0]){
      for($i=$begin[0]; $i <= 23; $i++){
        for($min=0; $min<60; $min+=15){
          array_push($times, $i.":".$min);
        }
      }
      for($i=0; $i <= $end[0]; $i++){
        for($min=0; $min<60; $min+=15){
          array_push($times, $i.":".$min);
        }
      }
    }
    else{
      for($i=$begin[0]; $i <= $end[0]; $i++){
        for($min=0; $min<60; $min+=15){
          array_push($times, $i.":".$min);
        }
      }
    }
  }

  echo json_encode($times);

  //echo json_encode();
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
// etablishment/schudle/get?exists&begin=XX&end=XX
else if(isset($_GET['exists']) && isset($_GET['begin']) && isset($_GET['end'])){
    $begin = $_GET['begin'];
    $end = $_GET['end'];
    echo json_encode(DoesSchudleExists($begin, $end));
}
// etablishment/schudle/get?change&begin=XX&end=XX&did=XX&closed=X&etab=XX
else if(isset($_GET['change']) && isset($_GET['begin']) && isset($_GET['end']) && isset($_GET['did']) && isset($_GET['closed']) && isset($_GET['etab'])){
  $begin = $_GET['begin'];
  $end = $_GET['end'];
  $did = $_GET['did'];
  $closed = $_GET['closed'];
  $etab = $_GET['etab'];

  //var_dump($_GET);

  $day = GetDayById($did);
  if($day != null){
    if($closed == 0){
      //$needNew = HasSchudleOnDay($day['id'], $etab);
      //$schudle = DoesSchudleExists($begin, $end);
      if($schudle != null){
        $id_schudle = $schudle[0]['id'];
        if($needNew != false){
          UpdateSchudle($id_schudle, $day['id'], $etab);
        }else{
          SetOpen($id_schudle, $day['id'], $etab);
        }
      }else{
        CreateSchudle($begin, $end);
        $last = GetLastCreatedSchudle();

        if($needNew == false){
          UpdateSchudle($last['max'], $day['id'], $etab);
        }else{
          SetOpen($last['max'], $day['id'], $etab);
        }
      }
    }else{
      SetClosed($day['id'], $etab);
    }
  }
}