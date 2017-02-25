<?php
/**
* Espèce d'un animal
* @author PORCHER Cédric
*/


namespace App\Model;

/*
@table species
@group animal_profile
@field name, string
*/

class Species extends Bucket\BucketAbstract
{
    private $name = "";

    function __construct($data = NULL){
        parent::__construct($data);
    }

    public function jsonSerialize(){
        return array(
            'id' => $this->id,
            'name' => $this->name
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

    //Getters
    public function getName() : string{
        return $this->name;
    }

    // setters
    public function setName(string $name, bool $check = false){
      if($check && empty($name)) $this->addError("name", gettext("Invalid format"));
        else $this->name = $name;
    }
}
