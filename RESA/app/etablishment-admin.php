<?php
  include "./assets/php/vars.php";
  include './assets/php/images.php';

  session_start();

  function Ismanaged($etablishements, $id){
    foreach($etablishements as $m){
      if($m->id == $id){
        return true;
      }
    }
    return false;
  }

  if(isset($_GET['id'])){
    if(isset($_SESSION['user'])){
      $user = $_SESSION['user'];
      $img = GetImage($path."images/get/?user&id=".$user->id);

      $id = $_GET['id'];
      $managed = $_SESSION['managed'];
      if(Ismanaged($managed, $id)){

        $etablishement = json_decode(file_get_contents($path."etablishment/get/?id=".$id));

        $schudle = json_decode(file_get_contents($path."etablishment/schudle/get?id=".$id));

        $floorsJson = file_get_contents($path."etablishment/floor/get/?id=".$id);

        if($floorsJson != "[]")
          $floors = get_object_vars(json_decode($floorsJson));
        else
          $floors = null;
    
      }else{
        header("Location: ./profile.php");
        exit(); 
      }
    }else{
      $user = null;
      $img = null;
    }
  }
  else{
    header("Location: ./index.php");
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

<body class="ms-body ms-aside-left-open ms-primary-theme">
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

        <div class="ms-content-wrapper">
            <div class="row">

                <div class="col-md-12">
                    <h1 class="db-header-title"><?php echo $etablishement->name; ?></h1>
                </div>

                <!-- Zones du restaurant-->

                <div class="col-xl-6 col-md-12">
                    <div class="ms-panel">
                        <div class="ms-panel-header">
                            <div class="d-flex justify-content-between">
                                <div class="align-self-center align-left">
                                    <h6>Les zones de mon réstaurant</h6>
                                </div>
                            </div>
                        </div>

                        <?php if($floors != null): ?>

                        <?php foreach($floors as $floor):?>

                        <div class="ms-panel-body">
                            <h4><?php echo $floor->name; ?> </h4>
                            <div class="table-responsive">
                                <?php if($floor->zones[0][0] != null): ?>
                                <table class="table table-hover">
                                    <tbody>
                                        <?php foreach($floor->zones as $zone):?>
                                        <tr>
                                            <td class="ms-table-f-w"><?php echo $zone[0] ?></td>
                                            <td><?php echo $zone[4]->places_total ?></td>
                                            <td><button class="btn-primary" data-toggle="modal"
                                                    data-target="#showZone<?php echo $zone[1] ?>"
                                                    style="height:50%">Horaires</button></td>
                                            <td><button class="btn-primary" data-toggle="modal"
                                                    data-target="#showFurnitures<?php echo $zone[1] ?>"
                                                    style="height:50%">Fournitures</button></td>
                                            <td>[Editer]</td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php endif; ?>
                                <button class="btn btn-primary" data-toggle="modal"
                                    data-target="#createEtablishment<?php echo $floor->id?>" style="height:50%">Ajouter
                                    une zone à <?php echo $floor->name;?></button>

                            </div>
                        </div>

                        <!-- Formulaire pour la création d'une zone sur un étage -->
                        <div class="modal fade" id="createEtablishment<?php echo $floor->id?>" tabindex="-1"
                            role="dialog" aria-labelledby="createEtablishment">
                            <div class="modal-dialog modal-dialog-centered modal-min" role="document">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h1>Création zone pour <?php echo $floor->name;?></h1>
                                        <form action="<?php echo $path."etablishment/floor/zone/create/form/"; ?>"
                                            method="post" enctype="multipart/form-data" id="creationEtablissement">

                                            <div class="ms-form-group">
                                                <input type="text" placeholder="Nom de la zone" class="form-control"
                                                    name="name" value="" required>
                                            </div>

                                            <input type="text" name="floor" id="floor" value="<?php echo $floor->id ?>"
                                                hidden>
                                            <input type="text" name="user" id="user" value="<?php echo $user->id ?>"
                                                hidden>
                                            <input type="submit" class="btn btn-primary shadow-none" value="Créer"
                                                name="submitNewEtablishement">
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <?php 
                        foreach($floor->zones as $zone):
                            $url = $path."etablishment/floor/zone/schedule/get?all&id=".$zone[1];
                            $schedules = json_decode(file_get_contents($url));

                            $url2 = $path."etablishment/floor/zone/furniture/get?zone&id=".$zone[1];
                            $furnitures = json_decode(file_get_contents($url2));
                        ?>

                        <!--Modal pour les horaires de la zones-->
                        <div class="modal fade" id="showZone<?php echo $zone[1] ?>" tabindex="-1" role="dialog"
                            aria-labelledby="createFloor">
                            <div class="modal-dialog modal-dialog-centered modal-min" role="document">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h1><?php echo $zone[0] ?></h1>
                                        <?php foreach($schedules as $s): ?>
                                        <p><?php echo $s->begin." - ".$s->end ?></p>
                                        <?php endforeach;?>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!--Modal pour les fournitures de la zones-->
                        <div class="modal fade" id="showFurnitures<?php echo $zone[1] ?>" tabindex="-1" role="dialog"
                            aria-labelledby="createFloor">
                            <div class="modal-dialog modal-dialog-centered modal-min" role="document">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <?php if(count($furnitures) > 1):?>
                                        <table class="table table-hover thead-primary">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Nom</th>
                                                    <th scope="col">Couleur</th>
                                                    <th scope="col">Places</th>
                                                    <th scope="col">Forme</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Modifier</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($furnitures as $f):?>
                                                <tr>
                                                    <th scope="row"><?php echo $f->fname ?></th>
                                                    <td><?php echo $f->fcolor ?></td>
                                                    <td><?php echo $f->fplaces ?></td>
                                                    <td><?php echo $f->fsname ?></td>
                                                    <td><?php echo $f->ftname ?></td>
                                                    <th><button class="btn-primary shadow-none">EDIT</button></th>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <?php else: ?>
                                        <h1>Aucune fourniture</h1>
                                        <button class="btn-primary shadow-none">Créer</button>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>


                        <?php endforeach; ?>

                        <?php endif;?>



                        <!-- Création d'un étage-->
                        <div class="ms-panel-body">
                            <button class="btn btn-primary" data-toggle="modal"
                                data-target="#createFloor<?php echo $etablishement->id?>" style="height:50%">Créer un
                                étage</button>

                            <!-- Formulaire pour la création d'une zone sur un étage -->
                            <div class="modal fade" id="createFloor<?php echo $etablishement->id?>" tabindex="-1"
                                role="dialog" aria-labelledby="createFloor">
                                <div class="modal-dialog modal-dialog-centered modal-min" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body text-center">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h1>Création d'un étage</h1>
                                            <form action="<?php echo $path."etablishment/floor/create/form/"; ?>"
                                                method="post" enctype="multipart/form-data" id="creationEtablissement">

                                                <div class="ms-form-group">
                                                    <input type="text" placeholder="Nom de l'étage'"
                                                        class="form-control" name="name" value="" required>
                                                </div>

                                                <input type="text" name="etablishment" id="etablishment"
                                                    value="<?php echo $etablishement->id ?>" hidden>
                                                <input type="text" name="user" id="user" value="<?php echo $user->id ?>"
                                                    hidden>
                                                <input type="submit" class="btn btn-primary shadow-none" value="Créer"
                                                    name="submitNewEtablishement">
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>


                <div class="col-xl-5 col-md-12">
                    <!-- Horaires de la semaine -->
                    <div class="ms-panel ms-widget ms-crypto-widget">
                        <div class="ms-panel-header">
                            <h6>Horaires de la semaine</h6>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover thead-light">
                                <thead>

                                    <tr>
                                        <?php foreach($schudle as $s): ?>
                                        <th scope="col"><?php echo $s->dname?></th>
                                        <?php endforeach; ?>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr>
                                        <?php 
                                        foreach($schudle as $s): 
                                        ?>
                                        <td><?php echo isset($s->closed) ? "FERMER" : $s->sbegin." - ".$s->send; ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr>
                                        <?php foreach($schudle as $s): ?>
                                        <td><button class="btn-primary" data-toggle="modal" data-target="" style="height:50%">Modifier</button></td>
                                        <?php endforeach; ?>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>

                    <!-- Réservations de la semaine -->
                    <div class="ms-panel ms-widget ms-crypto-widget">
                        <div class="ms-panel-header">
                            <h6>Réservations de la semaine</h6>
                        </div>
                        <div class="ms-panel-body p-0">
                            <ul class="nav nav-tabs nav-justified has-gap px-4 pt-4" role="tablist">
                                <li role="presentation" class="fs-12"><a href="#lun" aria-controls="lun"
                                        class="active show" role="tab" data-toggle="tab"> Lun </a></li>
                                <li role="presentation" class="fs-12"><a href="#mar" aria-controls="mar" role="tab"
                                        data-toggle="tab"> Mar </a></li>
                                <li role="presentation" class="fs-12"><a href="#mer" aria-controls="mer" role="tab"
                                        data-toggle="tab"> Mer </a></li>
                                <li role="presentation" class="fs-12"><a href="#jeu" aria-controls="jeu" role="tab"
                                        data-toggle="tab"> Jeu </a></li>
                                <li role="presentation" class="fs-12"><a href="#ven" aria-controls="ven" role="tab"
                                        data-toggle="tab"> Ven </a></li>
                                <li role="presentation" class="fs-12"><a href="#sam" aria-controls="sam" role="tab"
                                        data-toggle="tab"> Sam </a></li>
                                <li role="presentation" class="fs-12"><a href="#dim" aria-controls="dim" role="tab"
                                        data-toggle="tab"> Dim </a></li>
                            </ul>
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active show fade in" id="lun">
                                    <div class="table-responsive">
                                        <table class="table table-hover thead-light">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Nom</th>
                                                    <th scope="col">nombre personnes</th>
                                                    <th scope="col">Horaire</th>
                                                    <th scope="col">N° table</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Hunger House</td>
                                                    <td>8528</td>
                                                    <td class="ms-text-success">+17.24%</td>
                                                    <td>7.65%</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="mar">
                                    <div class="table-responsive">
                                        <table class="table table-hover thead-light">

                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="mer">
                                    <div class="table-responsive">
                                        <table class="table table-hover thead-light">

                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="jeu">
                                    <div class="table-responsive">
                                        <table class="table table-hover thead-light">

                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="ven">
                                    <div class="table-responsive">
                                        <table class="table table-hover thead-light">

                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="sam">
                                    <div class="table-responsive">
                                        <table class="table table-hover thead-light">

                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="dim">
                                    <div class="table-responsive">
                                        <table class="table table-hover thead-light">

                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <!-- Les fournitures du restaurant-->
                <div class="col-xl-8 col-md-12">
                    <div class="ms-panel ms-panel-fh">
                        <div class="ms-panel-header">
                            <h6>Fournitures</h6>
                        </div>
                        <?php 
                            $url3 = $path."etablishment/floor/zone/furniture/get?etablishment&id=".$id;
                            $fournitures = json_decode(file_get_contents($url3));
                            if(count($fournitures) > 0):
                        ?>
                        <div class="ms-panel-body">
                            <div class="table-responsive">
                                <table class="table thead-primary">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Couleur</th>
                                            <th scope="col">Forme</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Places</th>
                                            <th scope="col">Zone attribuée</th>
                                            <th scope="col">Modifier</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($fournitures as $f): ?>
                                        <tr>
                                            <th scope="row"><?php echo $f->fname; ?></th>
                                            <td><?php echo $f->fcolor; ?></td>
                                            <td><?php echo $f->fsname; ?></td>
                                            <td><?php echo $f->ftname; ?></td>
                                            <td><?php echo $f->fplaces; ?></td>
                                            <td><?php echo $f->zname == null ? "<button class=\"btn-primary shadow-none\">Attribuer</button>" : $f->zname; ?>
                                            </td>
                                            <td><button class="btn-primary">modifier</button></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-primary shadow-none" data-toggle="modal"
                                data-target="#createFurniture" style="height:50%">Ajouter</button>
                        </div>
                        <?php else: ?>
                        <div class="ms-panel-body">
                            <button class="btn btn-primary shadow-none" data-toggle="modal"
                                data-target="#createFurniture" style="height:50%">Créer une fourniture</button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Formulaire pour la création d'une zone sur un étage -->
                <div class="modal fade" id="createFurniture" tabindex="-1" role="dialog" aria-labelledby="createFloor">
                    <div class="modal-dialog modal-dialog-centered modal-min" role="document">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h1>Création d'une fourniture</h1>
                                <form action="<?php echo $path."etablishment/floor/create/form/"; ?>" method="post"
                                    enctype="multipart/form-data" id="creationEtablissement">

                                    <div class="ms-form-group">
                                        <input type="text" placeholder="Nom de la fourniture" class="form-control"
                                            name="name" value="" required>
                                    </div>

                                    <input type="text" name="user" id="user" value="<?php echo $user->id ?>" hidden>
                                    <input type="submit" class="btn btn-primary shadow-none" value="Créer"
                                        name="submitnewfurniture">
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Recent Orders Requested -->
                <div class="col-xl-4 col-md-12">
                    <div class="ms-panel ms-panel-fh">
                        <div class="ms-panel-header">
                            <div class="d-flex justify-content-between">
                                <div class="ms-header-text">
                                    <h6>Order Timing Chart</h6>
                                </div>
                            </div>

                        </div>
                        <div class="ms-panel-body pt-0">
                            <div class="d-flex justify-content-between ms-graph-meta">
                                <ul class="ms-list-flex mt-3 mb-5">
                                    <li>
                                        <span>Total Order</span>
                                        <h3 class="ms-count">703,49</h3>
                                    </li>
                                    <li>
                                        <span>New Order</span>
                                        <h3 class="ms-count">95,038</h3>
                                    </li>
                                    <li>
                                        <span>Repeat Order</span>
                                        <h3 class="ms-count">28,387</h3>
                                    </li>
                                    <li>
                                        <span>Cancel Order</span>
                                        <h3 class="ms-count">260</h3>
                                    </li>
                                </ul>
                            </div>
                            <canvas id="youtube-subscribers"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- SCRIPTS -->
    <!-- Global Required Scripts Start -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/perfect-scrollbar.js">
    </script>
    <script src="assets/js/jquery-ui.min.js">
    </script>
    <!-- Global Required Scripts End -->
    <!-- Page Specific Scripts Start -->
    <script src="assets/js/Chart.bundle.min.js">
    </script>
    <script src="assets/js/widgets.js"> </script>
    <script src="assets/js/clients.js">
    </script>
    <script src="assets/js/Chart.Financial.js">
    </script>
    <script src="assets/js/d3.v3.min.js">
    </script>
    <script src="assets/js/topojson.v1.min.js">
    </script>
    <script src="assets/js/datatables.min.js">
    </script>
    <script src="assets/js/data-tables.js">
    </script>
    <!-- Page Specific Scripts Finish -->
    <!-- Costic core JavaScript -->
    <script src="assets/js/framework.js"></script>
    <!-- Settings -->
    <script src="assets/js/settings.js"></script>
</body>

</html>