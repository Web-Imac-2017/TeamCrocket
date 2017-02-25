<?php
/**
* Représentation objet d'une classe CRUD parsé avec BucketParser
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model\Bucket;

class BucketClass
{
    private $table; // nom de la table
    private $group; // groupe de permissions
    private $map; // map de la table

    public function __construct(string $table, string $group, array $map = []){
        $this->table = $table;
        $this->group = $group;
        $this->map = $map;
    }

    public function getMap() : array{
        return $this->map;
    }
    public function getTable() : string{
        return $this->table;
    }
    public function getGroup() : string{
        return $this->group;
    }
}
