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

function GetReservationsForRange($begin, $end){

}

echo json_encode(GetReservationsForCurrentWeek());