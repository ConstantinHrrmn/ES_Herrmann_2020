<?php

// On inclu le connecteur de la base de données
include '../../pdo.php';

function GetAllEmployees(){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT `employe`.`id`, `employe`.`first_name`, `employe`.`last_name`, `employe`.`phone`, `employe`.`email`, `permission`.`level`, `permission`.`name` FROM `employe` INNER JOIN `permission` ON `permission`.`id` = `employe`.`idPermission`';
      $query = database()->prepare($req);
    }

    try {
      $query->execute();
      $res = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      $res = false;
    }

    return $res;
}

function GetEmployeeLogin($username, $password){
    static $query = null;

    if ($query == null) {
      $req = "SELECT `employe`.`id`, `first_name`, `last_name`, `phone`, `email`, `username`, `permission`.`level`, `permission`.`name` FROM `employe` INNER JOIN `permission` ON `permission`.`id` = `employe`.`idPermission` WHERE `username` = '$username' AND `password` = '$password'";
      $query = database()->prepare($req);
    }
    
    try {
      $query->execute();
      $res = $query->fetch(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      $res = false;
    }

    return $res;
}

if(isset($_GET['all'])){
    echo json_encode(GetAllEmployees());
}