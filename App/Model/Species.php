<?php
/**
* Espèce d'un animal
* @author PORCHER Cédric
*/


namespace App\Model;

/*
@table species
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


    public function getCharacteristicList(Animal $animal){
        $sql = "
            SELECT DISTINCT c.id, c.name, ac.value FROM ".DATABASE_CFG['prefix']."characteristic c
            LEFT JOIN ".DATABASE_CFG['prefix']."animal_characteristic ac ON c.id = ac.characteristic_id
            RIGHT JOIN ".DATABASE_CFG['prefix']."species_characteristic sc ON c.id = sc.characteristic_id
            WHERE species_id = :id AND (animal_id = :animal_id OR animal_id IS NULL) AND active = 1
        ";
        return DB::fetchMultipleObject('App\Model\Characteristic', $sql, array(
            [':id', $this->getId(), \PDO::PARAM_INT],
            [':animal_id', $animal->getId(), \PDO::PARAM_INT]
        ));
    }

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
