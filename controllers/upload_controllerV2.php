<?php
/*
 *  Author  :   Golay Brian
 *  Class   :   P4B
 *  Date    :   2021/01/28
 *  Desc.   :   check page of the uploaded file
*/

require_once("./sql/mediaDAO.php");
require_once("./sql/postDAO.php");

use M152\sql\mediaDAO;
use M152\sql\postDAO;
use M152\sql\DBConnection;

$btn = filter_input(INPUT_POST, 'action');
$comment = filter_input(INPUT_POST, 'msg', FILTER_SANITIZE_STRING);
$name = "";
$lienimg = "";
$id = "";
$default_dir = "./media/";
$errorimg = "";

// si on souhaite envoyer quelque chose...
if ($btn == 'send') {
    $id = postDAO::add_post($comment);
    if (isset($_FILES['media'])) {
        var_dump($_FILES['media']);
        $errorimg = $_FILES['media']["error"];
        if ($errorimg[0] == 0) {
            //echo "upload reussi";
            $tmp_name = $_FILES['media']["name"];
            $name = explode(".", $tmp_name[0]);
            $name = $name[0] . uniqid() . "." . $name[1];
            move_uploaded_file($_FILES['media']["tmp_name"][0], $default_dir . $name);
            //ajout du nom du fichier dans la bd
            mediaDAO::changePath($name, $tmp_name[0]);
            $lienimg = $default_dir . $name;
        }
        try {
            //mediaDAO::addmedia($comment, observationDAO::getIdBirdByEnglishName($NomANG)["idBird"], $_SESSION['userID'], $Latitude, $Longitude, $lienimg, $media);
            mediaDAO::addmedia($name,"image", "jpeg", $lienimg, $id);
            /*header("Location: ./index.php?page=homepage");
            exit();*/
        } catch (\Throwable $th) {
            $error = $th;
        }
    }
}

// Display

if (!isset($error)) {
    $msg = '<div class="alert alert-success" role="alert">Upload effectué avec succès!</div>';
} else {
    //$msg = '<div class="alert alert-danger" role="alert">';
    $msg = $error[0];
    //$msg = '</div>';
}
