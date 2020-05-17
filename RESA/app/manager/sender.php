<?php
session_start();
include "../vars.php";

if(isset($_SESSION['sender'])){
    $id = $_SESSION['sender'];
    if(is_numeric($id)){
        $queryData = array(
            'i' => $id
          );
        $link = $path."etablishment/get/?level&".http_build_query($queryData);
        
        $json = file_get_contents($link);
        $data = json_decode($json);
        $level = $data->level;

        // RESA BLOG
        if($level == '1'){
            header("Location: ./resablog/index.php");
            exit();
        }
        // RESA PRO
        else if($level == '2'){
            header("Location: ./resapro/sender.php");
            exit();
        }
        // RESA FULL
        else if($level == '3'){
            header("Location: ./resafull/sender.php");
            exit();
        }
    }
}