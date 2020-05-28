<?php

// On inclu le connecteur de la base de données
if(file_exists('../../pdo.php')){
    require_once '../../pdo.php';
}

require_once '../get/index.php'; // réservations
require_once '../../etablishment/schudle/get/index.php'; // les horaires du restaurant


// /reservation/worker/?avaible&amount=4&date=2020-05-14&etab=1&perfecttime=12:00
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
        
    }
}