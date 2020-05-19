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

function GetWeekDates(){
    $date = getdate();
    $wday = $date['wday'];
    $days = array();
    for($i = 1; $i < $wday; $i++){
        $index = $wday-$i;
        array_push($days, date("Y-m-d", strtotime("-".$index." day")));
    }
    for($i = 0; $i < (8-$wday); $i++){
        $index = $i;
        array_push($days, date("Y-m-d", strtotime("+".$index." day")));
    }
    return $days;
}

function GetReservationsForCurrentWeek(){
    $week = GetWeekDates();
    var_dump($week); 
}

function GetReservationsForRange($begin, $end, $etab){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT r.id AS rid, r.arrival AS arrival, r.amount AS amount,f.id as fid, f.name as fname, f.places as fplaces, u.id AS uid, u.first_name AS ufirstname, u.last_name AS ulastname, u.phone AS uphone, u.email AS umail FROM reservation AS r INNER JOIN user AS u ON u.id = r.idUser LEFT JOIN furniture AS f ON f.id = r.idFurniture WHERE CAST(r.arrival AS DATE) >= :d AND CAST(r.arrival AS DATE) <= :e AND r.idEtablishement = :i ORDER BY r.arrival';
      $query = database()->prepare($req);
    }
  
    try {
        $query->bindParam(':d', $begin, PDO::PARAM_STR);
        $query->bindParam(':e', $end, PDO::PARAM_STR);
        $query->bindParam(':i', $etab, PDO::PARAM_STR);

        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
    }
}

function GetReservationForDateAndTime($arrival, $duration, $date, $etab){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT SUM(src.places) - (SELECT SUM(f.places) not_avaible FROM reservation as r INNER JOIN furniture as f ON r.idFurniture = f.id WHERE r.idEtablishement = :etab AND CAST(r.arrival as DATE) = :d AND CAST(r.arrival as TIME) <= :arrival AND CAST(FROM_UNIXTIME(UNIX_TIMESTAMP(r.arrival)+r.duration) as TIME) >= :arrival) total FROM ( SELECT f.places FROM `zone_has_schudle` as zhs INNER JOIN schudle as s ON s.id = zhs.idSchudle INNER JOIN zone as z ON z.id = zhs.idZone LEFT JOIN has_furniture as hf ON hf.idZone = z.id LEFT JOIN furniture as f ON f.id = hf.idFurniture WHERE CAST(s.begin as time) <= :arrival AND CAST(s.end as time) >= CAST(FROM_UNIXTIME(UNIX_TIMESTAMP(:arrival)+:duration) as TIME) AND hf.idZone IS NOT NULL AND f.idEtablishement = :etab) src';
      $query = database()->prepare($req);
    }
  
    try {
        
        $query->bindParam(':arrival', $arrival, PDO::PARAM_STR);
        $query->bindParam(':duration', $duration, PDO::PARAM_STR);
        $query->bindParam(':d', $date, PDO::PARAM_STR);
        $query->bindParam(':etab', $etab, PDO::PARAM_STR);
        
        $query->execute();
        var_dump($query);
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
    }
}

if(isset($_GET['week'])){
    echo json_encode(GetReservationsForCurrentWeek());
}
else if(isset($_GET['range']) && isset($_GET['begin']) && isset($_GET['end']) && isset($_GET['etab'])){
    $begin = $_GET['begin'];
    $end = $_GET['end'];
    $etab = $_GET['etab'];
    echo json_encode(GetReservationsForRange($begin, $end, $etab));
}
else if(isset($_GET['full']) && isset($_GET['arrival']) && isset($_GET['duration']) && isset($_GET['date']) && isset($_GET['etab'])){
    $arrival = $_GET['arrival'];
    $duration = $_GET['duration'];
    $date = $_GET['date'];
    $etab = $_GET['etab'];
    echo json_encode(GetReservationForDateAndTime($arrival, $duration, $date, $etab));
}

