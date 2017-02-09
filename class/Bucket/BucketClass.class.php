<?php
namespace Bucket;

/**
* Représentation objet d'une classe CRUD parsé avec BucketParser
* @author METTER-ROTHAN Jérémie
*/

class BucketClass
{
    private $table;
    private $map;
    private $fields;

    public function __construct(string $table, array $map = []){
        $this->table = $table;
        $this->map = $map;

        $this->fields = [];
        for($i = 0, $n = count($this->map); $i < $n; $i++){
            $this->fields[] = $this->map[$i]['name'];
        }
    }

    public function getMap() : array{
        return $this->map;
    }
    public function getTable() : string{
        return $this->table;
    }
    public function getFields() : array{
        return $this->fields;
    }
}
