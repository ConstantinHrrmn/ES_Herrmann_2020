<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : Avril 2020
TITRE PROJET: RESA
VERSION     : 1.0
*******************************************************************************/

// On test si il faut ajouter le PDO (dans le cas ou le fichier à été include dans un fichier qui ne l'as pas)
$pdo_path = "../../pdo.php";
if(file_exists($pdo_path)){
    include_once $pdo_path;
}

/*
* Lie une image à un établissement
* Params:
*   - idEtbalishement : l'id de l'établissement à lier
*   - idUploader : l'id de l'utilisateur qui met en ligne la photo
*   - file : la photo à mettre en ligne
*   - target_dir : le dossier dans lequel stocker la photo
*   - Le nombre de répertoire en arrière ou en avant pour atteindre "images/..."
*/
function SaveImageEtablishment($idEtbalishement, $idUploader, $file, $target_dir, $toMove){

    // Création de l'id unique pour renommer la photo
    $id =uniqid();

    // On déplace l'image dans le dossier de destination
    $target_file = UploadImage($toMove, $target_dir, $file, $id);

    // Déclaration d'une variable avec le dossier initial du dossier image
    $base_dir = "images/";

    if($target_file != -1){

        // On ajoute l'image dans la base de données
        $finalePath = $base_dir.$target_file;
        AddImageToDatabase($id, $finalePath, $idUploader);

        static $query2 = null;

        if ($query2 == null) {
          $req = 'INSERT INTO `etablishement_has_image`(`idEtablishement`, `idImages`) VALUES (:e , :i)';
          $query2 = database()->prepare($req);
        }
      
        try {
            $query2->bindParam(':e', $idEtbalishement, PDO::PARAM_STR);
            $query2->bindParam(':i', $id, PDO::PARAM_STR);
    
            $query2->execute();
        }
        catch (Exception $e) {
          error_log($e->getMessage());
        }
    } 
}

/*
* Lie une image à un plat
* Params:
*   - idDish : l'id du plat à lier
*   - idUploader : l'id de l'utilisateur qui met en ligne la photo
*   - file : la photo à mettre en ligne
*   - target_dir : le dossier dans lequel stocker la photo
*   - Le nombre de répertoire en arrière ou en avant pour atteindre "images/..."
*/
function SaveImageDish($idDish, $idUploader, $file, $target_dir, $toMove){

    // Création de l'id unique pour renommer la photo
    $id =uniqid();

    // On déplace l'image dans le dossier de destination
    $target_file = UploadImage($toMove, $target_dir, $file, $id);

    // Déclaration d'une variable avec le dossier initial du dossier image
    $base_dir = "images/";

    // On vérifie si le nom n'est pas égal à -1 (REF: UploadImage())
    if($target_file != -1){

        // On ajoute l'image dans la base de données
        $finalePath = $base_dir.$target_file;
        AddImageToDatabase($id, $finalePath, $idUploader);

        // On ajoute le lien entre l'image et le plat dans la base de données
        static $query2 = null;

        if ($query2 == null) {
          $req = 'INSERT INTO `dish_has_image`(`idDish`, `idImages`) VALUES (:d , :i)';
          $query2 = database()->prepare($req);
        }
      
        try {
            $query2->bindParam(':d', $idDish, PDO::PARAM_STR);
            $query2->bindParam(':i', $id, PDO::PARAM_STR);
    
            $query2->execute();
        }
        catch (Exception $e) {
          error_log($e->getMessage());
        }
    } 
}

/*
* Lie une image à un utilisateur
* Params:
*   - idUSer : l'id de l'utilisateur
*   - idUploader : l'id de l'utilisateur qui met en ligne la photo
*   - file : la photo à mettre en ligne
*   - target_dir : le dossier dans lequel stocker la photo
*   - Le nombre de répertoire en arrière ou en avant pour atteindre "images/..."
*/
function SaveImageUser($idUser, $idUploader, $file, $target_dir, $toMove){
  // Création de l'id unique pour renommer la photo
  $id =uniqid();

  // On déplace l'image dans le dossier de destination
  $target_file = UploadImage($toMove, $target_dir, $file, $id);

  // Déclaration d'une variable avec le dossier initial du dossier image
  $base_dir = "images/";

  // On vérifie si le nom n'est pas égal à -1 (REF: UploadImage())
  if($target_file != -1){

      // On ajoute l'image dans la base de données
      $finalePath = $base_dir.$target_file;
      AddImageToDatabase($id, $finalePath, $idUploader);

      // On ajoute le lien entre l'image et le plat dans la base de données
      static $query2 = null;

      if ($query2 == null) {
        $req = 'INSERT INTO `user_has_image`(`idUser`, `idImage`) VALUES (:d, :i)';
        $query2 = database()->prepare($req);
      }
    
      try {
          $query2->bindParam(':d', $idUser, PDO::PARAM_STR);
          $query2->bindParam(':i', $id, PDO::PARAM_STR);

          $query2->execute();
      }
      catch (Exception $e) {
        error_log($e->getMessage());
      }
  } 
}

/*
* Enregistre une images dans un dossier
* Params:
*   - ToMove : Le nombre de répertoire en arrière ou en avant pour atteindre "images/..."
*   - target_dir : le dossier dans le répertoire "images" dans lequel il faut mettre l'image
*   - file : la photo à ajouter
*   - file_name : le nom que l'on souhaite donner à l'image
*/
function UploadImage($ToMove, $target_dir, $file, $file_name){

    // On récupère le type de la photo (JPG, PNG, ETC.)
    $file_type = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));

    // On fusionne le nouveau nom du fichier avec l'extension (mon_nouveau_nom.l'extension)
    $myFile = $file_name.".".$file_type;

    // On ajoute le dossier de destination
    $target_file = $target_dir.$myFile;

    // On essaie de déplacer la photo dans le dossier désiré
    if (move_uploaded_file($file["tmp_name"], $ToMove.$target_file)) {
        // Retourne le nom du fichier si OK 
        return $target_file;
    } else {
        // Retourne -1 si il n'as pas réussi à transférer le fichier
        return -1;
    }
}

/*
* Ajout le path de l'image dans la base de données
* Params:
*   - id : l'id de l'image
*   - finalePath : Son emplacement final
*   - idUploader : l'id du user qui met en ligne la photo
*/
function AddImageToDatabase($id, $finalePath, $idUploader){
    static $query = null;

    if ($query == null) {
      $req = 'INSERT INTO `images`(`id`, `path`, `postedby`) VALUES (:i, :p, :u)';
      $query = database()->prepare($req);
    }
  
    try {

        $query->bindParam(':i', $id, PDO::PARAM_STR);
        $query->bindParam(':p', $finalePath, PDO::PARAM_STR);
        $query->bindParam(':u', $idUploader, PDO::PARAM_STR);

        $query->execute();
    }
    catch (Exception $e) {
      error_log($e->getMessage());
    }
}