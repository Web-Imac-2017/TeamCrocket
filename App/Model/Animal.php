<?php
/**
* Profil d'un animal
* @author PORCHER Cédric
*/


namespace App\Model;

/*
@table animal
@field name, string
@field species_id, int
@field owner_id, int
@field date_birth, date
@field weight, float
*/

class Animal extends Bucket\BucketAbstract
{
    private $name;
    private $species_id;
    private $owner_id;
    private $date_birth;
    private $weight;

    function __construct($data = NULL){
        $this->name = '';
        $this->species_id = 0;
        $this->owner_id = 0;
        $this->weight = 0;

        parent::__construct($data);
    }

    public function jsonSerialize(){
        return array(
            'id' => $this->id,
            'owner_id' => $this->owner_id,
            'species_id' => $this->species_id,
            'weight' => $this->weight,
            'creation_date' => $this->creation_date
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

    /**
    * Retourne la liste des images associées à l'animal
    */
    public function getImageList() : array{
        $sql = "SELECT i.* FROM ".DATABASE_CFG['prefix']."image i INNER JOIN ".DATABASE_CFG['prefix']."animal_gallery g ON i.id = g.image_id WHERE g.animal_id = :id AND active = 1";
        $data = array(
            [":id", $this->getId(), \PDO::PARAM_INT]
        );
        return (array)DB::fetchMultipleObject("App\Model\Image", $sql, $data);
    }

    //Getters
    public function getName() : string{
        return $this->name;
    }
    public function getSpeciesId() : int{
        return $this->species_id;
    }
    public function getOwnerId() : int{
        return $this->owner_id;
    }
    public function getWeight() : float{
        return $this->weight;
    }
    public function getDateBirth(){
        return $this->date_birth;
    }
    public function getSpecies() : Species{
        return Species::getUniqueById($this->species_id);
    }
    public function getUser() : User{
        return User::getUniqueById($this->owner_id);
    }

    // setters
    public function setName(string $name){
        $this->name = $name;
    }
    public function setSpeciesId(int $species){
        $this->species_id = $species;
    }
    public function setOwnerId(int $proprio){
        $this->owner_id = $proprio;
    }
    public function setWeight(float $wght){
        $this->weight = $wght;
    }
    public function setDateBirth(string $date = NULL){
        $this->date_birth = $date;
    }
}
