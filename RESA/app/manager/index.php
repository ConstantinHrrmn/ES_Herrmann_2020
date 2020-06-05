<?php
  include "../vars.php";

  // On lance la session afin de récupérer les variables
  session_start();

  if(isset($_POST['connexion'])){
    if(isset($_POST['password'])){
      $password = hash('sha256', $_POST['password']);
      if(isset($_POST['username'])){
        $username = $_POST['username'];
        if(isset($_POST['nom'])){
          $nom = $_POST['nom'];

         
          $queryData = array(
            'e' => $username,
            'p' => $password,
            'n' => $nom
          );
  
          $link = $path."user/get/"."?".http_build_query($queryData);
          $json = file_get_contents($link);
          $data = json_decode($json);

          if($data != false){
            $_SESSION['sender'] = $data->id;

            $queryData = array(
              'email' => $username,
              'password' => $password
            );
    
            $link = $path."user/get/"."?login&".http_build_query($queryData);
            $json = file_get_contents($link);
            $data = json_decode($json);
    
            if($data != false){
              $_SESSION['user'] = $data;

              $link = $path."etablishment/get/?id=".$_SESSION['sender'];
              $establishment = json_decode(file_get_contents($link));

              if($establishment != false){
                $_SESSION['etab'] = $establishment;
                header("Location: ./sender.php");
                exit();
              }     
            }
          }
        }
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
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon.ico">

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
        <!-- Body Content Wrapper -->
        <div class="ms-content-wrapper ms-auth">

            <div class="container">
                <div class="ms-auth-form">

                    <form class="needs-validation" novalidate="" id="loginForm" method="POST" action="#">
                        <h1>Connexion manager</h1>
                        <p>Veuillez entrer votre mail et votre mot de passe ainsi que le nom du restaurant pour
                            continuer</p>

                        <div class="mb-3">
                            <label for="validationCustom08">Nom de l'établissement</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="nom" name="nom"
                                    placeholder="Nom du restaurant" required="">
                                <div class="invalid-feedback">
                                    Veuillez entrer le nom du restaurant
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="validationCustom08">Email</label>
                            <div class="input-group">
                                <input type="email" class="form-control" id="username" name="username"
                                    placeholder="Email Address" required="">
                                <div class="invalid-feedback">
                                    Veuillez entrer un email valide
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="validationCustom09">Mot de passe</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" required="">
                                <div class="invalid-feedback">
                                    Veuillez entrer un mot de passe
                                </div>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-primary mt-4 d-block w-100" id="connexion" name="connexion"
                            value="Se connecter">

                        <p class="mb-0 mt-3 text-center">Pas de restaurant ?<a class="btn-link" href="login.php">En
                                créer un maintenant</a> </p>

                    </form>

                </div>
            </div>


        </div>

        <!-- Forgot Password Modal -->
        <div class="modal fade" id="modal-12" tabindex="-1" role="dialog" aria-labelledby="modal-12">
            <div class="modal-dialog modal-dialog-centered modal-min" role="document">
                <div class="modal-content">

                    <div class="modal-body text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <i class="flaticon-secure-shield d-block"></i>
                        <h1>Mot de passe oublié ?</h1>
                        <p> Entrer votre adresse email </p>
                        <form method="post">
                            <div class="ms-form-group has-icon">
                                <input type="text" placeholder="Email Address" class="form-control"
                                    name="forgot-password" value="">
                                <i class="material-icons">email</i>
                            </div>
                            <button type="submit" class="btn btn-primary shadow-none">Réinitialiser le mot de
                                passe</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </main>

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


</body>

</html>