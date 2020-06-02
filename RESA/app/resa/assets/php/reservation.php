<?php

$reservation = 0;

if(isset($_POST['rechercher'])){
    $date = null;
    $heure = null;
    $amount = null;
    $duration = 0;

    if(isset($_POST['date'])){
        if(strlen($_POST['date']) > 1){
            $tmp = $_POST['date']; // la date arrive au format MM/DD/YYYY
            $tmp = explode("/", $tmp); // On explose la date par les /
            
            if(count($tmp) == 3){
                $m = $tmp[1]; // Le mois
                $d = $tmp[0]; // le jour
                $y = $tmp[2]; // l'année
                $date = $y."-".$m."-".$d; // On met la date en format YYYY-MM-DD
            }
        }
    }
    
    if(isset($_POST['hour'])){
        if(strlen($_POST['hour']) > 0){
            $heure = $_POST['hour'];
            $tmp = explode(":", $heure);
    
            // On vérifie la durée estimée pour les réservations 
            // Entre 6h et 11h : 1800 sec = 30 min
            // entre 11h et 18h : 3600 sec = 1 h
            // entre 18h et 23h : 7200 sec = 2 h
            // entre 23h et 6h : 5000 sec = 1h25
            $duration = ($tmp[0] >= 6 && $tmp[0] < 11) ? 1800 : (($tmp[0] > 11 && $tmp[0] < 18) ? 3600 : (($tmp[0] >= 18 && $tmp[0] < 23) ? 7200 : 5000));
        }
    }
    if(isset($_POST['amount'])){
        if(strlen($_POST['amount']) > 0){
            $amount = $_POST['amount'];
        }    
    }
    
    if($date == null || $heure == null || $amount == null){
        $reservation = -1;
    }else{
        $link = $path."reservation/get/?full&arrival=".$heure."&duration=".$duration."&date=".$date."&etab=".$data->id;
        $avaible = json_decode(file_get_contents($link));
        if($avaible->avaible == null || $avaible->avaible < $amount){
            $reservation = null;
        }else{
            $resdata = array($date, $heure, $amount);
        }
        
    }
  }