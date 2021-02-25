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


$mediaToDelete = "";

if (!empty($_GET['id'])) {
    DBConnection::startTransaction();
    $idPost = $_GET['id'];

    try {
        $mediaToDelete = mediaDAO::readMediaLinkById($idPost);
        mediaDAO::del_media($idPost);
        postDAO::DeleteById_post($idPost);
        foreach ($mediaToDelete as $key => $value) {
            unlink($value['pathImg']);
        }
        DBConnection::commit();
        header("location: index.php?page=homepage");
        exit();
    } catch (\Throwable $th) {
        DBConnection::rollback();
        echo "Rollback";
    }
}
