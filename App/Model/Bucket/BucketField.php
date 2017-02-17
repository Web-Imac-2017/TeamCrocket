<?php
/**
* Classe permettant de décrire un champ de la base de donnée
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model\Bucket;

class BucketField
{
    protected $name;
    protected $type;
    protected $beforeSend;

    public function __construct(string $name, int $type, $beforeSend = NULL){
        $this->name = $name;
        $this->type = $type;
        $this->beforeSend = $beforeSend;
    }

    public function getName(){ return $this->name; }
    public function getType(){ return $this->type; }
    public function getBeforeSend(){ return $this->beforeSend; }

    public function __toString(){
        return $this->name;
    }
}
