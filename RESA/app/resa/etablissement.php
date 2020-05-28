<?php
  include "../vars.php";
  include "./assets/php/images.php";

  session_start();

  if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
  }else{
      $user=null;
  }

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

  if(isset($_POST['rechercher'])){
    $date = null;
    $heure = null;
    $amount = null;
    $duration = 0;

    if(strlen($_POST['date']) > 0){
        $tmp = $_POST['date'];
        $tmp = explode("/", $tmp);

        $m = $tmp[0];
        $d = $tmp[1];
        $y = $tmp[2];

        $date = $y."-".$m."-".$d;
    }

    if(strlen($_POST['hour']) > 0){
        $heure = $_POST['hour'];
        $tmp = explode(":", $heure);
        $duration = ($tmp[0] >= 6 && $tmp[0] < 11) ? 1800 : (($tmp[0] > 11 && $tmp[0] < 18) ? 3600 : (($tmp[0] >= 18 && $tmp[0] < 23) ? 7200 : 5000));
    }

    if(strlen($_POST['amount']) > 0){
        $amount = $_POST['amount'];
    }

    if($date == null || $heure == null || $amount == null){

    }else{
        $link = $path."reservation/get/?full&arrival=".$heure."&duration=".$duration."&date=".$date."&etab=".$data->id;
        $avaible = json_decode(file_get_contents($link));
        if($avaible->avaible == null || $avaible->avaible < $amount){
            echo "plus de place";
        }else{
            echo "il y a de la place !";
        }
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

    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />


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
                                    <div class="bootstrap-iso">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">

                                                    <?php if($user == null):?>
                                                    <h5>Vouzs devez vous connecter afin de réserver</h5>
                                                    <?php $_SESSION['returnlink'] = "etablissement.php?id=".$data->id; ?>
                                                    <a href="fast_login.php" class="btn btn-primary">Connexion</a>
                                                    <?php else : ?>
                                                    <!-- Form code begins -->
                                                    <form method="post" action="#">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-12 col-sm-6 col-xs-12">

                                                                    <!-- Date input -->
                                                                    <label class="control-label" for="date">Date</label>
                                                                    <input class="form-control" id="date" name="date"
                                                                        placeholder="MM/DD/YYY" type="text"
                                                                        onchange="DateChoosen(<?php echo $data->id?>)" />
                                                                </div>
                                                                <div class="col-md-6 col-sm-6 col-xs-12" id="hourdiv"
                                                                    style="display:none">
                                                                        <label for="hour">Heure</label>
                                                                        <select class="form-control" id="hour" name="hour">
                                                                        </select>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6 col-xs-12" id="close"
                                                                    style="display:none">
                                                                        <h3>FERMER</h3>
                                                                </div>

                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                    <label for="amount">Personnes</label>
                                                                    <select class="form-control" id="amount" name="amount">
                                                                        <?php for($i = 1; $i < 12; $i++): ?>
                                                                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                                        <?php endfor; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <!-- Submit button -->
                                                            <button class="btn btn-primary " name="rechercher"
                                                                type="submit">Rechercher</button>
                                                        </div>
                                                    </form>
                                                    <!-- Form code ends -->
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    <script src="./assets/js/reservation.js"></script>
</body>

</html>