<?php
include '../../employee/get/index.php';

function VerifiyPassword($username, $password){
    $key = "u7csu5qH6Cp9xWkrIgtGvTsOosnKvH9RhQOXteJtNhknqrEHcjp8dCGYuv02SBoHGsBRoN0zGeGeToULmWUDTb2HAgnSGntNJHmg";
    $pass = hash('sha256', hash('sha256', $key).$password);

    return GetEmployeeLogin($username, $pass);
}

if(isset($_GET['verify']) && isset($_GET['username']) && isset($_GET['password'])){

    $username = $_GET['username'];
    $password = $_GET['password'];

    echo json_encode(VerifiyPassword($username, hash('sha256', $password)));
}