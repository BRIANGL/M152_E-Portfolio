<?php
/*
FICHIER CONTENANT TOUTES LES MÉTHODES EN RAPPORT AVEC LA TABLE "Media"
*/

namespace M152\sql;

use M152\sql\DBConnection;

// resources
require_once("dbConnection.php");
require_once("postDAO.php");


class MediaDAO
{
    #region Create
    /**
     * Function to add media
     *
     * @param [type] $type
     * @param [type] $name
     * @param [type] $thxt
     * @param [type] $path
     * @param [type] $id
     * @return void
     */
    public static function add_media($type, $name, $thxt, $path, $id)
    {
        try {
            $date = date("Y-m-d H:i:s");
            $sql = "INSERT INTO `media`(`typeMedia`,`extension`, `nameMedia`, `dateCreation`, `pathImg`,`idPost`)
        VALUES (:type, :ext, :name, :date,:path, :fk)";
            $db = DBConnection::getConnection();
            $db->beginTransaction();
            $query = $db->prepare($sql);

            $data = array(
                ":type" => $type,
                ":ext" => $thxt,
                ":name" => $name,
                ":path" => $path,
                ":fk" => $id,
                ":date" => $date
            );
            $query->execute($data);
            $db->commit();
            return TRUE;
        } catch (\Throwable $th) {
            $db->rollBack();
            var_dump($th);
            $th->getMessage();
            return FALSE;
        }
    }

    public static function changePath($name, $tempname)
    {
        $db = DBConnection::getConnection();
        $sql = "UPDATE `media` SET `pathImg` = :named WHERE `media`.`pathImg` = :tempname";

        $q = $db->prepare($sql);
        $q->execute(array(
            ':named' => $name,
            ':tempname' => substr($tempname, 0, 2)
        ));
    }


    public static function addmedia($nomMedia, $type, $ext, $path, $id)
    {
        $date = date("Y-m-d H:i:s");
        $db = DBConnection::getConnection();
        $sql = "INSERT INTO `media`(`typeMedia`,`extension`, `nameMedia`, `dateCreation`, `pathImg`,`idPost`)
        VALUES (:type, :ext, :name, :date,:path, :fk)";
        $q = $db->prepare($sql);
        $q->execute(array(
            ":type" => $type,
            ":ext" => $ext,
            ":name" => $nomMedia,
            ":path" => $path,
            ":fk" => $id,
            ":date" => $date
        ));
    }


    #endregion
    #region Read
    public static function readAll_media()
    {
        try {
            $sql = "SELECT * FROM `media`";
            $db =  DBConnection::getConnection();
            $db->beginTransaction();
            $query = $db->prepare($sql);

            $query->execute();
            $db->commit();
            return $query->fetchAll();
        } catch (\Throwable $th) {
            $th->getMessage();
            $db->rollBack();
        }
    }

    public static function read_media_by_id($id)
    {
        try {
            $sql = "SELECT `idMedia`, `typeMedia`, `nameMedia`, `dateCreation`, `Dttm_Modification_Media` FROM `media` WHERE `idMedia` = :id";
            $data = array(':id' => $id);
            $db =  DBConnection::getConnection();
            $db->beginTransaction();
            $query = $db->prepare($sql);
            $query->execute($data);
            $db->commit();
            return $query->fetch();
        } catch (\Throwable $th) {
            $th->getMessage();
            $db->rollBack();
            return FALSE;
        }
    }

    public static function read_media_by_name($name)
    {
        try {
            $sql = "SELECT `idMedia`, `typeMedia`, `nameMedia`, `dateCreation`, `Dttm_Modification_Media` FROM `media` WHERE `nameMedia` = :name";
            $data = array(':name' => $name);
            $db =  DBConnection::getConnection();
            $db->beginTransaction();
            $query = DBConnection::getConnection()->prepare($sql);
            $query->execute($data);
            $db->commit();
            return $query->fetch();
        } catch (\Throwable $th) {
            $th->getMessage();
            $db->rollBack();
            return FALSE;
        }
    }

    public static function read_media_by_type($type)
    {
        try {
            $sql = "SELECT `idMedia`, `typeMedia`, `nameMedia`, `dateCreation`, `Dttm_Modification_Media` FROM `media` WHERE `typeMedia` = :type";
            $data = array(':type' => $type);
            $db =  DBConnection::getConnection();
            $db->beginTransaction();
            $query = $db->prepare($sql);
            $query->execute($data);
            $db->commit();
            return $query->fetchall();
        } catch (\Throwable $th) {
            $th->getMessage();
            $db->rollBack();
            return FALSE;
        }
    }

    public static function read_media_by_crea($date)
    {
        try {
            $sql = "SELECT `idMedia`, `typeMedia`, `nameMedia`, `dateCreation`, `Dttm_Modification_Media` FROM `media` WHERE `dateCreation` = :date";
            $data = array(':date' => $date);
            $db =  DBConnection::getConnection();
            $db->beginTransaction();
            $query = $db->prepare($sql);
            $query->execute($data);
            $db->commit();
            return $query->fetchall();
        } catch (\Throwable $th) {
            $th->getMessage();
            $db->rollBack();
            return FALSE;
        }
    }

    public static function read_media_by_modif($date)
    {
        try {
            $sql = "SELECT `idMedia`, `typeMedia`, `nameMedia`, `dateCreation`, `Dttm_Modification_Media` FROM `media` WHERE `Dttm_Modification_Media` = :date";
            $data = array(':date' => $date);
            $db =  DBConnection::getConnection();
            $db->beginTransaction();
            $query = $db->prepare($sql);
            $query->execute($data);
            $db->commit();
            return $query->fetchall();
        } catch (\Throwable $th) {
            $th->getMessage();
            $db->rollBack();
            return FALSE;
        }
    }

    #endregion
    #region Update

    #endregion
    #region Delete
    public static function del_media($idMedia)
    {
        try {
            $sql = "DELETE FROM `media` WHERE `id` = ':id';";
            $data = array(':id' => $idMedia);
            $db =  DBConnection::getConnection();
            $db->beginTransaction();
            $query = $db->prepare($sql);
            $query->execute($data);
            $db->commit();
            return $query->fetchAll();
        } catch (\Throwable $th) {
            $th->getMessage();
            $db->rollBack();
            return FALSE;
        }
    }
    #endregion
}
