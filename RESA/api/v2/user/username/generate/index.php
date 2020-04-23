<?php

/*
*   Création d'un numéro d'utilisateur d'une longueur passée en paramètre
*   Params :
*       - $size : la longueur du numéro
*/
function randomUsername($size) {
    $alphabet = '1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $size; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

// Appel automatiquement la fonction quand on arrive sur la page
echo json_encode(randomUsername());