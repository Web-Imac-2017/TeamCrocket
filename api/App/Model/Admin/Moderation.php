<?php
/**
* Administration
* @author PORCHER Cédric
*/

namespace App\Model\Admin;

use App\Model\DB;

class Moderation
{

    protected function beforeInsert(){}
    protected function beforeUpdate(){}

    protected function afterInsert(){
        $this->markBanned(0);
    }
    protected function afterUpdate(){
        $this->markBanned(0);
    }

    public static function getSuspectUser() : array{
        $data = [];

        $sql = "
            SELECT u.*,
                (
                    SELECT COUNT(*)
                    FROM ".DATABASE_CFG['prefix']."image i
                    WHERE dirty = 2 AND i.creator_id = u.id AND i.active = 1
                ) as total
            FROM ".DATABASE_CFG['prefix']."user u
            WHERE u.active = 1
            HAVING total > 0
        ";
        return DB::fetchMultipleObject("App\\Model\\User", $sql, $data);
    }

    public static function getSuspectAnimalByCreator(int $id = 0) : array{
        $sql = "
            SELECT a.*
            FROM ".DATABASE_CFG['prefix']."animal a
            WHERE a.active = 1 AND (a.dirty = 2 OR (SELECT COUNT(i.id) FROM ".DATABASE_CFG['prefix']."animal_gallery ag INNER JOIN ".DATABASE_CFG['prefix']."image i ON i.id = ag.image_id WHERE i.dirty = 2) > 0) AND creator_id = :id
        ";

        return DB::fetchMultipleObject("App\\Model\\Animal", $sql, array([':id', $id, \PDO::PARAM_INT]));
    }
}
