<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
VERSION     : 1.0
*******************************************************************************/

include '../../../../../vars.php';

// etablishment/floor/zone/create/form/
if(isset($_POST)){
    if(count($_POST) > 0){
        $data = $_POST['name'];
        if(CheckData($data)){
            SendDataZone($data, $_POST['floor'], $FullPathToAPI);
        }
    }
    
}

/* 
* Création d'une zone dans l'établissement
*   - $name : le nom de la zone
*   - $idFloor : l'id de l'étage
*   - $path : le chemin jusqu'à l'API
*/
function SendDataZone($name, $idFloor, $path){
    $name = str_replace(' ', '%20', $name);

    $linkCreateZone = $path."etablishment/floor/zone/create/?create&name=".$name;
    file_get_contents($linkCreateZone);

    $lastid = json_decode(file_get_contents($path."etablishment/floor/zone/get?last"));

    $linkLinkZoneToFloor = $path."etablishment/floor/zone/create/?link&floor=".$idFloor."&zone=".$lastid->last;
    file_get_contents($linkLinkZoneToFloor);

    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

// Vérifie si l'entrée est bien une chaine de caractères
function CheckData($data){
    return (is_string($data));
}