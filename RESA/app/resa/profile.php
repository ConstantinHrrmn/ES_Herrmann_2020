<?php
  include "../vars.php";
  include "./assets/php/images.php";

  session_start();

  if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    $img = GetImage($path."images/get/?user&id=".$user->id);
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
    <title><?php echo "Votre compte (".$user->first_name." ".$user->last_name.")" ?></title>
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

            <div class="ms-profile-overview">
                <div class="ms-profile-cover">
                    <img class="ms-profile-img" src="<?php echo $img->full_path ?>" alt="people">
                    <div class="ms-profile-user-info">
                        <h1 class="ms-profile-username"><?php echo $user->first_name ?> <?php echo $user->last_name ?>
                        </h1>
                        <h2 class="ms-profile-role"></h2>
                    </div>
                </div>

                <ul class="ms-profile-navigation nav nav-tabs tabs-bordered" role="tablist">
                    <li role="presentation"><a href="#informations" aria-controls="informations" class="active" role="tab" data-toggle="tab"> Aperçu </a></li>
                    <li role="presentation"><a href="#reservationspassees" aria-controls="reservationspassees" role="tab" data-toggle="tab"> Réservations passées </a></li>
                    <li role="presentation"><a href="#modifer" aria-controls="modifer" role="tab" data-toggle="tab"> Modifier </a></li>
                </ul>

            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="informations">
                    <div class="row">

                        <div class="col-xl-6 col-md-12">
                            <div class="ms-panel ms-panel-fh">
                                <div class="ms-panel-body">
                                    <h2 class="section-title">Toutes les informations</h2>
                                    <table class="table ms-profile-information">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Nom complet</th>
                                                <td><?php echo $user->first_name." ".$user->last_name ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Téléphone</th>
                                                <td><?php echo $user->phone ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Email</th>
                                                <td><?php echo $user->email?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="ms-panel ms-panel-fh">
                                <div class="ms-panel-header">
                                    <h6>Liens rapides</h6>
                                </div>
                                <div class="ms-panel-body clearfix">

                                    <ul class="nav nav-tabs d-flex tabs-round has-gap nav-justified mb-4"
                                        role="tablist">
                                        <li role="presentation"><a href="#reservations" aria-controls="reservations"
                                                class="active" role="tab" data-toggle="tab">Réservations</a></li>
                                        <li role="presentation"><a href="#changemenetpdp" aria-controls="changemenetpdp"
                                                role="tab" data-toggle="tab">Changer photo de profil</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active show fade in" id="reservations">
                                            <h1>ICI VONT S'AFFICHER LES RESERVATIONS</h1>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="changemenetpdp">
                                            <h1>ICI VA ETRE UN FORMULAIRE POUR CHANGER LA PHOTO DE PROFIL</h1>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="reservationspassees">
                    <div class="col-md-12">
                        <div class="ms-panel">
                            <div class="ms-panel-body">
                                <h1>Les réservations passées</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="modifer">
                <div class="col-md-12">
                        <div class="ms-panel">
                            <div class="ms-panel-body">
                                <h1>Modifier le compte</h1>
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