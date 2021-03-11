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
$size_total = 0;
$error = "";
$type = '';
$extension = '';
$nb_files = count($_FILES['media']['name']);
$MAX_FILE_SIZE = 3145728;    // 3MB in bytes
$MAX_POST_SIZE = 73400320;  // 70MB in bytes
$actualType = "";
$percent = 0.5;
$max_height = 300;
$max_width = 600;

$extensions = array(
    "image" => array('.png', '.gif', '.jpg', '.jpeg'),
    "video" => array('.mp4', '.webm'),
    "audio" => array('.mp3', 'wav', 'ogg')
);
// available types of file
$types = array('image', 'video', 'audio');

// si on souhaite envoyer quelque chose...
if ($btn == 'send' && $comment != null) {
    DBConnection::startTransaction();
    try {
        $id = postDAO::add_post($comment);
        DBConnection::commit();
    } catch (\Throwable $th) {
        DBConnection::rollback();
    }

    if ($_FILES['media']['name'][0] != "") {
        DBConnection::startTransaction();
        foreach ($_FILES['media']['size'] as $key => $value) {
            if ($value > $MAX_FILE_SIZE) {
                $error = 'File too heavy.';
                DBConnection::rollback();
            } else {
                $size_total += $value;
            }
        }

        if (isset($_FILES['media'])) {
            for ($i = 0; $i < $nb_files; $i++) {
                $errorimg = $_FILES['media']["error"][$i];
                if ($error == 'File too heavy.' || $size_total > $MAX_POST_SIZE) {
                    $error = "Fichier trop volumineux!";
                    DBConnection::rollback();
                } else {
                    $separator = '/';
                    $extension = explode($separator, mime_content_type($_FILES['media']['tmp_name'][$i]))[1];
                    $type = explode($separator, mime_content_type($_FILES['media']['tmp_name'][$i]))[0];

                    if (!in_array($type, $types)) {
                        $error = "erreur dans le type de fichier";
                        DBConnection::rollback();
                    } else {
                        if ($error != "erreur dans le type de fichier") {
                            if ($errorimg[0] == 0) {
                                //echo "upload reussi";
                                $tmp_name = $_FILES['media']["name"][$i];
                                $name = explode(".", $tmp_name);
                                $name = $name[0] . uniqid() . "." . $name[1];

                                if (move_uploaded_file($_FILES['media']["tmp_name"][$i], $default_dir . $type . "/" . $name)) {
                                    //ajout du nom du fichier dans la bd
                                    mediaDAO::changePath($name, $tmp_name[$i]);
                                    $lienimg = $default_dir . $type . "/" . $name;



                                    //suppression de la redimension du format gif du a un problème d'animation
                                    /*if ($extension == "gif") {

                                        list($orig_width, $orig_height) = getimagesize($lienimg);
                                        $width = $orig_width;
                                        $height = $orig_height;

                                        //plus haut
                                        if ($height > $max_height) {
                                            $width = ($max_height / $height) * $width;
                                            $height = $max_height;
                                        }

                                        //plus large
                                        if ($width > $max_width) {
                                            $height = ($max_width / $width) * $height;
                                            $width = $max_width;
                                        }

                                        $thumb = imagecreatetruecolor($width, $height);
                                        $source = imagecreatefromgif($lienimg);
                                        // Redimensionnement
                                        if (imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height)) {
                                            imagegif($thumb, $lienimg);
                                        }
                                    }*/

                                    //supprime la transparence de l'image
                                    if ($extension == "png") {

                                        list($orig_width, $orig_height) = getimagesize($lienimg);
                                        $width = $orig_width;
                                        $height = $orig_height;

                                        //plus haut
                                        if ($height > $max_height) {
                                            $width = ($max_height / $height) * $width;
                                            $height = $max_height;
                                        }

                                        //plus large
                                        if ($width > $max_width) {
                                            $height = ($max_width / $width) * $height;
                                            $width = $max_width;
                                        }

                                        $thumb = imagecreatetruecolor($width, $height);
                                        $source = imagecreatefrompng($lienimg);
                                        // Redimensionnement
                                        if (imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height)) {
                                            imagepng($thumb, $lienimg);
                                        }
                                    }

                                    if ($extension == "jpeg") {

                                        // ---METADATA---
                                        /*echo "test1.jpg:<br />\n";
                                        $exif = exif_read_data($lienimg, 'IFD0');
                                        echo $exif===false ? "Aucun en-tête de donnés n'a été trouvé.<br />\n" : "L'image contient des en-têtes<br />\n";
                                        
                                        $exif = exif_read_data($lienimg, 0, true);
                                        echo "test2.jpg:<br />\n";
                                        foreach ($exif as $key => $section) {
                                            foreach ($section as $name => $val) {
                                                echo "$key.$name: $val<br />\n";
                                            }
                                        }*/


                                        list($orig_width, $orig_height) = getimagesize($lienimg);
                                        $width = $orig_width;
                                        $height = $orig_height;

                                        //plus haut
                                        if ($height > $max_height) {
                                            $width = ($max_height / $height) * $width;
                                            $height = $max_height;
                                        }

                                        //plus large
                                        if ($width > $max_width) {
                                            $height = ($max_width / $width) * $height;
                                            $width = $max_width;
                                        }

                                        $thumb = imagecreatetruecolor($width, $height);
                                        $source = imagecreatefromjpeg($lienimg);
                                        // Redimensionnement
                                        if (imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height)) {
                                            imagejpeg($thumb, $lienimg);
                                        }

                                        

                                    }
                                } else {
                                    DBConnection::rollback();
                                }
                            }
                            try {
                                mediaDAO::addmedia($name, $type, $extension, $lienimg, $id);
                                DBConnection::commit();
                            } catch (\Throwable $th) {
                                $error = $th;
                                DBConnection::rollback();
                            }
                        } else {
                            DBConnection::rollback();
                        }
                    }
                }
            }
        }
    }
} else {
    $error = "un message est nécéssaire";
}

// Display

if (empty($error)) {
    $msg = '<div class="alert alert-success" role="alert">Upload effectué avec succès!</div>';
} else {
    $msg = '<div class="alert alert-danger" role="alert">' . $error . '</div>';
}
