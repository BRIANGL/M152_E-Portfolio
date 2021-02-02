<?php
/*
FICHIER CONTENANT TOUTES LES MÉTHODES EN RAPPORT AVEC LA TABLE "Media"
*/

namespace M152\sql;

use M152\sql\DBConnection;

// resources
require_once("dbConnection.php");
class postDAO
{

    #region Create
    public static function add_post($comment)
    {
        try {
            $date = date("Y-m-d H:i:s");
            $sql = "INSERT INTO `post`(`commentaire`, `dateCreation`)
        VALUES (:comment, :date)";
            $db = DBConnection::getConnection();
            $query = $db->prepare($sql);
            $data = array(":comment" => $comment, ":date" => $date);
            $query->execute($data);
        } catch (\Throwable $th) {
            $th->getMessage();
            return FALSE;
        }
        return $db->lastInsertId();
    }
    #endregion
    #region Read
    public static function readAll_post()
    {
        $sql = "SELECT `idPost`, `commentaire`, `dateCreation`, `dateModification` FROM `post`";

        $query = DBConnection::getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchall();
    }

    public static function readByDate_post($date)
    {
        $sql = "SELECT `idPost` FROM `post` WHERE `dateCreation` = :date;";
        $query = DBConnection::getConnection()->prepare($sql);
        $data = array(":date" => $date);
        $query->execute($data);
        return $query->fetch();
    }
    #endregion
    #region Update
    public static function updateById_post($id, $comment)
    {
        try {
            $date = date(">-m-d H:i:s");
            $sql = "UPDATE `m152`.`post` SET `commentaire`=:comment, `dateModification`=:date WHERE `idPost` = :id";
            $db = DBConnection::getConnection();
            $query = $db->prepare($sql);
            $data = array(":id" => $id, ":date" => $date, ":comment" => $comment);
            $query->execute($data);
        } catch (\Throwable $th) {
            $th->getMessage();
            return FALSE;
        }
        return TRUE;
    }
    #endregion
    #region Delete
    public static function DeleteById_post($id)
    {
        try {
            $sql = "DELETE FROM `m152`.`post` WHERE `idPost` = :id";
            $db = DBConnection::getConnection();
            $data = array(":id" => $id);
            $query = $db->prepare($sql);
            $query->execute($data);
        } catch (\Throwable $th) {
            $th->getMessage();
            return FALSE;
        }
        return TRUE;
    }
    #endregion
}
