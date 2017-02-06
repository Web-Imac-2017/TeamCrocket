<?php
class BucketSaveException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);

        /*
        TODO : générer des erreurs en fonction du champs dont la valeur ne passe pas la vérification
        */
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
