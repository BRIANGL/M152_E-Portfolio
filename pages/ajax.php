<?php
/*
 *  Author  :   Golay Brian
 *  Class   :   P4B
 *  Date    :   2021/01/28
 *  Desc.   :   Edit post page
*/
require_once("./sql/postDAO.php");
require_once("./sql/mediaDAO.php");

use M152\sql\mediaDAO;
use M152\sql\postDAO;
use M152\sql\DBConnection;

//on récupère l'id du poste a modifier et si il est vide on r'envoie l'utilisateur a la homepage
if (empty($_GET['idImg'])) {
    header('location: index.php?page=homepage');
    exit();
}
if (empty($_GET['IdPoste'])) {
    header('location: index.php?page=homepage');
    exit();
}
//on met l'id dans une variable
$idImg = $_GET['idImg'];
$idPoste = $_GET['IdPoste'];


//si il y a eu une demande de suppression on démarre une transaction et on supprime les images
if (!empty($idImg)) {
    DBConnection::startTransaction();
    try {
        $linkMediaToDelete = mediaDAO::read_media_by_id($idImg)[0]['pathImg'];
        mediaDAO::del_mediaByIdMedia($idImg);
        unlink($linkMediaToDelete);
        postDAO::updateDateModificationById_post($idPoste);
        DBConnection::commit(); //si tout se passe bien, on commit les changements a la base de donnée
    } catch (\Throwable $th) {
        DBConnection::rollback(); //si il y a une erreur, on annule les changements
        echo "Rollback";
    }
}



/**
 * displayPost
 *
 * @param [int] $idPost
 * @return string tout l'html du poste
 */
function displayPost($idPost)
{
    $display = '';

    $data = postDAO::readpostById($idPost);
    $media = mediaDAO::readMediaByIdPost($idPost);
    $display = "";
    $tmp_name = "";
    $tmp_ext = "";
    $tmp_path = "";
    // list all the authorised extension
    $extensions = array(
        "image" => array('png', 'gif', 'jpg', 'jpeg'),
        "video" => array('mp4', 'webm'),
        "audio" => array('mp3', 'wav', 'ogg', 'x-wav', 'mpeg')
    );
    foreach ($data as $num) {
        $display .= '<div class="panel panel-default"><table border="1">';
        foreach ($num as $key => $value) {
            switch ($key) {
                case 'idMedia':
                    foreach ($media as $num_) {
                        foreach ($num_ as $key_ => $value_) {
                            switch ($key_) {
                                case 'extension':
                                    $tmp_ext = $value_;
                                    break;
                                case 'nameMedia':
                                    $tmp_name = $value_;
                                    break;
                                case 'pathImg':
                                    $tmp_path = $value_;
                                    break;
                                case 'idPost':
                                    if ($value_ == $value) {
                                        if (in_array($tmp_ext, $extensions['image'])) {
                                            # image
                                            $display .= "<tr><td><div class='panel-thumbnail'><img name='" . $tmp_name . "' src='" . $tmp_path . "' class='img-responsive'></div></td><td><button name='delete' value='" . $num_["idMedia"] . "' onclick='deleteJS(" . $num_["idMedia"] . ")'>X</button></td></tr>";
                                        } else if (in_array($tmp_ext, $extensions['video'])) {
                                            # video
                                            $display .= '<tr><td><video preload="metadata" width="100%" controls autoplay loop>
                                                <source src="./' . $tmp_path . '" type="video/mp4">
                                                Your browser does not support the video tag.
                                                </video>
                                            </li><p><strong>Note: </strong>The video tag is not supported in Internet Explorer 8 and earlier versions.</p></li></td><td><button name="delete" value="' . $num_["idMedia"] . '" onclick="deleteJS(' . $num_["idMedia"] . ')">X</button></td></tr>';
                                        } else if (in_array($tmp_ext, $extensions['audio'])) {
                                            # audio
                                            $display .= '<tr><td><audio controls preload="metadata">
                                            <source src="./' . $tmp_path . '" type="audio/' . $tmp_ext . '">
                                            Your browser does not support the audio element.
                                            </audio></li></td><td><button name="delete" value="' . $num_["idMedia"] . '" onclick="deleteJS(' . $num_["idMedia"] . ')">X</button></td></tr>';
                                        }
                                    }
                                    break;
                            }
                        }
                    }
                    break;

                case 'commentaire':

                    $display .= "<tr><td><div class=\"panel-body\"><p class=\"lead\">" . $value . "</p></td></tr>";
                    break;

                case 'dateModifiaction':
                    $display .= "<p>" . (($value != NULL) ? $value : "") . "</p>";
                    break;
                    $display .= "</div>";
            }
        }
        $display .= "<tr></tr></div></table><input type='hidden' value='" . $idPost . "' id='idPoste'></div>";
    }
    return $display;
}
echo displayPost($idPoste);
