  <?php
    $var_path = "./vars.php";

    if(file_exists($var_path)){
        include_once $var_path;
    }

    // On vérifie si l'utilisateur est connecté afin d'afficher les bons menus et la photo de profil
    if(isset($_SESSION['user'])){
        $usernav = $_SESSION['user'];
    }else{
        $usernav = null;
    }

  ?>

  <!-- Sidebar Navigation Left -->
  <aside id="ms-side-nav" class="side-nav fixed ms-aside-scrollable ms-aside-left">
    <!-- Logo -->
    <div class="logo-sn ms-d-block-lg">
      <a class="pl-0 ml-0 text-center" href="index.php">
        <img src="./assets/img/logo.png" alt="logo">
      </a>
    </div>
    <!-- Navigation -->

    <ul class="accordion ms-main-aside fs-14" id="side-nav-accordion">
      <li class="menu-item">
        <a href="reservations.php">Mes réservations</a>
      </li>
    </ul>
  </aside>