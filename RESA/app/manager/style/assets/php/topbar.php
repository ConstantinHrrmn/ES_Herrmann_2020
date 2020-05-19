<?php 
    include "../style/assets/php/images.php";
    include "../../vars.php";

    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        $img = GetImage($path."images/get/?user&id=".$user->id);
    }
    else{
        $user = null;
        $img = null;
    }
?>
<!-- Navigation Bar -->
<nav class="navbar ms-navbar">
    <div class="ms-aside-toggler ms-toggler pl-0" data-target="#ms-side-nav" data-toggle="slideLeft"> <span
            class="ms-toggler-bar bg-primary"></span>
        <span class="ms-toggler-bar bg-primary"></span>
        <span class="ms-toggler-bar bg-primary"></span>
    </div>
    <div class="logo-sn logo-sm ms-d-block-sm">
        <a class="pl-0 ml-0 text-center navbar-brand mr-0" href="./index.php">
            <img src="../style/assets/img/logo.png" alt="logo">
        </a>
    </div>
    <ul class="ms-nav-list ms-inline mb-0" id="ms-nav-options">
        <li class="ms-nav-item ms-nav-user dropdown">
            <a href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="ms-user-img ms-img-round float-right"
                    src="<?php echo $img == null ? "../style/assets/img/account_icon.png" : $img->full_path; ?>"
                    alt="people">
            </a>
            <ul class="dropdown-menu dropdown-menu-right user-dropdown" aria-labelledby="userDropdown">
                <li class="dropdown-menu-header">
                    <h6 class="dropdown-header ms-inline m-0"><span
                            class="text-disabled"><?php echo "Bienvenue, ".$user->first_name; ?></span>
                    </h6>
                </li>
                <li class="dropdown-divider"></li>

                <li class="ms-dropdown-list">
                    <a class="media fs-14 p-2" href="./login.php"> <span><i class="flaticon-user mr-2"></i>
                            Connexion</span>
                    </a>
                    <a class="media fs-14 p-2" href="./login.php"> <span><i class="flaticon-user mr-2"></i>
                            Création compte</span>
                    </a>
                </li>

                <!---
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-menu-footer">
                            <a class="media fs-14 p-2" href="pages/prebuilt-pages/lock-screen.html"> <span><i
                                        class="flaticon-security mr-2"></i> Lock</span>
                            </a>
                        </li>
                            -->
                <?php if($user != null): ?>
                <li class="dropdown-menu-footer">
                    <a class="media fs-14 p-2" href="../style/assets/php/logout.php"> <span><i
                                class="flaticon-shut-down mr-2"></i> Logout</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </li>
    </ul>
    <div class="ms-toggler ms-d-block-sm pr-0 ms-nav-toggler" data-toggle="slideDown" data-target="#ms-nav-options">
        <span class="ms-toggler-bar bg-primary"></span>
        <span class="ms-toggler-bar bg-primary"></span>
        <span class="ms-toggler-bar bg-primary"></span>
    </div>
</nav>