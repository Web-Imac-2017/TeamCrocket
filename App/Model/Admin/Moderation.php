<?php
/**
* Administration
* @author PORCHER Cédric
*/

namespace App\Model\Admin;

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
        return (array)\App\Model\DB::fetchMultipleObject("App\\Model\\User", $sql, $data);
    }

    public static function getSuspectAnimal() : array{
        $data = [];

        $sql = "
            SELECT u.*,
                (
                    SELECT COUNT(*)
                    FROM ".DATABASE_CFG['prefix']."animal a
                    WHERE a.dirty = 2 AND a.creator_id = u.id AND a.active = 1
                ) as total
            FROM ".DATABASE_CFG['prefix']."user u
            WHERE u.active = 1
            HAVING total > 0
        ";

        var_dump($sql);
        return (array)\App\Model\DB::fetchMultipleObject("App\\Model\\Animal", $sql, $data);
    }
}
