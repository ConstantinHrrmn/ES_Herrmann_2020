<?php

// On inclu le connecteur de la base de données
if(file_exists('../../pdo.php')){
    require_once '../../pdo.php';
}

require_once '../get/index.php'; // réservations
require_once '../../etablishment/schudle/get/index.php'; // les horaires du restaurant


// /reservation/worker/?avaible&amount=4&date=2020-05-14&etab=1
if(isset($_GET['avaible']) && isset($_GET['amount']) && isset($_GET['date']) && isset($_GET['etab']) && isset($_GET['perfecttime'])){
    $id = $_GET['etab'];

    // Gestion de la date du jour
    $date = $_GET['date'];
    $timestamp = strtotime($date);
    $day = date('w', $timestamp);

    // Récupérer les horaires du jour
    $schudles = GetDaySchudles($id,$day);

    
    if($schudles == null){
        echo json_encode("the restaurant is not open at this date");
    }
    else{
        //var_dump($schudles);
        foreach($schudles as $schudle){
            $begin = explode(":", $schudle['begin']);
            $end = explode(":", $schudle['end']);
            var_dump($begin);
            var_dump($end);
            for($hour = $begin[0]; $hour <= $end[0]; $hour++){
                for($minutes = $begin[1]; $minutes <= $end[1]; $minutes+=15){
                    $time = $hour.":".$minutes.":00";
                    //$place = IsPlaceForReservation($time, 3600, $date, $id);
                    //echo $places."-";
                } 
            }
        }
        
    }

}