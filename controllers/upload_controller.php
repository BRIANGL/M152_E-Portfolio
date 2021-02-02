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

// si on souhaite envoyer quelque chose...
if ($btn == 'send') {
    // list all the authorised extension
    // useless because you can use the type 
    $extensions = array(
        "image" => array('.png', '.gif', '.jpg', '.jpeg'),
        "video" => array('.mp4', '.webm'),
        "audio" => array('.mp3', 'wav', 'ogg')
    );
    // available types of file
    $types = array('image', 'audio', 'video');

    $error = '';
    $MAX_FILE_SIZE = 3145728;    // 3MB in bytes
    $MAX_POST_SIZE = 73400320;  // 70MB in bytes

    $comment = filter_input(INPUT_POST, 'msg', FILTER_SANITIZE_STRING);
    $default_dir = "./media/";
    $nb_files = count($_FILES['media']['name']);
    $size_total = 0;
    // file info
    $temp_filename = "";
    $extension = '';
    $type = '';
    $local_path = $default_dir;
    $filename = '';

    foreach ($_FILES['media']['size'] as $key => $value) {
        if ($value > $MAX_FILE_SIZE) {
            $error = 'File too heavy.';
        } else {
            $size_total += $value;
        }
    }

    if ($size_total > $MAX_POST_SIZE) {
        $error .= 'post size too heavy';
    }
    try {
        DBConnection::startTransaction();
        $id = postDAO::add_post($comment);
        // verify that the id exists
        if ($id > 0) {
            // verify that there's file(s).
            if ($size_total > 0) {
                for ($i = 0; $i < $nb_files; $i++) {
                    // récupère le type de contenu d'un fichier en l'imitant
                    // ! mime_content_type retourne la valeur : type/ext !
                    $separator = '/';
                    // case 1 pour avoir l'ext
                    $extension = explode($separator, mime_content_type($_FILES['media']['tmp_name'][$i]))[1];
                    // case 0 pour avoir le type
                    // récupère l'extension du fichier en imitant son contenu
                    $type = explode($separator, mime_content_type($_FILES['media']['tmp_name'][$i]))[0];;

                    $local_path .= $type . '/';
                    $full_filename = $_FILES['media']['tmp_name'][$i];
                    $filename = $_FILES['media']['name'][$i];

                    // vérification du type de fichier renvoyé
                    if (!in_array($type, $types)) {
                        DBConnection::rollback();
                        $error .= "erreur dans le type de fichier";
                    }
                    //vérification de la taille du fichier
                    else if ($_FILES['media']['size'][$i] > $MAX_FILE_SIZE) {
                        DBConnection::rollback();
                        $error .= "file size too heavy.";
                    }
                    // then all is OK
                    else {
                        // verification of the file name
                        // any accent ?
                        $full_filename = strtr(
                            $full_filename,
                            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
                            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy'
                        );

                        $inc = 1;
                        // process to avoid file with same name
                        $temp_filename = $filename;
                        while (file_exists($default_dir . $type . '/' . $temp_filename)) {
                            $inc++;
                            $temp_filename = $filename . $inc;
                        }
                        $filename = $temp_filename;
                        $path = $local_path . $filename . '.' . $extension;
                        $path = str_replace(' ', '', $path);


                        $errorimg = $_FILES["media"]["error"];
                        if ($errorimg == 0) {
                            $tmp_name = $_FILES["media"]["name"];
                            $name = explode(".", $tmp_name);
                            $name = $name[0] . uniqid() . "." . $name[1];
                            move_uploaded_file($_FILES["media"]["tmp_name"], FILE_PATH . $name);
                            //ajout du nom du fichier dans la bd
                            mediaDAO::changePath($name, $tmp_name);
                            $lienimg = FILE_PATH . $name;
                        } else {
                            $error = $errorimg;
                        }
                        try {
                            mediaDAO::addmedia($type, $filename, $extension, $path, $id);
                            DBConnection::commit();
                        } catch (\Throwable $th) {
                            $error = $th;
                            DBConnection::rollback();
                        }
                        /*
                        //var_dump(move_uploaded_file($temp_filename, $path));
                        if (mediaDAO::add_media($type, $filename, $extension, $path, $id)) {
                            var_dump(move_uploaded_file($temp_filename, $path));
                            move_uploaded_file($temp_filename, $path);
                            if (!is_uploaded_file($path)) {
                                DBConnection::rollback();
                                $error = "\nimpossible to add data in the database and to move the file in a temp dir";
                            }
                            DBConnection::commit();
                        } else {
                            DBConnection::rollback();
                            $error = "\nimpossible to add data in the database and to move the file in a temp dir";
                        }*/
                    }
                }
            }
        } else {
            DBConnection::rollback();
        }
    } catch (\Exception $e) {
        DBConnection::rollback();
        $error .= "error : " . $e;
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
