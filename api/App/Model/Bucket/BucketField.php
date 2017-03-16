<?php
/**
* Classe permettant de décrire un champ de la base de donnée
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model\Bucket;

class BucketField
{
    const ACCESS_LEVEL_USER = 0;
    const ACCESS_LEVEL_ADMIN = 1;

    protected $name;
    protected $type;
    protected $access_level;

    public function __construct(string $name, int $type, int $access_level){
        $this->name = $name;
        $this->type = $type;
        $this->access_level = $access_level;
    }

    public function getName(){ return $this->name; }
    public function getType(){ return $this->type; }
    public function getAccessLevel(){ return $this->access_level; }

    public function __toString(){
        return $this->name;
    }
}
