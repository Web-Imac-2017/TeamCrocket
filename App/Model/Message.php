<?php
/**
* Message
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model;

/*
@table message
@field content, string
@field group_id, int
@field author_id, int
*/

class Message extends Bucket\BucketAbstract
{
    private $content;
    private $group_id;
    private $author_id;

    function __construct($data = NULL){
        $this->content = '';
        $this->group_id = 0;
        $this->author_id = 0;

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
            'is_author' => ($_SESSION['uid'] == $this->author_id)
        );
    }

    protected function beforeInsert(){
        if($_SESSION['uid'] == 0){
            throw new \Exception("You must sign in");
        }
    }

    protected function beforeUpdate(){
        if($_SESSION['uid'] == 0){
            throw new \Exception("You must sign in");
        }
    }

    protected function afterInsert(){}

    protected function afterUpdate(){}


    public function setContent(string $content){
        $this->content = $content;
    }
    public function setGroupId(int $id){
        $this->group_id = $id;
    }
    public function setAuthorId(int $id){
        $this->author_id = $id;
    }

    public function getContent() : string{
        return $this->content;
    }
    public function getGroupId() : int{
        return $this->group_id;
    }
    public function getAuthorId() : int{
        return $this->author_id;
    }
    public function getAuthor() : User{
        return User::getUniqueById($this->author_id);
    }
}
