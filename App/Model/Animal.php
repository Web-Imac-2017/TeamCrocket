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
@field description, string
*/

class Animal extends Bucket\BucketAbstract
{
    private $name;
    private $species_id;
    private $owner_id;
    private $date_birth;
    private $description;

    function __construct($data = NULL){
        $this->name = '';
        $this->species_id = 0;
        $this->owner_id = 0;
        $this->description = "";

        parent::__construct($data);
    }

    public function jsonSerialize(){
        return array(
            'id' => $this->id,
            'owner_id' => $this->owner_id,
            'species_id' => $this->species_id,
            'description' => $this->description,
            'creation_date' => $this->creation_date
        );
    }

    protected function beforeInsert(){
        if($_SESSION['uid'] == 0){
            throw new \Exception("You must sign in");
        }
        $this->setOwnerId($_SESSION['uid']);

        $this->checkImage();
    }

    protected function beforeUpdate(){
        if($_SESSION['uid'] == 0){
            throw new \Exception("You must sign in");
        }

        $this->checkImage();
    }

    private function checkImage(){
        if(isset($_FILES['image_file'])){
            $image = Image::upload($_FILES['image_file'], array(
                'extensions' => array('jpeg', 'jpg', 'png', 'gif'),
                'max_size' => 1048576 * 4
            ));

            if($image->getId() > 0){
                $sql = "INSERT IGNORE INTO ".DATABASE_CFG['prefix']."animal_gallery(animal_id, image_id) VALUES(:animal_id, :image_id)";
                $values = array(
                    [':animal_id', $this->getId(), \PDO::PARAM_INT],
                    [':image_id', $image->getId(), \PDO::PARAM_INT]
                );
                DB::exec($sql, $values);
            }
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
    public function getDateBirth(){
        return $this->date_birth;
    }
    public function getDescription() : string{
        return $this->description;
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
    public function setDescription(string $descr){
        $this->description = $descr;
    }
    public function setDateBirth(string $date = NULL){
        $this->date_birth = $date;
    }
}
