<?php
/*
FICHIER CONTENANT TOUTES LES MÉTHODES EN RAPPORT AVEC LA TABLE "Post"
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
        $sql = "SELECT `idPost`, `commentaire`, `dateCreation`, `dateModification` FROM `post` ORDER BY `dateCreation` desc";

        $query = DBConnection::getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchall();
    }

    public static function readpostById($idPost)
    {
        $sql = "SELECT `idPost`, `commentaire`, `dateCreation`, `dateModification` FROM `post` WHERE `idPost` = :id ORDER BY `dateCreation` desc";

        $query = DBConnection::getConnection()->prepare($sql);

        $query->execute([
            ':id' => $idPost,
        ]);
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
        $date = date("Y-m-d H:i:s");
        $db = DBConnection::getConnection();
        $sql = "UPDATE `m152`.`post` SET `commentaire`=:comment, `dateModification`=:date WHERE `idPost` = :id";
        $q = $db->prepare($sql);
        $q->execute([
            ":id" => $id,
            ":date" => $date,
            ":comment" => $comment
        ]);
    }

    public static function updateDateModificationById_post($id)
    {
        $date = date("Y-m-d H:i:s");
        $db = DBConnection::getConnection();
        $sql = "UPDATE `m152`.`post` SET `dateModification`=:date WHERE `idPost` = :id";
        $q = $db->prepare($sql);
        $q->execute([
            ":id" => $id,
            ":date" => $date,
        ]);
    }
    #endregion
    #region Delete
    public static function DeleteById_post($id)
    {
        $db = DBConnection::getConnection();
        $sql = "DELETE FROM `post` WHERE `post`.`idPost` = :id";
        $q = $db->prepare($sql);
        $q->execute([
            ':id' => $id,
        ]);
    }
    #endregion
}
