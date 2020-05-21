<?php
  include "../vars.php";
  include "./assets/php/images.php";

  session_start();

  if(isset($_GET['id'])){
      $link = $path."etablishment/get/?id=".$_GET['id'];
      $data = json_decode(file_get_contents($link));
      if($data == null){
          header("Location: ./index.php");
          exit();
      }else{
        $link_images = $path."images/get/?etablishment&id=".$data->id;
        $images = json_decode(file_get_contents($link_images));

        $_SESSION['selectedEtablissement'] = $data;
      }

  }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo "HOLLA"?></title>
    <!-- Iconic Fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./vendors/iconic-fonts/flat-icons/flaticon.css">
    <link href="./vendors/iconic-fonts/font-awesome/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery UI -->
    <link href="./assets/css/jquery-ui.min.css" rel="stylesheet">
    <!-- Costic styles -->
    <link href="./assets/css/style.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon.ico">

    <link href="./assets/css/custom.css" rel="stylesheet">
    <link href="./assets/css/calendar.css" rel="stylesheet">


</head>

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
    <?php include './assets/php/navbar.php'; ?>

    <!-- Main Content -->
    <main class="body-content">
        <!-- Navigation Bar -->
        <?php include './assets/php/topbar.php'; ?>

        <!-- Body Content Wrapper -->
        <div class="ms-content-wrapper">

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="ms-panel ms-panel-fh">
                        <div class="ms-panel-body">
                            <a href="index.php" class="btn btn-primary" style="margin: 0">Retour</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ms-profile-overview restaurant-banner-main">

                <div class="restaurant-banner" style="background-image: url(<?php echo $images[0]->full_path; ?>);">
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="informations">
                    <div class="row">
                        <div class="col-xl-6 col-md-12">
                            <div class="ms-panel ms-panel-fh">

                                <div class="ms-panel-body">
                                    <h1><?php echo $data->name; ?></h1>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-12">
                            <div class="ms-panel ms-panel-fh">
                                <div class="ms-panel-body">
                                    <h3>Phone : <?php echo $data->phone?></h3>

                                    <h3>Email : <?php echo $data->email?></h3>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-xl-6 col-md-12">
                            <div class="ms-panel ms-panel-fh">

                                <div class="ms-panel-body">
                                    <!-- Grid row -->
                                    <div class="gallery" id="gallery">

                                        <?php foreach($images as $image):?>
                                        <!-- Grid column -->
                                        <div class="mb-3 pics animation all 2">
                                            <img class="img-fluid zoom" src="<?php echo $image->full_path?>"
                                                alt="image du restaurant ">
                                        </div>
                                        <!-- Grid column -->
                                        <?php endforeach; ?>

                                    </div>
                                    <!-- Grid row -->
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-12">
                            <div class="ms-panel ms-panel-fh">
                                <?php if($data->subscription > 1):?>
                                <div class="ms-panel-body">
                                    <?php
                                    include './assets/php/calendar.php';
                                    
                                    $calendar = new Calendar($_GET['id']);
                                    
                                    echo $calendar->show();
                                    ?>
                                </div>
                                <?php else : ?>
                                <div class="ms-panel-body">
                                    <h5>Réservations par téléphone ou mail</h5>
                                    <a href="tel:<?php echo $data->phone; ?>" class="btn btn-primary">Appeler</a>
                                    <a href="mailto:<?php echo $data->email; ?>" class="btn btn-primary">Mail</a>
                                </div>
                                <?php endif; ?>
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

</body>

</html>