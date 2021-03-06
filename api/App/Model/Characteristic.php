<?php
/**
* Message
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model;

/*
@table characteristic
@group admin
@field name, string
@field value, string
@field common, bool
@field required, bool
@field type, int
*/

class Characteristic extends Bucket\BucketAbstract
{
    const TYPE_INT = 1;
    const TYPE_FLOAT = 2;
    const TYPE_STR = 0;

    private $name;
    private $value; // valeur du champs
    private $common; // appliqué par défaut à l'ensemble des espèces ou non
    private $required; // champs requit à la validation
    private $type; // type de valeur attendue

    function __construct($data = NULL){
        $this->name = '';
        $this->value = NULL;
        $this->common = 0;
        $this->type = self::TYPE_STR;

        parent::__construct($data);
    }

    public function jsonSerialize(){
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'value' => $this->value,
            'common' => $this->common,
            'required' => $this->required,
            'type' => $this->getTypeName(),
            'step' => $this->getStep()
        );
    }

    protected function beforeInsert(){}

    protected function beforeUpdate(){}

    protected function afterInsert(){}

    protected function afterUpdate(){}

    /**
    * Retourne la liste des caractéristiques et leur valeurs pour un animal
    * @param Animal $animal
    * @return array
    */
    public static function getListByAnimal(Animal $animal){
        $sql = "
            SELECT DISTINCT c.id, c.name, common, required, type,
                (SELECT value FROM ".DATABASE_CFG['prefix']."animal_characteristic ac WHERE ac.characteristic_id = c.id AND animal_id = :animal_id) as \"value\",
                (SELECT COALESCE(custom_order, 0) FROM ".DATABASE_CFG['prefix']."species_characteristic_order sco WHERE sco.characteristic_id = c.id AND species_id = :id) as \"custom_order\"
            FROM ".DATABASE_CFG['prefix']."characteristic c
            LEFT JOIN ".DATABASE_CFG['prefix']."species_characteristic sc ON c.id = sc.characteristic_id
            WHERE ((species_id = :id AND common = 0) OR common = 1) AND active = 1
            ORDER BY custom_order ASC, common DESC, c.name ASC
        ";

        return DB::fetchMultipleObject('App\Model\Characteristic', $sql, array(
            [':id', $animal->getSpeciesId(), \PDO::PARAM_INT],
            [':animal_id', $animal->getId(), \PDO::PARAM_INT]
        ));
    }

    /**
    * Retourne la liste des caractéristiques et leur valeurs pour une espèce
    * @param Species $species
    * @return array
    */
    public static function getListBySpecies(Species $species){
        $sql = "
            SELECT DISTINCT c.id, c.name, common, required, type,
                (SELECT COALESCE(custom_order, 0) FROM ".DATABASE_CFG['prefix']."species_characteristic_order sco WHERE sco.characteristic_id = c.id AND species_id = :id) as \"custom_order\"
            FROM ".DATABASE_CFG['prefix']."characteristic c
            LEFT JOIN ".DATABASE_CFG['prefix']."species_characteristic sc ON c.id = sc.characteristic_id
            WHERE ((species_id = :id AND common = 0) OR common = 1) AND active = 1
            ORDER BY custom_order ASC, common DESC, c.name ASC
        ";

        return DB::fetchMultipleObject('App\Model\Characteristic', $sql, array(
            [':id', $species->getId(), \PDO::PARAM_INT]
        ));
    }

    /**
    * Formate la valeur selon son type pour éviter d'avoir des données faussées en base
    * @param mixte $value
    * @return mixte $value
    */
    public function formatValue($value){
        switch($this->getType()){
            case self::TYPE_INT : return (int)$value; break;
            case self::TYPE_FLOAT : return (float)$value; break;
            default : return $value;
        }
    }

    public function setName(string $name){
        $this->name = $name;
    }
    public function setValue($value){
        $this->value = $value;
    }
    public function setCommon(bool $bool){
        $this->common = $bool;
    }
    public function setRequired(bool $bool){
        $this->required = $bool;
    }
    public function setType(int $type){
        $this->type = $type;
    }

    public function getName() : string{
        return $this->name;
    }
    public function getValue(){
        return $this->value;
    }
    public function getCommon() : bool{
        return $this->common;
    }
    public function getRequired() : bool{
        return $this->required;
    }
    public function getType() : int{
        return $this->type;
    }
    public function getTypeName() : string{
        switch($this->type){
            case self::TYPE_INT :
            case self::TYPE_FLOAT :
                return 'number';
                break;

            default :
                return 'text';
        }
    }

    public function getStep() : string{
        switch($this->type){
            case self::TYPE_INT :
                return '1';
                break;

            case self::TYPE_FLOAT :
                return '0.1';
                break;

            default :
                return '';
        }
    }
}
