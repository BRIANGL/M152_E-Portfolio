<?php
/*
 *  Author  :   Golay Brian
 *  Class   :   P4B
 *  Date    :   2021/01/28
 *  Desc.   :   Edit post page
*/
error_reporting(0);
require_once("./sql/postDAO.php");
require_once("./sql/mediaDAO.php");

use M152\sql\mediaDAO;
use M152\sql\postDAO;
use M152\sql\DBConnection;


if (empty($_GET['id'])) {
    header('location: index.php?page=homepage');
    exit();
}

$id = $_GET['id'];
if (isset($_POST['delete'])) {
    $idMediaToDelete = $_POST['delete'];
}



if (!empty($idMediaToDelete)) {
    //var_dump($idMediaToDelete);
    DBConnection::startTransaction();
    try {
        foreach ($idMediaToDelete as $key => $value) {
            $linkMediaToDelete = mediaDAO::read_media_by_id($value)['pathImg'];
            mediaDAO::del_mediaByIdMedia($value);
            unlink($linkMediaToDelete);
        }
        DBConnection::commit();
    } catch (\Throwable $th) {
        DBConnection::rollback();
        echo "Rollback";
    }


}




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
        $display .= '<div class="panel panel-default"><form method="POST" action=""><table border="1">';
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
                                            $display .= "<tr><td><div class='panel-thumbnail'><img name='" . $tmp_name . "' src='" . $tmp_path . "' class='img-responsive'></div></td><td><input type='checkbox' id='delete' name='delete[]' value='" . $num_["idMedia"] . "'></td></tr>";
                                        } else if (in_array($tmp_ext, $extensions['video'])) {
                                            # video
                                            $display .= '<tr><td><video preload="metadata" width="100%" controls autoplay loop>
                                                <source src="./' . $tmp_path . '" type="video/mp4">
                                                Your browser does not support the video tag.
                                                </video>
                                            </li><p><strong>Note: </strong>The video tag is not supported in Internet Explorer 8 and earlier versions.</p></li></td><td><input type="checkbox" id="delete" name="delete[]" value="' . $num_["idMedia"] . '"></td></tr>';
                                        } else if (in_array($tmp_ext, $extensions['audio'])) {
                                            # audio
                                            $display .= '<tr><td><audio controls preload="metadata">
                                            <source src="./' . $tmp_path . '" type="audio/' . $tmp_ext . '">
                                            Your browser does not support the audio element.
                                            </audio></li></td><td><input type="checkbox" id="delete" name="delete[]" value="' . $num_["idMedia"] . '"></td></tr>';
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
        $display .= "<tr><td><input type='submit' value='Supprimer le(s) média(s) séléctionné(s)'></td></tr></div></table></form></div>";
    }
    return $display;
}


?>