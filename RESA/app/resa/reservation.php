<?php
  include "../vars.php";
  include "./assets/php/images.php";

  session_start();
    if(isset($_SESSION['selectedEtablissement'])){
        $etablissement = $_SESSION['selectedEtablissement'];
        if(isset($_GET['day']) && isset($_GET['month']) && isset($_GET['year'])){
            $day = $_GET['day'];
            $month = $_GET['month'];
            $year = $_GET['year'];
            $date = $year."-".$month."-".$day;
        }
        //unset($_SESSION['selectedEtablissement']);
        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            $link = $path."etablishment/schudle/get/?dayschudle&idEtab=".$etablissement->id."&date=".$date;
            $schudles = json_decode(file_get_contents($link));
        }else{
            $_SESSION['returnlink'] = "reservation.php?id=".$etablissement->id."&day=".$day."&month=".$month."&year=".$year;
            header("Location: fast_login.php");
            exit();
        }
    }else{
        header("Location: index.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo "Réserver pour le"?></title>
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
                            <a href="<?php echo "./etablissement.php?id=".$etablissement->id; ?>"
                                class="btn btn-primary" style="margin: 0">Retour</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="informations">
                    <div class="row">
                        <div class="col-xl-6 col-md-12">
                            <div class="ms-panel ms-panel-fh">

                                <div class="ms-panel-body">
                                    <h1>Date : <?php echo $day."/".$month."/".$year; ?></h1>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-12">
                            <div class="ms-panel ms-panel-fh">
                                <div class="ms-panel-body">
                                    <h3>Phone : <?php echo $etablissement->phone?></h3>

                                    <h3>Email : <?php echo $etablissement->email?></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 col-md-12">
                            <div class="ms-panel ms-panel-fh">
                                <div class="ms-panel-body">
                                    <h5>Nombres de personnes</h5>
                                    <div class="row">
                                        <?php for($i = 1; $i <= 9; $i++):?>
                                        <div class="col-md-2  col-ms-3 col-m-3">
                                            <button class="col-md-12 btn btn-primary"
                                                onclick="ChoosePeople(<?php echo $i ?>)">
                                                <?php echo $i ?>

                                            </button>
                                        </div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-12">
                            <div class="ms-panel ms-panel-fh">
                                <div class="ms-panel-body">
                                    <h5>Moment de la journée</h5>
                                    <div class="row">
                                        
                                        <?php 
                                        $morning = true;
                                        $launch = true;
                                        $dinner =true;
                                        foreach($schudles as $s):
                                            $begin = explode(':', $s->begin);
                                            $end = explode(':', $s->end);
                                        ?>

                                        <?php if($end[0] >= 11):?>
                                            <div class="col-md-4">
                                                <button class="col-md-12 btn btn-primary">
                                                    MATIN
                                                </button>
                                            </div>
                                        <?php endif; ?>

                                        <?php if($end[0] >= 15):?>
                                            <div class="col-md-4">
                                                <button class="col-md-12 btn btn-primary">
                                                    MIDI
                                                </button>
                                            </div>
                                        <?php endif; ?>

                                        <?php if($end[0] >= 23):?>
                                            <div class="col-md-4">
                                                <button class="col-md-12 btn btn-primary">
                                                    SOIR
                                                </button>
                                            </div>
                                        <?php endif; ?>


                                        <?php endforeach; ?>
                                    </div>
                                </div>
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