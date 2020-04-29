<?php
  include "./assets/php/vars.php";

  session_start();

  if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];

    $image_link = $path."images/get/?user&id=".$user->id;

    $json = file_get_contents($image_link);
    $img = json_decode($json);

  }
  else{
    header("Location : ./login.php");
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

<body class="ms-body ms-aside-left-open ms-primary-theme ms-has-quickbar">

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
            <h1 class="ms-profile-username"><?php echo $user->first_name ?> <?php echo $user->last_name ?></h1>
            <h2 class="ms-profile-role"></h2>
          </div>
        </div>

        <ul class="ms-profile-navigation nav nav-tabs tabs-bordered" role="tablist">
          <li role="presentation"><a href="#tab1" aria-controls="tab1" class="active" role="tab" data-toggle="tab"> Aperçu </a></li>
          <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"> Réservations passées </a></li>
          <li role="presentation"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab"> Modifier </a></li>
        </ul>

      </div>
    
        <div class="tab-content">
          <div class="tab-pane active" id="tab1">
            <div class="row">
              <div class="col-xl-5 col-md-12">
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
            </div>
          </div>

          <div class="tab-pane" id="tab2">
            <div class="col-md-12">
              <div class="ms-panel">
                <div class="ms-panel-body">
                  <h2 class="section-title">Cheffs on Dutty</h2>
                  <div class="row">
                    <div class="col-xl-4 col-md-6 col-sm-12">
                      <div class="media ms-profile-experience">
                        <div class="mr-2 align-self-center">
                          <img src="https://via.placeholder.com/270x270" class="ms-img-round ms-img-small" alt="people">
                        </div>
                        <div class="media-body">
                          <h4>Mike Labinstine</h4>
                          <p>January 2019 to Present</p>
                          <p>Veg Cook</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-12">
                      <div class="media ms-profile-experience">
                        <div class="mr-2 align-self-center">
                          <img src="https://via.placeholder.com/270x270" class="ms-img-round ms-img-small" alt="people">
                        </div>
                        <div class="media-body">
                          <h4>George Labinstin</h4>
                          <p>January 2019 to Present</p>
                          <p>Meat Cook</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-12">
                      <div class="media ms-profile-experience">
                        <div class="mr-2 align-self-center">
                          <img src="https://via.placeholder.com/270x270" class="ms-img-round ms-img-small" alt="people">
                        </div>
                        <div class="media-body">
                          <h4>Manti Jhoe</h4>
                          <p>January 2019 to Present</p>
                          <p>Quality Control</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-12">
                      <div class="media ms-profile-experience">
                        <div class="mr-2 align-self-center">
                          <img src="https://via.placeholder.com/270x270" class="ms-img-round ms-img-small" alt="people">
                        </div>
                        <div class="media-body">
                          <h4>Jessy Doe</h4>
                          <p>January 2019 to Present</p>
                          <p>Top Cheff</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-12">
                      <div class="media ms-profile-experience">
                        <div class="mr-2 align-self-center">
                          <img src="https://via.placeholder.com/270x270" class="ms-img-round ms-img-small" alt="people">
                        </div>
                        <div class="media-body">
                          <h4>Jessica Doe</h4>
                          <p>January 2019 to Present</p>
                          <p>Night Cheff</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-12">
                      <div class="media ms-profile-experience">
                        <div class="mr-2 align-self-center">
                          <img src="https://via.placeholder.com/270x270" class="ms-img-round ms-img-small" alt="people">
                        </div>
                        <div class="media-body">
                          <h4>Jhone Doe</h4>
                          <p>January 2019 to Present</p>
                          <p>The Cheff</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane" id="tab3">
            <div class="col-xl-6 col-md-12">
              <div class="ms-panel ms-panel-fh">
                <div class="ms-panel-body">
                  <h2 class="section-title">Skill level</h2>
                  <span class="progress-label">Web Design</span><span class="progress-status">83%</span>
                  <div class="progress progress-tiny">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 83%" aria-valuenow="83" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span class="progress-label">Development</span><span class="progress-status">50%</span>
                  <div class="progress progress-tiny">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span class="progress-label">Interface Design</span><span class="progress-status">75%</span>
                  <div class="progress progress-tiny">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span class="progress-label">Illustration</span><span class="progress-status">92%</span>
                  <div class="progress progress-tiny">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 92%" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span class="progress-label">Brand Design</span><span class="progress-status">97%</span>
                  <div class="progress progress-tiny">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 97%" aria-valuenow="97" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span class="progress-label">Adobe</span><span class="progress-status">90%</span>
                  <div class="progress progress-tiny">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-6 col-md-12">
              <div class="ms-panel">
                <div class="ms-panel-body">
                  <h2 class="section-title">My Timeline</h2>
                  <ul class="ms-activity-log">
                  <li>
                    <div class="ms-btn-icon btn-pill icon btn-success">
                      <i class="flaticon-tick-inside-circle"></i>
                    </div>
                    <h6>Computer Science Degree</h6>
                    <span> <i class="material-icons">event</i>1 January, 2018</span>
                    <p class="fs-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque scelerisque diam non nisi semper, ula in sodales vehicula....</p>
                  </li>
                  <li>
                    <div class="ms-btn-icon btn-pill icon btn-info">
                      <i class="flaticon-information"></i>
                    </div>
                    <h6>Landed first Job</h6>
                    <span> <i class="material-icons">event</i>4 March, 2018</span>
                    <p class="fs-14">Curabitur purus sem, malesuada eu luctus eget, suscipit sed turpis. Nam pellentesque felis vitae justo accumsan, sed semper nisi sollicitudin...</p>
                  </li>
                  <li>
                    <div class="ms-btn-icon btn-pill icon btn-success">
                      <i class="flaticon-tick-inside-circle"></i>
                    </div>
                    <h6>Started my own Company</h6>
                    <span> <i class="material-icons">event</i>1 March, 2020</span>
                    <p class="fs-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque scelerisque diam non nisi semper, ula in sodales vehicula....</p>
                  </li>
                </ul>
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
