<?php
/**
* Génère des erreurs en fonction du champs dont la valeur ne passe pas la vérification
* @author METTER-ROTHAN Jérémie
*/

class BucketError
{
    private $class;
    private $property;
    private $message;

    public function __construct(string $class, string $property, string $message = ""){
        $this->property = $property;
        $this->class = $class;
        $this->message = $message;
    }

    public function __toString() {
        return "[{$this->class}][{$this->property}]: {$this->message}";
    }

    public function getClass(){
        return $this->class;
    }
    public function getProperty(){
        return $this->property;
    }
    public function getMessage(){
        return $this->message;
    }
}
