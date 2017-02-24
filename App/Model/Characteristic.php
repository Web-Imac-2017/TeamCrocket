<?php
/**
* Message
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model;

/*
@table characteristic
@field name, string
@field value, string
*/

class Characteristic extends Bucket\BucketAbstract
{
    private $name;
    private $value;

    function __construct($data = NULL){
        $this->name = '';
        $this->value = NULL;

        parent::__construct($data);
    }

    public function jsonSerialize(){
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'value' => $this->value
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


    public function setName(string $name){
        $this->name = $name;
    }
    public function setValue($value){
        $this->value = $value;
    }

    public function getName() : string{
        return $this->name;
    }
    public function getValue(){
        return $this->value;
    }
}
