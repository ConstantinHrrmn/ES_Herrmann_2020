<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
DESCRIPTION : Ce script contient toutes les fonctions pour effectuer des READ sur la table 'user'
VERSION     : 1.0
*******************************************************************************/

session_start();

// On fait tous les includes dont nous avons besoin
include '../../../pdo.php';
include '../../../images/upload/index.php';
include '../../../vars.php';

// On vérifie que les données soient bien existantes
if(isset($_POST) && isset($_FILES)){
    if(count($_POST) > 0 && count($_FILES) > 0){
        if(CheckData($_POST)){
            SendData($_POST, $_FILES, $FullPathToAPI);
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        }
        else{
            echo json_encode(false);
        }
    }
    else{
        header("Location: ../../../index.php");
        exit();
    }
}

function CheckData($data){
    $name = $data['name'];
    $adress = $data['adress'];
    $phone = $data['phone'];
    $email = $data['email'];

    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        if(is_string($name)){
            if(is_string($adress)){
                if(is_string($phone)){
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}

function SendData($data, $images, $path){

    $queryData = array(
        'name' => $data['name'],
        'address' => $data['adress'],
        'phone' => $data['phone'],
        'email' => $data['email'],
        'creatorID' => $_SESSION['user']->id
    );

    $link1 = $path."etablishment/create/?".http_build_query($queryData);
    file_get_contents($link1);

    $lastid = json_decode(file_get_contents($path."etablishment/get/?last"));

    $images_amount = count($images['photos']['name']);

    for($i = 0; $i < $images_amount; $i++){
        SaveImageEtablishment($lastid->last, $_SESSION['user']->id, $images['photos']['name'][$i], $images['photos']['tmp_name'][$i]);
    }
}