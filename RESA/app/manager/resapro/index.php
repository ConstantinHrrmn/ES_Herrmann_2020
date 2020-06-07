<?php

include "../../vars.php";
include "../style/assets/php/images.php";

session_start();

if(isset($_SESSION['etab']) && isset($_SESSION['user'])){
    $etab = $_SESSION['etab'];
    if($etab->subscription == 2){
        $schudles = json_decode(file_get_contents($path."etablishment/schudle/get/?id=".$etab->id));
        $menu = json_decode(file_get_contents($path."menu/get/?all&id=".$etab->id));
        $photos = json_decode(file_get_contents($path."images/get/?etablishment&id=".$etab->id));
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
            <div class="row">

                <div class="col-8">
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <div class="ms-panel ms-panel-fh">
                                <div class="ms-panel-header">
                                    <h6>Horaires</h6>
                                </div>
                                <div class="ms-panel-body">
                                    <div class="table-responsive">
                                        <table class="table thead-secondary">
                                            <thead>
                                                <tr>
                                                    <?php foreach($schudles as $schudle) :?>
                                                    <th scope="col" style="background-color: gray;">
                                                        <?php echo $schudle->dname; ?></th>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php foreach($schudles as $schudle) :
                                            if(isset($schudle->closed)) :?>
                                                    <th scope="col"><?php echo "FERMER"; ?></th>
                                                    <?php else: ?>
                                                    <th scope="col"><?php echo $schudle->sbegin." - ".$schudle->send; ?>
                                                    </th>
                                                    <?php endif;
                                            endforeach; ?>
                                                </tr>
                                                <tr>
                                                    <?php foreach($schudles as $schudle) :?>
                                                    <td><button style="color:black" data-toggle="modal" data-target="#modal-9">[modifier]</button></td>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal fade" id="modal-9" tabindex="-1" role="dialog"
                                        aria-labelledby="modal-9">
                                        <div class="modal-dialog modal-dialog-centered modal-min" role="document">
                                            <div class="modal-content">

                                                <div class="modal-body text-center">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><span
                                                            aria-hidden="true">&times;</span></button>
                                                    <i class="flaticon-tick-inside-circle d-block"></i>
                                                    <h1>Congragulations!</h1>
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut
                                                        vitae ultrices massa, non consectetur nunc. Nullam erat magna,
                                                        aliquet sed nibh non, pellentesque fermentum justo. Integer sed
                                                        imperdiet sapien, vel pulvinar tellus. Donec sed justo ac urna
                                                    </p>
                                                    <button type="button" class="btn btn-primary shadow-none">Get
                                                        Started</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <div class="ms-panel ms-panel-fh">
                                <div class="ms-panel-body">

                                    <div class="row">
                                        <div class="col-xl-6 col-md-12">
                                            <a class="btn btn-primary" style="width: 100%"
                                                href="../communes/reservations.php">Réservations</a>
                                        </div>
                                        <div class="col-xl-3 col-md-12">
                                            <a class="btn btn-secondary" style="width: 100%"
                                                href="../communes/clients.php">Clients</a>
                                        </div>
                                        <div class="col-xl-3 col-md-12">
                                            <a class="btn btn-secondary" style="width: 100%" href="#">Avis</a>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <?php if(count($menu->infos) > 0) : ?>

                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <div class="ms-panel ms-panel-fh">
                                <div class="ms-panel-header">
                                    <h6>Menus & plats - <?php echo $menu->infos[0]->name; ?></h6>
                                </div>
                                <div class="ms-panel-body">
                                    <div class="row">
                                        <?php foreach($menu->dishes as $dish):?>
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                            <div class="ms-card">
                                                <div class="ms-card-img">
                                                    <img src="https://via.placeholder.com/530x240" alt="card_img">
                                                </div>
                                                <div class="ms-card-body">

                                                    <div class="new">
                                                        <h6 class="mb-0"><?php echo $dish->dish_name; ?>
                                                        </h6>
                                                        <h6 class="ms-text-primary mb-0">
                                                            <?php echo $dish->dish_price;?> CHF
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php else: ?>

                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <div class="ms-panel ms-panel-fh">
                                <div class="ms-panel-header">
                                    <h6>Menus & plats</h6>
                                </div>
                                <div class="ms-panel-body">
                                    <button class="btn btn-secondary">Créer un menu</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php endif;?>

                </div>

                <div class="col-4">
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <div class="ms-panel ms-panel-fh">
                                <div class="ms-panel-header">
                                    <h6>Modifications</h6>
                                </div>
                                <div class="ms-panel-body">
                                    <div class="table-responsive">
                                        <button class="btn btn-secondary" style="width: 100%">Informations</button>
                                        <button class="btn btn-secondary" style="width: 100%">Widgets</button>
                                        <button class="btn btn-secondary" style="width: 100%">Suppression</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <div class="ms-panel ms-panel-fh">
                                <div class="ms-panel-header">
                                    <h6>Photos</h6>
                                </div>
                                <div class="ms-panel-body">
                                    <div class="row">

                                        <?php foreach($photos as $photo):?>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <div class="ms-card">
                                                <div class="ms-card-img">
                                                    <img src="<?php echo $photo->full_path?>" alt="card_img">
                                                </div>
                                                <a href="#" style="color:red;">Supprimer</a>
                                            </div>
                                        </div>

                                        <?php endforeach; ?>
                                    </div>
                                    <button class="btn btn-secondary" style="width: 100%;">Ajouter</button>
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