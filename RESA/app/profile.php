<?php
  include "./assets/php/vars.php";
  include "./assets/php/images.php";

  session_start();

  if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    $img = GetImage($path."images/get/?user&id=".$user->id);
   
    $managedEtablishements = json_decode(file_get_contents($path."etablishment/get/?manager&iduser=".$user->id));
    $_SESSION['managed'] = $managedEtablishements;
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

    <!-- Main Content -->
    <main class="body-content">

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
                    <?php if(count($managedEtablishements) > 0): ?>
                        <li role="presentation"><a href="#managedEtablishements" aria-controls="managedEtablishements" role="tab" data-toggle="tab"> Mes etablissements </a></li>
                    <?php endif; ?>
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
                                        <li role="presentation"><a href="#creationEtablissement"
                                                aria-controls="creationEtablissement" role="tab"
                                                data-toggle="tab">Création réstaurant</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active show fade in" id="reservations">
                                            <h1>ICI VONT S'AFFICHER LES RESERVATIONS</h1>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="changemenetpdp">
                                            <h1>ICI VA ETRE UN FORMULAIRE POUR CHANGER LA PHOTO DE PROFIL</h1>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="creationEtablissement">
                                            <div class="col-md-12 col-sm-12">
                                                <h6 class="section-title">Vous êtes sur le point de créer un nouvel
                                                    établissement dans le groupe de RESA</h6>
                                                <button class="btn btn-primary" data-toggle="modal"
                                                    data-target="#createEtablishment"> Créer </button>
                                            </div>

                                            <div class="modal fade" id="createEtablishment" tabindex="-1" role="dialog"
                                                aria-labelledby="createEtablishment">
                                                <div class="modal-dialog modal-dialog-centered modal-min"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span></button>
                                                            <h1>Création d'un établissement RESA</h1>
                                                            <form
                                                                action="<?php echo $path."etablishment/create/form/"; ?>"
                                                                method="post" enctype="multipart/form-data"
                                                                id="creationEtablissement">

                                                                <div class="ms-form-group">
                                                                    <input type="text"
                                                                        placeholder="Nom de l'établissement"
                                                                        class="form-control" name="name" value=""
                                                                        required>
                                                                </div>

                                                                <div class="ms-form-group">
                                                                    <input type="text"
                                                                        placeholder="Adresse complète (Chemin de l'exemple 12, 1200 Genève)"
                                                                        class="form-control" name="adress" value=""
                                                                        required>
                                                                </div>

                                                                <div class="ms-form-group">
                                                                    <input type="text" placeholder="Numéro de téléphone"
                                                                        class="form-control" name="phone" value=""
                                                                        required>
                                                                </div>

                                                                <div class="ms-form-group">
                                                                    <input type="email" placeholder="Email"
                                                                        class="form-control" name="email" value=""
                                                                        required>
                                                                </div>

                                                                <div class="ms-form-group">
                                                                    <input type="file" name="photos[]" id="photos"
                                                                        multiple required>
                                                                </div>

                                                                <input type="text" name="user" id="user"
                                                                    value="<?php echo $user->id ?>" hidden>
                                                                <input type="submit" class="btn btn-primary shadow-none"
                                                                    value="Créer" name="submitNewEtablishement">
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
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

                <?php if(count($managedEtablishements) > 0): ?>
                    <div class="tab-pane" id="managedEtablishements">
                        <div class="col-md-12">
                            <div class="ms-panel">
                                <div class="ms-panel-body">
                                    <h2 class="section-title">Mes etablissements (mes droits de manager)</h2>
                                    <div class="row">
                                        <?php 
                                            foreach($managedEtablishements as $managed): 
                                            $img = GetImage($path."images/get/?etablishment&id=".$managed->id);
                                        ?>
                                            
                                            <div class="col-xl-4 col-md-6 col-sm-12">
                                                <a href="<?php echo "./etablishment-manager.php?id=".$managed->id;?>">
                                                    <div class="media ms-profile-experience">
                                                        <div class="mr-2 align-self-center">
                                                            <img src="<?php echo $img[0]->full_path ?>" class="ms-img-round ms-img-small" alt="people">
                                                        </div>
                                                        <div class="media-body">
                                                            <h4><?php echo $managed->name ?></h4>
                                                            <p><?php echo $managed->address ?></p>
                                                            <p><?php echo $managed->phone ?></p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>            
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