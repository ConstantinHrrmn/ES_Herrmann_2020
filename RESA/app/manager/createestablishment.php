<?php

include "../vars.php";
session_start();

function BackToSubs(){
    header("Location: ./subscriptions.php");
    exit();
}

if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    if(isset($_SESSION['subs'])){
        $subs = $_SESSION['subs'];

        $link = $path."country/?all";
        $countries = json_decode(file_get_contents($link));

    }else{
        BackToSubs();
    }
}
else{
    BackToSubs();
}

if(isset($_SESSION['etab'])){
     if($_SESSION != false){
         $sub = $_SESSION['subs'];
         if($subs == 1){
            header("Location: ./resablog/");
            exit();
         }else if($subs == 2){
            header("Location: ./resapro/");
            exit();
         } else if($subs == 2){
            header("Location: ./resafull/");
            exit();
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
    <title>Création</title>
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
        <div class="ms-content-wrapper">
            <div class="col-xl-12 col-md-12">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-header">
                        <h6>Création de l'établissement</h6>
                    </div>
                    <div class="ms-panel-body">
                        <form action="<?php echo $path."etablishment/create/form/"; ?>" method="post"
                            enctype="multipart/form-data" id="creationEtablissement" class="needs-validation clearfix"
                            novalidate>

                            <div class="form-row">

                                <!-- Nom -->
                                <div class="col-md-12 mb-3">
                                    <label for="valid1">Nom de l'établissement</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="valid1" name="name"
                                            placeholder="Nom de l'établissement" value="" required>
                                        <div class="valid-feedback">
                                            YES
                                        </div>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label for="valid2">Email de contact</label>
                                    <div class="input-group">
                                        <input type="email" class="form-control" id="valid2" name="email"
                                            placeholder="info@exemple.ch" value="" required>
                                        <div class="valid-feedback">
                                            YES
                                        </div>
                                    </div>
                                </div>

                                <!-- téléphone -->
                                <div class="col-md-6 mb-3">
                                    <label for="valid3">Téléphone</label>
                                    <div class="input-group">
                                        <input type="phone" class="form-control" id="valid3" name="phone"
                                            placeholder="0221234567" value="" required>
                                        <div class="valid-feedback">
                                            YES
                                        </div>
                                    </div>
                                </div>

                                <!-- Rue -->
                                <div class="col-md-6 mb-3">
                                    <label for="valid4">Rue</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="valid4" name="street"
                                            placeholder="Chemin de l'exemple 12" value="" required>
                                        <div class="valid-feedback">
                                            YES
                                        </div>
                                    </div>
                                </div>

                                <!-- NPA -->
                                <div class="col-md-2 mb-3">
                                    <label for="valid4">NPA</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="valid5" name="npa"
                                            placeholder="1206" value="" required>
                                        <div class="valid-feedback">
                                            YES
                                        </div>
                                    </div>
                                </div>

                                <!-- City -->
                                <div class="col-md-2 mb-3">
                                    <label for="valid4">City</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="valid5" name="city"
                                            placeholder="Genève" value="" required>
                                        <div class="valid-feedback">
                                            YES
                                        </div>
                                    </div>
                                </div>

                                <!-- Pays -->
                                <div class="col-md-2 mb-3">
                                    <label for="valid3">Pays</label>
                                    <div class="input-group">
                                        <select class="form-control" id="country" name="country">
                                            <?php foreach($countries as $country): ?>
                                            <option value="<?php echo $country->Id ?>">
                                                <?php echo $country->Name ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Images -->
                                <div class="col-md-12 mb-3">
                                    <label for="valid3">Images</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" multiple name="photos[]" id="photos">
                                    </div>
                                </div>

                                <!-- Bouton valider -->
                                <div class="col-md-12 mb-3">
                                    <div class="input-group">
                                        <input type="submit" class="btn btn-primary" id="validatedCustomFile"
                                            value="Créer">
                                    </div>
                                </div>


                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>