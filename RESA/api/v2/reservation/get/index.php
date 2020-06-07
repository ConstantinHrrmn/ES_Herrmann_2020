<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
VERSION     : 1.0
*******************************************************************************/

// On inclu le connecteur de la base de données
if(file_exists('../../pdo.php')){
    require_once '../../pdo.php';
}

/*
* Récupère les les dates de la semaine en cours
*/
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

/*
* Récupère les réservation pour une intervalle entre 2 dates pour un établissement
*/
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

/*
* Récupère si il y a une place pour une réservation
* Params:
*     - arrival : l'heure d'arrivée
*     - duration : la durée estimée
*     - date : la date de la réservation
*     - etab : l'id de l'établissement
*/
function IsPlaceForReservation($arrival, $duration, $date, $etab){
    static $query = null;

    if ($query == null) {
      $req = 'Call IsPlaceForReservation(:etab,:d,:arrival, :duration, @avaible)';
      $query = database()->prepare($req);
    }
    try {
        
        $query->bindParam(':arrival', $arrival, PDO::PARAM_STR);
        $query->bindParam(':duration', $duration, PDO::PARAM_STR);
        $query->bindParam(':d', $date, PDO::PARAM_STR);
        $query->bindParam(':etab', $etab, PDO::PARAM_STR);
        
        $query->execute();
        $res = $query->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
    catch (Exception $e) {
      error_log($e->getMessage());
    }
}


if(isset($_GET['range']) && isset($_GET['begin']) && isset($_GET['end']) && isset($_GET['etab'])){
    $begin = $_GET['begin'];
    $end = $_GET['end'];
    $etab = $_GET['etab'];
    echo json_encode(GetReservationsForRange($begin, $end, $etab));
}
// /reservation/get/?full&arrival=12:00&duration=3600&date=2020-05-14&etab=1
else if(isset($_GET['full']) && isset($_GET['arrival']) && isset($_GET['duration']) && isset($_GET['date']) && isset($_GET['etab'])){
    $arrival = $_GET['arrival'];
    $duration = $_GET['duration'];
    $date = $_GET['date'];
    $etab = $_GET['etab'];
    echo json_encode(IsPlaceForReservation($arrival, $duration, $date, $etab));
}
