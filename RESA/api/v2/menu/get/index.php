<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
VERSION     : 1.0
*******************************************************************************/

// On inclu le connecteur de la base de données
include '../../pdo.php';

/*
* Récupères toutes les informations des plats dans un menu du restaurant 
* Params:
*   - $idEtablishement : l'id de l'établissement
*/
function GetDishesForMenu($idEtablishement){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT d.name as dish_name, d.price as dish_price, dt.name as type_name FROM `menu` as m INNER JOIN `menu_has_dishes` as mhd ON mhd.idMenu = m.id INNER JOIN `dish` as d ON d.id = mhd.idDish INNER JOIN `dish_type` as dt ON dt.id = d.idType WHERE m.id IN (SELECT e.id_menu FROM `establishment`as e WHERE e.id = '.$idEtablishement.')';
      $query = database()->prepare($req);
    }
  
    try {
      $query->execute();
      $res = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      $res = false;
    }
  
    return $res;
}

/*
* Récupères toutes les informations des menus composés dans un menu du restaurant 
* Params:
*   - $idEtablishement : l'id de l'établissement
*/
function GetMealsForMenu($idEtablishement){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT ml.id as meal_id, ml.name as meal_name, entrance.name as entrance_name, main.name as main_name, dessert.name as dessert_name, IFNULL(drink.name, "-") as drink_name, ml.price as price FROM `menu_has_meal` as mhm INNER JOIN `meal` as ml ON ml.id = mhm.idMeal INNER JOIN `dish` as entrance ON ml.entrance = entrance.id INNER JOIN `dish` as main ON ml.main = main.id INNER JOIN `dish` as dessert ON ml.dessert = dessert.id LEFT JOIN `dish` as drink ON ml.drink = drink.id INNER JOIN `menu` as menu ON menu.id = mhm.idMenu WHERE mhm.idMenu IN (SELECT e.id_menu FROM establishment as e WHERE e.id = '.$idEtablishement.')';
      $query = database()->prepare($req);
    }
  
    try {
      $query->execute();
      $res = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      $res = false;
    }
  
    return $res;
}

/*
* Récupère le nom et la description d'un menu
* Params:
*   - $idEtablishement : l'id de l'établissement
*/
function GetMenu($idEtablishement){
    static $query = null;

    if ($query == null) {
      $req = 'SELECT m.id, m.name, m.description FROM `menu` as m WHERE m.id IN (SELECT e.id_menu FROM `establishment` as e WHERE e.id = '.$idEtablishement.')';
      $query = database()->prepare($req);
    }
  
    try {
      $query->execute();
      $res = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
      error_log($e->getMessage());
      $res = false;
    }
  
    return $res;
}

if(isset($_GET['dishes']) && isset($_GET['id'])){
    $id = $_GET['id'];
    if(is_numeric($id)){
        echo json_encode(GetDishesForMenu($id));
    }
}
else if(isset($_GET['meals']) && isset($_GET['id'])){
    $id = $_GET['id'];
    if(is_numeric($id)){
        echo json_encode(GetMealsForMenu($id));
    }
}
else if(isset($_GET['menu']) && isset($_GET['id'])){
    $id = $_GET['id'];
    if(is_numeric($id)){
        echo json_encode(GetMenu($id));
    }
}
else if(isset($_GET['all'])  && isset($_GET['id'])){
    $id = $_GET['id'];
    if(is_numeric($id)){
        $menu = GetMenu($id);
        $dishes = GetDishesForMenu($id);
        $meals = GetMealsForMenu($id);

        $menu = array("infos"=>$menu, "dishes"=>$dishes, "meals"=>$meals);

        echo json_encode($menu);
    }
    
}


