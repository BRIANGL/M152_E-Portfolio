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
     * @param [string] $type
     * @param [string] $name
     * @param [string] $thxt
     * @param [string] $path
     * @param [string] $id
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

    public static function AddView($id, $nbView)
    {
        $db = DBConnection::getConnection();
        $sql = "UPDATE `media` SET `nbCliques` = :nbview WHERE `media`.`idMedia` = :id";

        $q = $db->prepare($sql);
        $q->execute(array(
            ':id' => $id,
            ':nbview' => $nbView
        ));
    }

    public static function AddMetadata($id, $metadata)
    {
        $db = DBConnection::getConnection();
        $sql = "INSERT INTO `metadata`(`idMedia`,`metadata`)
        VALUES (:id, :metadata)";

        $q = $db->prepare($sql);
        $q->execute(array(
            ':id' => $id,
            ':metadata' => $metadata
        ));
    }


    /**
     * Undocumented function
     *
     * @param [string] $nomMedia
     * @param [type] $type
     * @param [type] $ext
     * @param [type] $path
     * @param [type] $id
     * @return void
     */
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
        $sql = "SELECT * FROM `media` WHERE `idMedia` = :id";

        $query = DBConnection::getConnection()->prepare($sql);

        $query->execute([
            ':id' => $id,
        ]);
        return $query->fetchall();
        
    }

    public static function read_media_by_Path($path)
    {
        $sql = "SELECT * FROM `media` WHERE `pathImg` = :mypath";

        $query = DBConnection::getConnection()->prepare($sql);

        $query->execute([
            ':mypath' => $path,
        ]);
        return $query->fetchall();
        
    }

    public static function readMediaByIdPost($idPost)
    {
        $sql = "SELECT * FROM `media` WHERE `idPost` = :id ORDER BY `dateCreation` desc";

        $query = DBConnection::getConnection()->prepare($sql);

        $query->execute([
            ':id' => $idPost,
        ]);
        return $query->fetchall();
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
    public static function del_media($idPost)
    {
        $db = DBConnection::getConnection();
        $sql = "DELETE FROM `media` WHERE `media`.`idPost` = :id";
        $q = $db->prepare($sql);
        $q->execute([
            ':id' => $idPost,
        ]);
    }

    public static function del_mediaByIdMedia($idMedia)
    {
        $db = DBConnection::getConnection();
        $sql = "DELETE FROM `media` WHERE `media`.`idMedia` = :id";
        $q = $db->prepare($sql);
        $q->execute([
            ':id' => $idMedia,
        ]);
    }

    public static function readMediaLinkById($idPost)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT `pathImg` FROM `media` WHERE `media`.`idPost` = :id";
        $q = $db->prepare($sql);
        $q->execute([
            ':id' => $idPost,
        ]);
        $result = $q->fetchAll();
        return $result;
    }

    public static function GetView($idMedia)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT `nbCliques` FROM `media` WHERE `media`.`idMedia` = :id";
        $q = $db->prepare($sql);
        $q->execute([
            ':id' => $idMedia,
        ]);
        $result = $q->fetch();
        return $result;
    }
    #endregion
}
