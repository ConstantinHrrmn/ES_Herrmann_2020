<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
VERSION     : 1.0
*******************************************************************************/

include '../../../../vars.php';

// etablishment/floor/zone/create/form/

if(isset($_POST)){
    if(count($_POST) > 0){
        $data = $_POST['name'];
        if(CheckData($data)){
            SendDataFloor($data, $_POST['etablishment'], $FullPathToAPI);
        }
    }
    
}

function SendDataFloor($name, $idEtablishment, $path){
    $name = str_replace(' ', '%20', $name);

    $linkCreateFloor = $path."etablishment/floor/create/?create&name=".$name."&etablishment=".$idEtablishment;
    file_get_contents($linkCreateFloor);

    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

function CheckData($data){
    return (is_string($data));
}