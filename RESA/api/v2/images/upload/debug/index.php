<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
VERSION     : 1.0
*******************************************************************************/

// On inclu le connecteur de la base de données
include '../../../pdo.php';
include '../index.php';

// Retourne tous les établissements
function loadEtablishements(){
    $json = file_get_contents('http://localhost/Travail_diplome_ES_2020/RESA/api/v2/etablishment/get/');
    $etablisement = json_decode($json);
    return $etablisement;
}

// Retournes tous les plats
function loadDishes(){
    $json = file_get_contents('http://localhost/Travail_diplome_ES_2020/RESA/api/v2/menu/get/?dishes');
    $dishes = json_decode($json);
    return $dishes;
}

// Retournes tous les utilisateurs
function loadUser(){
    $json = file_get_contents('http://localhost/Travail_diplome_ES_2020/RESA/api/v2/user/get/');
    $users = json_decode($json);
    return $users;
}

if(isset($_POST['submitE'])){
    $toMove = "../../";
    $target_dir = "restaurant/";
    $idEtab = $_POST['etab'];
    SaveImageEtablishment($idEtab, 1, $_FILES['fileE'], $target_dir, $toMove);

}else if(isset($_POST['submitD'])){
    $toMove = "../../";
    $target_dir = "dish/";
    $idDish = $_POST['dish'];
    SaveImageDish($idDish, 1, $_FILES['fileD'], $target_dir, $toMove);
}
else if(isset($_POST['submitU'])){
    $toMove = "../../";
    $target_dir = "user/";
    $idUser = $_POST['user'];
    SaveImageUser($idUser, 1, $_FILES['fileU'], $target_dir, $toMove);
}

$etablisement = loadEtablishements();
$dishes = loadDishes();
$users = loadUser();

?>

<!DOCTYPE html>
<html>
    <body>
        <form action="#" method="post" enctype="multipart/form-data" id="etablissement">
            <select id="etab" name="etab" form="etablissement">
                <?php foreach($etablisement as $etab=>$value):?>
                    <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                <?php endforeach; ?>
            </select>

            <input type="file" name="fileE" id="fileE">
            <input type="submit" value="Ajouter photo Etablissement" name="submitE">
        </form>
        <h1>------</h1>
        <form action="#" method="post" enctype="multipart/form-data" id="repas">
            <select id="dish" name="dish" form="repas">
                <?php foreach($dishes as $dish=>$val):?>
                    <option value="<?php echo $val->id ?>"><?php  echo $val->dish_name ?></option>
                <?php endforeach; ?>
            </select>

            <input type="file" name="fileD" id="fileD">
            <input type="submit" value="Ajouter photo Repas" name="submitD">
        </form>
        <h1>------</h1>
        <form action="#" method="post" enctype="multipart/form-data" id="utilisateur">
            <select id="user" name="user" form="utilisateur">
                <?php foreach($users as $user=>$val):?>
                    <option value="<?php echo $val->id ?>"><?php  echo $val->first_name ?></option>
                <?php endforeach; ?>
            </select>

            <input type="file" name="fileU" id="fileU">
            <input type="submit" value="Ajouter photo user" name="submitU">
        </form>
    </body>
</html>