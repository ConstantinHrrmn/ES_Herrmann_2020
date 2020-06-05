<?php

include "../vars.php";

session_start();

if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];

    $subs = json_decode(file_get_contents($path."etablishment/subscriptions/?all"));
    
}
else{
    header("Location: ./login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login</title>
    <!-- Iconic Fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./style/vendors/iconic-fonts/flat-icons/flaticon.css">
    <link href="./style/vendors/iconic-fonts/font-awesome/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="./style/assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery UI -->
    <link href="./style/assets/css/jquery-ui.min.css" rel="stylesheet">
    <!-- Costic styles -->
    <link href="./style/assets/css/style.css" rel="stylesheet">
    <link href="./style/assets/css/pricing.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon.ico">

</head>

<body class="ms-body ms-primary-theme ms-logged-out">

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


    <!-- Main Content -->
    <main class="body-content">

            <section class="pricing py-5">
                <div class="container">
                    <div class="row">
                        <!-- Free Tier -->
                        <div class="col-lg-4">
                            <div class="card mb-5 mb-lg-0">
                                <div class="card-body">
                                    <h5 class="card-title text-muted text-uppercase text-center"><?php echo $subs[0]->name; ?></h5>
                                    <h6 class="card-price text-center"><?php echo $subs[0]->price; ?> CHF<span class="period">/mois</span></h6>
                                    <hr>
                                    <ul class="fa-ul">
                                        <li><span class="fa-li"><i class="fas fa-check"></i></span>Gestion basique des informations</li>
                                        <li><span class="fa-li"><i class="fas fa-check"></i></span>Horaires par jour</li>
                                        <li><span class="fa-li"><i class="fas fa-check"></i></span>Carte et menus</li>
                                    </ul>
                                    <a href="payment.php?subscription=<?php echo $subs[0]->id; ?>" class="btn btn-block btn-primary text-uppercase">J'essaie gratuitement</a>
                                </div>
                            </div>
                        </div>
                        <!-- Pro Tier -->
                        <div class="col-lg-4">
                            <div class="card mb-5 mb-lg-0">
                                <div class="card-body">
                                    <h5 class="card-title text-muted text-uppercase text-center"><?php echo $subs[1]->name; ?></h5>
                                    <h6 class="card-price text-center"><?php echo $subs[1]->price; ?> CHF<span class="period">/mois</span></h6>
                                    <hr>
                                    <ul class="fa-ul">
                                        <li><span class="fa-li"><i class="fas fa-check"></i></span><strong>PACK <?php echo $subs[0]->name; ?> (inclus)</strong></li>
                                        <li><span class="fa-li"><i class="fas fa-check"></i></span>Réservations par RESA</li>
                                        <li><span class="fa-li"><i class="fas fa-check"></i></span>Gestion des employés</li>
                                    </ul>
                                    <a href="payment.php?subscription=<?php echo $subs[1]->id; ?>" class="btn btn-block btn-primary text-uppercase">Je prend PRO</a>
                                </div>
                            </div>
                        </div>
                        <!-- Full Tier -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-muted text-uppercase text-center"><?php echo $subs[2]->name; ?></h5>
                                    <h6 class="card-price text-center"><?php echo $subs[2]->price; ?> CHF<span class="period">/mois</span></h6>
                                    <hr>
                                    <ul class="fa-ul">
                                        <li><span class="fa-li"><i class="fas fa-check"></i></span><strong>PACK <?php echo $subs[0]->name; ?> (inclus)</strong></li>
                                        <li><span class="fa-li"><i class="fas fa-check"></i></span><strong>PACK <?php echo $subs[1]->name; ?> (inclus)</strong></li>
                                        <li><span class="fa-li"><i class="fas fa-check"></i></span><strong>Plan de table graphique</strong></li>
                                        <li><span class="fa-li"><i class="fas fa-check"></i></span>Gestion avancée des réservations</li>
                                        <li><span class="fa-li"><i class="fas fa-check"></i></span>Gestion avancée des horaires</li>
                                        <li><span class="fa-li"><i class="fas fa-check"></i></span>Gestion avancée des employés</li>
                                        <li><span class="fa-li"><i class="fas fa-check"></i></span>Gestion avancée des étages, zones et fournitures</li>
                                    </ul>
                                    <a href="payment.php?subscription=<?php echo $subs[2]->id; ?>" class="btn btn-block btn-primary text-uppercase">Je prend FULL</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

             

    </main>

    <!-- SCRIPTS -->
    <!-- Global Required Scripts Start -->
    <script src="./style/assets/js/jquery-3.3.1.min.js"></script>
    <script src="./style/assets/js/popper.min.js"></script>
    <script src="./style/assets/js/bootstrap.min.js"></script>
    <script src="./style/assets/js/perfect-scrollbar.js"> </script>
    <script src="./style/assets/js/jquery-ui.min.js"> </script>
    <!-- Global Required Scripts End -->

    <!-- Costic core JavaScript -->
    <script src="./style/assets/js/framework.js"></script>

    <script src="./style/assets/js/custom/login.js"></script>

</body>

</html>