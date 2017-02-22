<?php
/**
* Todo
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model;

/*
@table country
@field iso, string
@field name, string
@field nicename, string
@field iso3, string
@field numcode, int
@field phonecode, int
*/

class Country extends Bucket\BucketAbstract
{
    private $iso;
    private $name;
    private $nicename;
    private $iso3;
    private $numcode;
    private $phonecode;

    function __construct($data = NULL){
        $this->iso = '';
        $this->name = '';
        $this->nicename = '';
        $this->iso3 = '';
        $this->numcode = 0;
        $this->phonecode = 0;

        parent::__construct($data);
    }

    public function jsonSerialize(){
        return array(
            'iso' => $this->iso,
            'name' => $this->name,
            'nicename' => $this->nicename,
            'iso3' => $this->iso3,
            'numcode' => $this->numcode,
            'phonecode' => $this->phonecode
        );
    }

    public static function getCountryIdByISO(string $iso) : int{
        $sql = "SELECT id FROM ".DATABASE_CFG['prefix']."country WHERE iso = :iso AND active = 1 LIMIT 0, 1";
        $data = array(
            [":iso", strtoupper(substr($iso, 0, 2)), \PDO::PARAM_STR]
        );
        return (int)(DB::fetchUnique($sql, $data)['id']);
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


    public function setIso(string $iso){
        $this->iso = $iso;
    }
    public function setName(string $name){
        $this->name = $name;
    }
    public function setNicename(string $nicename){
        $this->nicename = $nicename;
    }
    public function setIso3($iso3){
        $this->iso3 = $iso3;
    }
    public function setNumcode($numcode){
        $this->numcode = $numcode;
    }
    public function setPhonecode(int $phonecode){
        $this->phonecode = $phonecode;
    }

    public function getIso() : string{
        return $this->iso;
    }
    public function getName() : string{
        return $this->name;
    }
    public function getNicename() : string{
        return $this->nicename;
    }
    public function getIso3(){
        return $this->iso3;
    }
    public function getNumcode(){
        return $this->numcode;
    }
    public function getPhonecode() : int{
        return $this->phonecode;
    }
}
