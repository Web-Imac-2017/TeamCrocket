<?php
/**
* Todo
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model;

/*
@table todo
@field name, string
@field done, bool
*/

class Todo extends Bucket\BucketAbstract
{
    private $name;
    private $done;

    function __construct($data = NULL){
        $this->name = '';
        $this->done = false;

        parent::__construct($data);
    }

    public function jsonSerialize(){
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'done' => $this->done,
            'creation_date' => $this->creation_date
        );
    }

    protected function beforeInsert(){}

    protected function beforeUpdate(){}

    protected function afterInsert(){}

    protected function afterUpdate(){}

    protected static function makeFilter(Bucket\BucketFilter $filter) : string{
        switch($filter){
            case 'name' :
                return $filter->getName() . " LIKE :" . $filter->getName();
            default :
                return $filter->getName() . " = :" . $filter->getName();
        }
    }

    public function setName(string $name){
        $this->name = $name;
    }
    public function setDone(bool $done){
        $this->done = $done;
    }

    public function getName() : string{
        return $this->name;
    }
    public function getDone() : bool{
        return $this->done;
    }
}
