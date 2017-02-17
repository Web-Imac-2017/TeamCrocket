<?php
/**
* Représentation objet d'une classe CRUD parsé avec BucketParser
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model\Bucket;

class BucketClass
{
    private $table;
    private $map;

    public function __construct(string $table, array $map = []){
        $this->table = $table;
        $this->map = $map;
    }

    public function getMap() : array{
        return $this->map;
    }
    public function getTable() : string{
        return $this->table;
    }
}
