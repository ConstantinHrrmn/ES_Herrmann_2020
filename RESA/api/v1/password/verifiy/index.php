<?php
include '../../employee/get/index.php';

function VerifiyPasswordEmployee($username, $password){
    $key = "u7csu5qH6Cp9xWkrIgtGvTsOosnKvH9RhQOXteJtNhknqrEHcjp8dCGYuv02SBoHGsBRoN0zGeGeToULmWUDTb2HAgnSGntNJHmg";
    $pass = hash('sha256', hash('sha256', $key).$password);

    return GetEmployeeLogin($username, $pass);
}

function GeneratePassword($password){
    $key = "u7csu5qH6Cp9xWkrIgtGvTsOosnKvH9RhQOXteJtNhknqrEHcjp8dCGYuv02SBoHGsBRoN0zGeGeToULmWUDTb2HAgnSGntNJHmg";
    $pass = hash('sha256', hash('sha256', $key).$password);

    return $pass;
}

if(isset($_GET['verify']) && isset($_GET['username']) && isset($_GET['password'])){

    $username = $_GET['username'];
    $password = $_GET['password'];

    echo json_encode(VerifiyPasswordEmployee($username, hash('sha256', $password)));
} 
else if(isset($_GET['generate']) && isset($_GET['password'])){
    echo GeneratePassword(hash('sha256', $_GET['password']));
}