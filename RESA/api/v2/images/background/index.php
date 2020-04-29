<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
VERSION     : 1.0
*******************************************************************************/

include "../../vars.php";

if(isset($_GET['background'])){
    header("Location: ".$FullPathToAPI."images/background/images/RESA_700x1000.png");
    exit();
}
else if(isset($_GET['profil_background'])){
    header("Location: ".$FullPathToAPI."images/background/images/profile_background.png");
    exit();
}
