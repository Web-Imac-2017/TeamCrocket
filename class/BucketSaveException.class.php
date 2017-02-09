<?php
/**
* Exception personnalisée
* A déclencher lorsqu'à la sauvegarde d'un objet héritant de la classe Bucket contient des erreurs bloquantes
* @author METTER-ROTHAN Jérémie
*/

class BucketSaveException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
