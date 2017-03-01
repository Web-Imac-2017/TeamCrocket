<?php
/**
* Comment
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model;

/*
@table animal_comment
@group animal_profile
@field animal_id, int
@field creator_id, int
@field content, string
*/

class Comment extends Bucket\BucketAbstract
{
    private $content;
    private $animal_id;
    private $creator_id;

    function __construct($data = NULL){
        $this->content = '';
        $this->animal_id = 0;
        $this->creator_id = 0;

        parent::__construct($data);
    }

    public function jsonSerialize(){
        return array(
            'id' => $this->id,
            'content' => $this->content,
            'animal_id' => $this->animal_id,
            'creator' => $this->getCreator(),
            'creation_date' => (!empty($this->creation_date)) ? $this->creation_date : gettext('now'),
            'modification_date' => $this->modification_date,
            'is_author' => ($_SESSION['uid'] == $this->creator_id)
        );
    }

    protected function beforeInsert(){
        $this->setCreatorId($_SESSION['uid']);
    }
    protected function beforeUpdate(){}

    protected function afterInsert(){}
    protected function afterUpdate(){}


    public function setContent(string $content){
        $this->content = $content;
    }
    public function setAnimalId(int $id){
        $this->animal_id = $id;
    }
    public function setCreatorId(int $id){
        $this->creator_id = $id;
    }

    public function getContent() : string{
        return $this->content;
    }
    public function getAnimalId() : int{
        return $this->animal_id;
    }
    public function getCreatorId() : int{
        return $this->creator_id;
    }
    public function getCreator() : User{
        return User::getUniqueById($this->creator_id);
    }
}
