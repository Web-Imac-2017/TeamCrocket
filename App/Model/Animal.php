<?php
/**
* Profil d'un animal
* @author PORCHER Cédric
*/


namespace App\Model;

/*
@table animal
@group animal_profile
@field name, string
@field species_id, int
@field creator_id, int
@field date_birth, date
@field description, string
*/

class Animal extends Bucket\BucketAbstract
{
    private $name;
    private $species_id;
    private $creator_id;
    private $date_birth;
    private $description;

    function __construct($data = NULL){
        $this->name = '';
        $this->species_id = 0;
        $this->creator_id = 0;
        $this->description = "";

        parent::__construct($data);
    }

    public function jsonSerialize(){
        return array(
            'id' => $this->id,
            'creator_id' => $this->creator_id,
            'species_id' => $this->species_id,
            'description' => $this->description,
            'creation_date' => $this->creation_date
        );
    }

    protected function beforeInsert(){
        $this->setCreatorId($_SESSION['uid']);
    }

    protected function beforeUpdate(){}

    protected function afterInsert(){
        $this->saveCharacteristics();
    }
    protected function afterUpdate(){
        $this->saveCharacteristics();
    }

    private function saveCharacteristics(){
        if(!isset($_POST['characteristic'])){
            return;
        }

        $data = [];
        $sql = "
            INSERT INTO ".DATABASE_CFG['prefix']."animal_characteristic (animal_id, characteristic_id, value)
            VALUES(:animal_id, :characteristic_id, :value)
            ON DUPLICATE KEY UPDATE value = :value;
        ";

        $list = Characteristic::getList($this);
        foreach($list as $c){
            $value = $_POST['characteristic'][$c->getId()] ?? '';
            $data[] = array(
                [':animal_id', $this->getId(), \PDO::PARAM_INT],
                [':characteristic_id', $c->getId(), \PDO::PARAM_INT],
                [':value', $c->formatValue($value), \PDO::PARAM_STR]
            );
        }

        DB::execMultiple($sql, $data);
    }

    public function uploadImage(){
        $image = NULL;

        if(isset($_FILES['image_file']) && is_uploaded_file($_FILES['image_file']['tmp_name'])){
            $image = Image::upload($_FILES['image_file'], array(
                'extensions' => array('jpeg', 'jpg', 'png', 'gif'),
                'max_size' => 1048576 * 4
            ));

            if($image instanceof Image){
                $sql = "INSERT IGNORE INTO ".DATABASE_CFG['prefix']."animal_gallery(animal_id, image_id) VALUES(:animal_id, :image_id)";
                $values = array(
                    [':animal_id', $this->getId(), \PDO::PARAM_INT],
                    [':image_id', $image->getId(), \PDO::PARAM_INT]
                );
                DB::exec($sql, $values);
            }
        }
        else{
            throw new \Exception(gettext("No file"));
        }

        return $image;
    }

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
    public function getCreatorId() : int{
        return $this->creator_id;
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
        return User::getUniqueById($this->creator_id);
    }

    // setters
    public function setName(string $name){
        $this->name = $name;
    }
    public function setSpeciesId(int $species){
        $this->species_id = $species;
    }
    public function setCreatorId(int $proprio){
        $this->creator_id = $proprio;
    }
    public function setDescription(string $descr){
        $this->description = $descr;
    }
    public function setDateBirth(string $date = NULL){
        $this->date_birth = $date;
    }
}
