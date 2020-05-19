<?php
session_start();

var_dump($_SESSION);

if(isset($_SESSION['sender']) && isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    $id = $_SESSION['sender'];

    $etablishment =  null;
}
else{
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>RESA BLOG</title>
    <!-- Iconic Fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./vendors/iconic-fonts/flat-icons/flaticon.css">
    <link href="../style/vendors/iconic-fonts/font-awesome/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="../style/assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery UI -->
    <link href="../style/assets/css/jquery-ui.min.css" rel="stylesheet">
    <!-- Costic styles -->
    <link href="../style/assets/css/style.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon.ico">

</head>

<body class="ms-body ms-primary-theme ">

    <!-- Preloader -->
    <div id="preloader-wrap">
        <div class="spinner spinner-8">
            <div class="ms-circle1 ms-child"></div>
            <div class="ms-circle2 ms-child"></div>
            <div class="ms-circle3 ms-child"></div>
            <div class="ms-circle4 ms-child"></div>
            <div class="ms-circle5 ms-child"></div>
            <div class="ms-circle6 ms-child"></div>
            <div class="ms-circle7 ms-child"></div>
            <div class="ms-circle8 ms-child"></div>
            <div class="ms-circle9 ms-child"></div>
            <div class="ms-circle10 ms-child"></div>
            <div class="ms-circle11 ms-child"></div>
            <div class="ms-circle12 ms-child"></div>
        </div>
    </div>

    <!-- navbar -->
    <div class="ms-aside-overlay ms-overlay-left ms-toggler" data-target="#ms-side-nav" data-toggle="slideLeft"></div>
    <?php include '../style/assets/php/navbar.php'; ?>


    <!-- Main Content -->
    <main class="body-content">
        <!-- Navigation Bar -->
        <?php include '../style/assets/php/topbar.php'; ?>
        <!-- Body Content Wrapper -->
        <div class="ms-content-wrapper">
            <h1>RESA BLOG</h1>
        </div>

    </main>

    <!-- SCRIPTS -->
    <!-- Global Required Scripts Start -->
    <script src="../style/assets/js/jquery-3.3.1.min.js"></script>
    <script src="../style/assets/js/popper.min.js"></script>
    <script src="../style/assets/js/bootstrap.min.js"></script>
    <script src="../style/assets/js/perfect-scrollbar.js"> </script>
    <script src="../style/assets/js/jquery-ui.min.js"> </script>
    <!-- Global Required Scripts End -->

    <!-- Costic core JavaScript -->
    <script src="../style/assets/js/framework.js"></script>

</body>

</html>