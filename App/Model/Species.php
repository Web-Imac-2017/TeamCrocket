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


    /**
    * Fonction de filtrage par défaut à écraser si on veut affiner l'algo
    */
    public static function filter(array $map = []) : array{
        $data = [];
        $condition = "";
        $limit = "";

        $class = get_called_class();
        $orm = Bucket\BucketParser::parse($class);

        if(isset($map['species_id']) && $map['species_id'] != 0){
            $data[] = [':species_id', (int)$map['species_id'], \PDO::PARAM_INT];
            $condition = "AND species_id = :species_id";
        }

        $sql = "SELECT * FROM ".DATABASE_CFG['prefix'].$orm->getTable()." WHERE active = 1 " . $condition . " " . $limit.";";
        return DB::fetchMultipleObject($class, $sql, $data);
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
