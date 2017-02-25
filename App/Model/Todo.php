<?php
/**
* Todo
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model;

/*
@table todo
@field name, string
@field creator_id, int
@field done, bool
*/

class Todo extends Bucket\BucketAbstract
{
    private $name;
    private $creator_id;
    private $done;

    function __construct($data = NULL){
        $this->name = '';
        $this->done = false;
        $this->creator_id = 0;

        parent::__construct($data);
    }

    public function jsonSerialize(){
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'done' => $this->done,
            'creator_id' => $this->creator_id,
            'creation_date' => $this->creation_date
        );
    }

    protected function beforeInsert(){}

    protected function beforeUpdate(){}

    protected function afterInsert(){}

    protected function afterUpdate(){}


    public function setName(string $name){
        $this->name = $name;
    }
    public function setDone(bool $done){
        $this->done = $done;
    }
    public function setCreatorId(int $id, bool $check = false){
        if($check){
            if($this->isNew()){
                $this->creator_id = $_SESSION['uid'];
            }
        }
        else{
            $this->creator_id = $id;
        }
    }

    public function getName() : string{
        return $this->name;
    }
    public function getDone() : bool{
        return $this->done;
    }
    public function getCreatorId() : int{
        return $this->creator_id;
    }
    public function getCreator() : User{
        return User::getUniqueById($this->creator_id);
    }
}
