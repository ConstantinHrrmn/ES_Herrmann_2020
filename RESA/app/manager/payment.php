<?php

include "../vars.php";
+
session_start();

if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    if(isset($_GET['subscription'])){
        $link = $path."etablishment/subscriptions/?id=".$_GET['subscription'];
        $data = json_decode(file_get_contents($link));
        if(!$data){
            header("Location: ./newestablishment.php");
            exit();
        }
    }else{
        header("Location: ./newestablishment.php");
        exit();
    }

}
else{
    header("Location: ./login.php");
    exit();
}

if(isset($_POST['free'])){
    header("Location: ./createestablishment.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login</title>
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
    <?php
        function ShowModal($title, $message, $link, $end){
            echo '<script>
            $(document).ready(function(){
                $("#result").modal(\'show\');
                $("#resultmessage").text(\''.$title.'\');
                $("#message").text(\''.$message.'\');
                $("#resultlink").text(\''.$end.'\');
                $("#resultlink").attr("href", \''.$link.'\');
            });
        </script>';
        }
        
        if(isset($_POST['valider'])){
            $number = $_POST['number'];
            $cvc = $_POST['cvc'];
        
            if(strlen($number) == 16 && is_numeric($number) && strlen($cvc) == 3 && is_numeric($cvc)){
                echo "MAMAN";
                ShowModal('SUPER !', 'Vous pouvez maintenant créer votre établissement', "createestablishment.php", "C`est parti !");
            }else{
                ShowModal('Mince...', 'Il dois y avoir une erreur dans les données saisies', "", "je recommence");
            }
        }
    ?>
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

        <!-- Body Content Wrapper -->
        <div class="ms-content-wrapper ms-auth">

            <div class="container">
                <div class="ms-auth-form">

                    <?php if($data->id > 1):?>
                    <form class="needs-validation" novalidate="" id="loginForm" method="POST" action="#">
                        <h1>Paiement</h1>
                        <p>Veuillez entrer vos coordonnées afin de continuer</p>

                        <div class="mb-4">
                            <div class="card" style="text-align: center;">
                                <p>Abonnement</p>
                                <h5><?php echo $data->name; ?></h5>
                                <p><?php echo $data->price; ?> CHF / mois</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="input-group">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Titulaire de la carte" required="">
                                <div class="invalid-feedback">
                                    Veuillez entrer un nom valide
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="input-group">
                                <input type="text" class="form-control" id="number" name="number"
                                    placeholder="Numéro de carte" required="">
                                <div class="invalid-feedback">
                                    Veuillez entrer un numero valid
                                </div>
                            </div>
                        </div>

                        <div class='mb-3 card'>
                            <input autocomplete='off' class='form-control card-cvc' placeholder='CVC' size='4'
                                type='text' name="cvc">
                        </div>
                        <div class='mb-3'>
                            <select name="month" id="month" class="form-control">
                                <?php for($m = 1; $m < 13; $m++):?>
                                <option value="<?php echo $m; ?>"><?php echo $m; ?></option>
                                <?php endfor; ?>
                            </select>

                        </div>
                        <div class='mb-3'>
                            <select name="month" id="month" class="form-control">
                                <?php for($m = 2020; $m < 2060; $m++):?>
                                <option value="<?php echo $m; ?>"><?php echo $m; ?></option>
                                <?php endfor; ?>
                            </select>

                        </div>

                        <input type="submit" class="btn btn-primary mt-4 d-block w-100" id="valider" name="valider"
                            value="Valider">


                    </form>

                    <?php else: ?>

                    <form class="needs-validation" novalidate="" id="loginForm" method="POST" action="#">
                        <h1>Paiement</h1>
                        <p>Veuillez entrer vos coordonnées afin de continuer</p>

                        <div class="mb-4">
                            <div class="card" style="text-align: center;">
                                <p>Abonnement</p>
                                <h5><?php echo $data->name; ?></h5>
                                <p><?php echo $data->price; ?> CHF / mois</p>
                            </div>
                        </div>


                        <input type="submit" class="btn btn-primary mt-4 d-block w-100" id="free" name="free"
                            value="Valider">

                    </form>

                    <?php endif; ?>

                </div>
            </div>

            <div class="modal fade" id="result" tabindex="-1" role="dialog" aria-labelledby="result">
                <div class="modal-dialog modal-dialog-centered modal-min" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>

                            <h1 id="resultmessage">MESSAGE</h1>
                            <p id="message"></p>

                            <a href="index.php" id="resultlink" class="btn btn-primary">SUPER</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>


</body>

</html>