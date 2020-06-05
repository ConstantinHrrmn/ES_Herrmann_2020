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

    if(isset($_SESSION['etab'])){
      $etab = $_SESSION['etab'];
    }else{
      $etab = null;
    }

  ?>

  <!-- Sidebar Navigation Left -->
  <aside id="ms-side-nav" class="side-nav fixed ms-aside-scrollable ms-aside-left">
    <!-- Logo -->
    <div class="logo-sn ms-d-block-lg">
      <a class="pl-0 ml-0 text-center" href="index.php">
        <img src="../style/assets/img/logo.png" alt="logo">
      </a>
    </div>
    <!-- Navigation     -->

    <ul class="accordion ms-main-aside fs-14" id="side-nav-accordion">

    <?php if($etab->subscription > 1): ?>
      <li class="menu-item">
        <a href="../communes/reservations.php">Réservations</a>
      </li>
      <li class="menu-item">
        <a href="../communes/clients.php">Clients</a>
      </li>
  <?php endif; ?>
  <?php if($etab->subscription > 2): ?>
      <li class="menu-item">
        <a href="../communes/employes.php">Employés</a>
      </li>
      <li class="menu-item">
        <a href="../communes/fournitures.php">Gestion des fournitures</a>
      </li>
      <li class="menu-item">
        <a href="../communes/plan.php">Plan de table</a>
      </li>
  <?php endif; ?>
    </ul>

  </aside>