<?php 
  include "../vars.php";
  include "./assets/php/images.php";

  session_start();

  $link = $path."/etablishment/get/";

  $json = file_get_contents($link);
  $etablishments = json_decode($json);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>RESA Bienvenue</title>
    <!-- Iconic Fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./vendors/iconic-fonts/flat-icons/flaticon.css">
    <link href="./vendors/iconic-fonts/font-awesome/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/css/custom.css" rel="stylesheet">
    <!-- jQuery UI -->
    <link href="./assets/css/jquery-ui.min.css" rel="stylesheet">
    <!-- Costic styles -->
    <link href="./assets/css/style.css" rel="stylesheet">
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
    <?php include './assets/php/navbar.php'; ?>


    <!-- Main Content -->
    <main class="body-content">
        <!-- Navigation Bar -->
        <?php include './assets/php/topbar.php'; ?>
        <!-- Body Content Wrapper -->
        <div class="ms-content-wrapper">
            <div class="row">

                <div class="col-md-12">

                    <div class="ms-panel">
                        <div class="ms-panel-header">
                            <h6>Tous les réstaurants</h6>
                        </div>
                        <div class="ms-panel-body">
                            <input class="form-control" id="filter" type="text" placeholder="Rechercher un restaurant">
                        </div>
                        <div class="ms-panel-body" id="parent">

                            <div class="ms-portfolio card-columns">

                                <?php foreach($etablishments as $etab=>$val):?>

                                <?php 
                                    $img = GetImage($path."images/get/?etablishment&id=".$val->id);
                                  ?>
                                <?php if($val->open != null):?>

                                <a class="card ms-portfolio-item open" style="display: inline-block"  href="<?php echo "./etablissement.php?id=".$val->id;?>">
                                    <img class="" style="width: 100%; background-size: cover;"
                                        src="<?php echo count($img) < 1 ? $path."images/background/?no_image" : $img[0]->full_path ?>"
                                        alt="photo du restaurant : <?php echo $val->name ?>">
                                    <div class="ms-portfolio-item-content">
                                        <h3 style="color:white" class="name">
                                            <?php echo $val->name ?></h3>
                                    </div>
                                </a>
                                <?php else:?>
                                <div class="card ms-portfolio-item closed" style="display: inline-block">
                                    <img class="" style="width: 100%; background-size: cover;"
                                        src="<?php echo count($img) < 1 ? $path."images/background/?no_image" : $img[0]->full_path ?>"
                                        alt="photo du restaurant : <?php echo $val->name ?>">
                                    <div class="ms-portfolio-item-content">
                                        <h1 style="color:red">FERME</h1>
                                        <h3 style="color:white" class="name"><?php echo $val->name ?></h3>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </main>

    <!-- SCRIPTS -->
    <!-- Global Required Scripts Start -->
    <script src="./assets/js/jquery-3.3.1.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/js/perfect-scrollbar.js"> </script>
    <script src="./assets/js/jquery-ui.min.js"> </script>
    <!-- Global Required Scripts End -->

    <!-- Costic core JavaScript -->
    <script src="./assets/js/framework.js"></script>
    <script>
    var $search = $("#filter").on('input', function() {
        var matcher = new RegExp($(this).val(), 'gi');
        $('.card').show().not(function() {
            return matcher.test($(this).find('.name').text())
        }).hide();
    })
    </script>
</body>

</html>