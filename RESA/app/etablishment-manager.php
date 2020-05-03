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
        $floors = get_object_vars(json_decode(file_get_contents($path."etablishment/floor/get/?id=".$id)));
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
  <!-- Overlays -->
  <div class="ms-aside-overlay ms-overlay-left ms-toggler" data-target="#ms-side-nav" data-toggle="slideLeft"></div>

  <!-- Sidebar Navigation Left -->
  <aside id="ms-side-nav" class="side-nav fixed ms-aside-scrollable ms-aside-left">
    <!-- Logo -->
    <div class="logo-sn ms-d-block-lg">
      <a class="pl-0 ml-0 text-center" href="index.html">
        <img src="https://via.placeholder.com/216x62" alt="logo">
      </a>
    </div>
    <!-- Navigation -->
    <ul class="accordion ms-main-aside fs-14" id="side-nav-accordion">
      <!-- Dashboard -->
      <li class="menu-item">
        <a href="#" class="has-chevron" data-toggle="collapse" data-target="#dashboard" aria-expanded="false" aria-controls="dashboard"> <span><i class="material-icons fs-16">dashboard</i>Dashboard </span>
        </a>
        <ul id="dashboard" class="collapse" aria-labelledby="dashboard" data-parent="#side-nav-accordion">
          <li> <a href="index.html">Costic</a>
          </li>
        </ul>
      </li>
      <!-- /Dashboard -->

      <li class="menu-item">
        <a href="pages/animation.html"> <span><i class="material-icons fs-16">format_paint</i>Animations</span>
        </a>
      </li>

    </ul>
  </aside>

  <!-- Main Content -->
  <main class="body-content">
    <!-- Navigation Bar -->
    <nav class="navbar ms-navbar">
      <div class="ms-aside-toggler ms-toggler pl-0" data-target="#ms-side-nav" data-toggle="slideLeft"> <span class="ms-toggler-bar bg-primary"></span>
        <span class="ms-toggler-bar bg-primary"></span>
        <span class="ms-toggler-bar bg-primary"></span>
      </div>
      <div class="logo-sn logo-sm ms-d-block-sm">
        <a class="pl-0 ml-0 text-center navbar-brand mr-0" href="./index.php">
          <img src="" alt="logo">
        </a>
      </div>
      <ul class="ms-nav-list ms-inline mb-0" id="ms-nav-options">
        <li class="ms-nav-item ms-nav-user dropdown">
          <a href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="ms-user-img ms-img-round float-right" src="<?php echo $img == null ? "" : $img->full_path; ?>" alt="people">
          </a>
          <ul class="dropdown-menu dropdown-menu-right user-dropdown" aria-labelledby="userDropdown">
            <li class="dropdown-menu-header">
              <h6 class="dropdown-header ms-inline m-0"><span class="text-disabled"><?php echo $user == null ? "Bienvenue, invité !" : "Bienvenue, ".$user->first_name; ?></span></h6>
            </li>
            <li class="dropdown-divider"></li>
            <li class="ms-dropdown-list">
              <a class="media fs-14 p-2" href="./profile.php"> <span><i class="flaticon-user mr-2"></i> Profile</span>
              </a>
            </li>
            <li class="dropdown-divider"></li>
            <li class="dropdown-menu-footer">
              <a class="media fs-14 p-2" href="pages/prebuilt-pages/lock-screen.html"> <span><i class="flaticon-security mr-2"></i> Lock</span>
              </a>
            </li>
            <li class="dropdown-menu-footer">
              <a class="media fs-14 p-2" href="pages/prebuilt-pages/default-login.html"> <span><i class="flaticon-shut-down mr-2"></i> Logout</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
      <div class="ms-toggler ms-d-block-sm pr-0 ms-nav-toggler" data-toggle="slideDown" data-target="#ms-nav-options"> <span class="ms-toggler-bar bg-primary"></span>
        <span class="ms-toggler-bar bg-primary"></span>
        <span class="ms-toggler-bar bg-primary"></span>
      </div>
    </nav>

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

              <?php foreach($floors as $floor):?>
                <div class="ms-panel-body">
                  <h4><?php echo $floor->name ?></h4>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <tbody>
                        <?php foreach($floor->zones as $zone):?>
                          <tr>
                            <td class="ms-table-f-w"><?php echo $zone[0] ?></td>
                            <td>[nombre de places]</td>
                            <td>[Horaires]</td>
                            <td><a href="">Editer</a></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              <?php endforeach; ?>

          </div>
        </div>

        <!-- Réservations de la semaine -->
        <div class="col-xl-5 col-md-12">
          <div class="ms-panel ms-widget ms-crypto-widget">
            <div class="ms-panel-header">
              <h6>Réservations de la semaine</h6>
            </div>
            <div class="ms-panel-body p-0">
              <ul class="nav nav-tabs nav-justified has-gap px-4 pt-4" role="tablist">
                <li role="presentation" class="fs-12"><a href="#lun" aria-controls="lun" class="active show" role="tab" data-toggle="tab"> Lun </a></li>
                <li role="presentation" class="fs-12"><a href="#mar" aria-controls="mar" role="tab" data-toggle="tab"> Mar </a></li>
                <li role="presentation" class="fs-12"><a href="#mer" aria-controls="mer" role="tab" data-toggle="tab"> Mer </a></li>
                <li role="presentation" class="fs-12"><a href="#jeu" aria-controls="jeu" role="tab" data-toggle="tab"> Jeu </a></li>
                <li role="presentation" class="fs-12"><a href="#ven" aria-controls="ven" role="tab" data-toggle="tab"> Ven </a></li>
                <li role="presentation" class="fs-12"><a href="#sam" aria-controls="sam" role="tab" data-toggle="tab"> Sam </a></li>
                <li role="presentation" class="fs-12"><a href="#dim" aria-controls="dim" role="tab" data-toggle="tab"> Dim </a></li>
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

        <!-- Food Orders -->
        <div class="col-md-12">
          <div class="ms-panel">
            <div class="ms-panel-header">
              <h6>Trending Orders</h6>
            </div>
            <div class="ms-panel-body">
              <div class="row">

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                  <div class="ms-card no-margin">
                    <div class="ms-card-img">
                      <img src="https://via.placeholder.com/530x240" alt="card_img">
                    </div>
                    <div class="ms-card-body">
                      <div class="ms-card-heading-title">
                        <h6>Meat Stew</h6>
                        <span class="green-text"><strong>$25.00</strong></span>
                      </div>

                      <div class="ms-card-heading-title">
                        <p>Orders <span class="red-text">15</span></p>
                        <p>Income <span class="red-text">$175</span></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                  <div class="ms-card no-margin">
                    <div class="ms-card-img">
                      <img src="https://via.placeholder.com/530x240" alt="card_img">
                    </div>
                    <div class="ms-card-body">
                      <div class="ms-card-heading-title">
                        <h6>Pancake</h6>
                        <span class="green-text"><strong>$50.00</strong></span>
                      </div>

                      <div class="ms-card-heading-title">
                        <p>Orders <span class="red-text">75</span></p>
                        <p>Income <span class="red-text">$275</span></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                  <div class="ms-card no-margin">
                    <div class="ms-card-img">
                      <img src="https://via.placeholder.com/530x240" alt="card_img">
                    </div>
                    <div class="ms-card-body">
                      <div class="ms-card-heading-title">
                        <h6>Burger</h6>
                        <span class="green-text"><strong>$45.00</strong></span>
                      </div>

                      <div class="ms-card-heading-title">
                        <p>Orders <span class="red-text">85</span></p>
                        <p>Income <span class="red-text">$575</span></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                  <div class="ms-card no-margin">
                    <div class="ms-card-img">
                      <img src="https://via.placeholder.com/530x240" alt="card_img">
                    </div>
                    <div class="ms-card-body">
                      <div class="ms-card-heading-title">
                        <h6>Saled</h6>
                        <span class="green-text"><strong>$85.00</strong></span>
                      </div>
                      <div class="ms-card-heading-title">
                        <p>Orders <span class="red-text">175</span></p>
                        <p>Income <span class="red-text">$775</span></p>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <!-- END/Food Orders -->

        <!-- Recent Orders Requested -->
        <div class="col-xl-7 col-md-12">
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



        <div class="col-12">
          <div class="ms-panel">
            <div class="ms-panel-header">
              <h6>Recent Orders</h6>
            </div>
            <div class="ms-panel-body">
              <div class="table-responsive">
                <table class="table table-hover thead-primary">
                  <thead>
                    <tr>
                      <th scope="col">Order ID</th>
                      <th scope="col">Order Name</th>
                      <th scope="col">Customer Name</th>
                      <th scope="col">Location</th>
                      <th scope="col">Order Status</th>
                      <th scope="col">Delivered Time</th>
                      <th scope="col">Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">1</th>
                      <td>French Fries</td>
                      <td>Jhon Leo</td>
                      <td>New Town</td>
                      <td><span class="badge badge-primary">Pending</span>
                      </td>
                      <td>10:05</td>
                      <td>$10</td>
                    </tr>
                    <tr>
                      <th scope="row">2</th>
                      <td>Mango Pie</td>
                      <td>Kristien</td>
                      <td>Old Town</td>
                      <td><span class="badge badge-dark">Cancelled</span>
                      </td>
                      <td>14:05</td>
                      <td>$9</td>
                    </tr>
                    <tr>
                      <th scope="row">3</th>
                      <td>FrieD Egg Sandwich</td>
                      <td>Jack Suit</td>
                      <td>Oxford Street</td>
                      <td><span class="badge badge-success">Delivered</span>
                      </td>
                      <td>12:05</td>
                      <td>$19</td>
                    </tr>
                    <tr>
                      <th scope="row">4</th>
                      <td>Lemon Yogurt Parfait</td>
                      <td>Alesdro Guitto</td>
                      <td>Church hill</td>
                      <td><span class="badge badge-success">Delivered</span>
                      </td>
                      <td>12:05</td>
                      <td>$18</td>
                    </tr>
                    <tr>
                      <th scope="row">5</th>
                      <td>Spicy Grill Sandwich</td>
                      <td>Jacob Sahwny</td>
                      <td>palace Road</td>
                      <td><span class="badge badge-success">Delivered</span>
                      </td>
                      <td>12:05</td>
                      <td>$21</td>
                    </tr>
                    <tr>
                      <th scope="row">6</th>
                      <td>Chicken Sandwich</td>
                      <td>Peter Gill</td>
                      <td>Street 21</td>
                      <td><span class="badge badge-primary">Pending</span>
                      </td>
                      <td>12:05</td>
                      <td>$15</td>
                    </tr>
                  </tbody>
                </table>
              </div>
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
