<?php
/**
* MessageGroup
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model;

/*
@table message_group
@group messenger
@field title, string
@field user_a_id, int
@field user_b_id, int
*/

class MessageGroup extends Bucket\BucketAbstract
{
    private $title;
    private $user_a_id;
    private $user_b_id;

    function __construct($data = NULL){
        $this->title = '';
        $this->user_a_id = 0;
        $this->user_b_id = 0;

        parent::__construct($data);
    }

    public function jsonSerialize(){
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'head' => $this->getGroupHeadMessage()
        );
    }

    public function getGroupHeadMessage(){
        $sql = "SELECT * FROM ".DATABASE_CFG['prefix']."message WHERE active = 1 AND group_id = :gid ORDER BY creation_date DESC LIMIT 0, 1";
        $data = array([':gid', $this->id, \PDO::PARAM_INT]);
        return DB::fetchUniqueObject('\App\Model\Message', $sql, $data);
    }

    public function getList(int $update_date = 0){
        $sql = "SELECT * FROM ".DATABASE_CFG['prefix']."message WHERE active = 1 AND group_id = :gid AND creation_date > DATE_FORMAT(FROM_UNIXTIME(:update_date), '%Y-%m-%d %H:%i:%s')";
        $data = array([':gid', $this->id, \PDO::PARAM_INT], [':update_date', $update_date, \PDO::PARAM_INT]);
        return (array)DB::fetchMultipleObject('\App\Model\Message', $sql, $data);
    }

    public static function getUniqueByMembers(int $id1, int $id2) : MessageGroup{
        $sql = "
            SELECT DISTINCT * FROM ".DATABASE_CFG['prefix']."message_group
            WHERE active = 1 AND ((user_a_id = :id1 AND user_b_id = :id2) OR (user_a_id = :id2 AND user_b_id = :id1))
            GROUP BY id LIMIT 0, 1
        ";
        $data = array(
            [':id1', $id1, \PDO::PARAM_INT],
            [':id2', $id2, \PDO::PARAM_INT]
        );

        return new MessageGroup(DB::fetchUnique($sql, $data));
    }

    protected function beforeInsert(){}

    protected function beforeUpdate(){}

    protected function afterInsert(){}

    protected function afterUpdate(){}


    public function setTitle(string $title){
        $this->title = $title;
    }
    public function setUserAId(int $id){
        $this->user_a_id = $id;
    }
    public function setUserBId(int $id){
        $this->user_b_id = $id;
    }

    public function getTitle() : string{
        return $this->title;
    }
    public function getUserAId() : string{
        return $this->user_a_id;
    }
    public function getUserBId() : string{
        return $this->user_b_id;
    }

    public function isMember(App\Model\User $user) : bool{
        return ($user->getId() == $this->user_a_id || $user->getId() == $this->user_b_id);
    }
}
