<?php
/**
* Espèce d'un animal
* @author PORCHER Cédric
*/


namespace App\Model;

/*
@table species
@group admin
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

    /**
    * Ajoute un lien entre une caractéristique et une espèce
    */
    public function link(int $cid){
        DB::exec("INSERT IGNORE INTO ".DATABASE_CFG['prefix']."species_characteristic(species_id, characteristic_id) VALUES(:species_id, :characteristic_id)", array(
            [':characteristic_id', $cid, \PDO::PARAM_INT],
            [':species_id', $this->getId(), \PDO::PARAM_INT]
        ));
    }

    /**
    * Supprime le lien entre une caractéristique et une espèce
    */
    public function unlink(int $cid){
        DB::exec("DELETE FROM ".DATABASE_CFG['prefix']."species_characteristic WHERE species_id = :species_id AND characteristic_id = :characteristic_id", array(
            [':characteristic_id', $cid, \PDO::PARAM_INT],
            [':species_id', $this->getId(), \PDO::PARAM_INT]
        ));
    }


    protected function beforeInsert(){}
    protected function beforeUpdate(){}

    protected function afterInsert(){}
    protected function afterUpdate(){}

    //Getters
    public function getName() : string{
        return $this->name;
    }

    public function getCharacteristics(){
        return Characteristic::getListBySpecies($this);
    }

    // setters
    public function setName(string $name, bool $check = false){
      if($check && empty($name)) $this->addError("name", gettext("Invalid format"));
        else $this->name = $name;
    }
}
