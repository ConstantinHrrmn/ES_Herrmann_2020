<?php
  include "../../vars.php";
  include '../style/assets/php/images.php';

  session_start();

  function Ismanaged($etab, $user, $pathToAPI){
    $link = $pathToAPI."user/get?u=$user&e=$etab";
    $valid = json_decode(file_get_contents($link));

    return $valid;
  }

  if(isset($_SESSION['etab'])){
    if(isset($_SESSION['user'])){
      $user = $_SESSION['user'];
      $img = GetImage($path."images/get/?user&id=".$user->id);
      $id = $_SESSION['etab']->id;

      if(Ismanaged($id, $user->id, $path)){

        $etablishement = json_decode(file_get_contents($path."etablishment/get/?id=".$id));

        $schudle = json_decode(file_get_contents($path."etablishment/schudle/get?id=".$id));

        $floorsJson = file_get_contents($path."etablishment/floor/get/?id=".$id);

        if($floorsJson != "[]")
          $floors = get_object_vars(json_decode($floorsJson));
        else
          $floors = null;
    
      }
    }else{
      $user = null;
      $img = null;
    }
  }
  else{
    //header("Location: ./index.php");
    //exit();
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
                <div class="col-xl-12 col-md-12">
                    <div class="ms-panel ms-panel-fh">
                        <div class="ms-panel-body">
                            <a href="../sender.php" class="btn btn-primary" style="margin: 0">Retour</a>
                        </div>
                    </div>
                </div>
            </div>
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


                <!-- Les fournitures du restaurant-->
                <div class="col-xl-6 col-md-12">
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