<?php
/**
* Message
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model;

/*
@table message
@group messenger
@field content, string
@field group_id, int
@field creator_id, int
*/

class Message extends Bucket\BucketAbstract
{
    private $content;
    private $group_id;
    private $creator_id;

    function __construct($data = NULL){
        $this->content = '';
        $this->group_id = 0;
        $this->creator_id = 0;

        parent::__construct($data);
    }

    public function jsonSerialize(){
        return array(
            'id' => $this->id,
            'content' => $this->content,
            'group_id' => $this->group_id,
            'author' => $this->getAuthor(),
            'creation_date' => $this->creation_date,
            'modification_date' => $this->modification_date,
            'is_author' => ($_SESSION['uid'] == $this->creator_id)
        );
    }

    protected function beforeInsert(){}

    protected function beforeUpdate(){}

    protected function afterInsert(){}

    protected function afterUpdate(){}


    public function setContent(string $content){
        $this->content = $content;
    }
    public function setGroupId(int $id){
        $this->group_id = $id;
    }
    public function setCreatorId(int $id){
        $this->creator_id = $id;
    }

    public function getContent() : string{
        return $this->content;
    }
    public function getGroupId() : int{
        return $this->group_id;
    }
    public function getCreatorId() : int{
        return $this->creator_id;
    }
    public function getAuthor() : User{
        return User::getUniqueById($this->creator_id);
    }
}
