<?php
/**
* Classe permettant de décrire un filtre
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model\Bucket;

class BucketFilter extends BucketField
{
    private $value;

    public function __construct(string $name, string $value, int $type, $beforeSend = NULL){
        parent::__construct($name, $type, $beforeSend);
        $this->value = $value;
    }

    public function getValue(){
        if(is_callable($this->beforeSend)){
            return call_user_func($this->beforeSend, $this->value);
        }
        else{
            return $this->value;
        }
    }
}
