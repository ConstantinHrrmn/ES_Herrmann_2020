<?php
//session_start();

//Constantes
define("DB_HOST", "localhost");
define("DB_NAME", "resa");
define("DB_USER", "resa_tech_es");
define("DB_PASSWORD", "WhutMerYmZeR6EHb");

function database(){
    static $dbc = null;
    
    if ($dbc == null) {
        try{
            $dbc = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_PERSISTENT => TRUE));
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br/>';
            echo 'N° : ' . $e->getCode();
            die('Could not connect to MySQL');
        }
    }
    return $dbc;
}