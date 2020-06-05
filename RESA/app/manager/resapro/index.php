<?php

include "../../vars.php";
include "../style/assets/php/images.php";

session_start();

if(isset($_SESSION['etab']) && isset($_SESSION['user'])){
    $etab = $_SESSION['etab'];
    if($etab->subscription == 2){
        
    }
    else{
        header("Location: ../sender.php");
        exit();
    }
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
    <title>RESA manager</title>
    <!-- Iconic Fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../style/vendors/iconic-fonts/flat-icons/flaticon.css">
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

<?php //var_dump($_SESSION); ?>

<body class="ms-body ms-primary-theme">
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

        <div class="ms-content-wrapper">
            <img src="../style/assets/img/fakes/pro.jpg" style="width: 100%; height: auto;" alt="">
        </div>


        </div>
    </main>

    <!-- SCRIPTS -->
    <!-- Global Required Scripts Start -->
    <script src="../style/assets/js/jquery-3.3.1.min.js"></script>
    <script src="../style/assets/js/popper.min.js"></script>
    <script src="../style/assets/js/bootstrap.min.js"></script>
    <script src="../style/assets/js/perfect-scrollbar.js">
    </script>
    <script src="../style/assets/js/jquery-ui.min.js">
    </script>
    <!-- Global Required Scripts End -->
    <!-- Page Specific Scripts Start -->
    <script src="../style/assets/js/Chart.bundle.min.js">
    </script>
    <script src="../style/assets/js/widgets.js"> </script>
    <script src="../style/assets/js/clients.js">
    </script>
    <script src="../style/assets/js/Chart.Financial.js">
    </script>
    <script src="../style/assets/js/d3.v3.min.js">
    </script>
    <script src="../style/assets/js/topojson.v1.min.js">
    </script>
    <script src="../style/assets/js/datatables.min.js">
    </script>
    <script src="../style/assets/js/data-tables.js">
    </script>
    <!-- Page Specific Scripts Finish -->
    <!-- Costic core JavaScript -->
    <script src="../style/assets/js/framework.js"></script>
    <!-- Settings -->
    <script src="../style/assets/js/settings.js"></script>
</body>

</html>