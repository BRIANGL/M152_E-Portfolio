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

//on récupère l'id du poste a modifier et si il est vide on r'envoie l'utilisateur a la homepage
if (empty($_GET['idMedia'])) {
    header('location: index.php?page=homepage');
    exit();
}
$nbView = 0;

$nbView = mediaDAO::GetView($_GET['idMedia'])[0];
$nbView++;
mediaDAO::AddView($_GET['idMedia'], $nbView);
echo "success";
