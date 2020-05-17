<?php

function GetImage($link){
    $json = file_get_contents($link);
    $img = json_decode($json);
    return $img;
}

