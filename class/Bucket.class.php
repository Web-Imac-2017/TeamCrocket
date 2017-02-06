<?php
define('QUERY_TYPE_INSERT', 1);
define('QUERY_TYPE_UPDATE', 2);

class Bucket
{
    protected $id = 0;

    protected function __construct($data = NULL){
        if(is_array($data)){
            $this->hydrate($data);
        }
    }

    public function hydrate($data = []){
        $class = get_called_class();
        $orm = BucketParser::parse($class);
        $fields = $orm->getFields();

        foreach($data as $key => $value){
            if(!in_array($key, $fields)){
                continue;
            }
            $method = 'set'.ucfirst($key);
            if(method_exists($class, $method)){
                $this->$method($value);
            }
        }
    }


    // édition de l'objet
    private function edit(int $query_type){
        $class = get_called_class();
        $orm = BucketParser::parse($class);
        $pdo = DB::getInstance()->getLink();
        $map = $orm->getMap();


        // on génère la requête SQL
        if($query_type == QUERY_TYPE_INSERT){
            // insertion de données
            $query = "INSERT INTO " . DB_PREFIX . $orm->getTable() . "(".join($orm->getFields(), ", ").") VALUES(".join(array_map(function($field){
                return ":".$field;
            }, $orm->getFields()), ", ").");";
        }
        else{
            // mise à jour de données
            $query = "UPDATE " . DB_PREFIX . $orm->getTable() . " SET ".join(array_map(function($field){
                return $field . " = :". $field;
            }, $orm->getFields()), ", ")." WHERE id = :id;";
        }



        $stmt = $pdo->prepare($query);
        for($i = 0, $n = count($map); $i < $n; $i++){
            $method = "get".ucfirst($map[$i]['name']);

            if(method_exists($class, $method)){
                $stmt->bindValue($map[$i]['name'], $this->$method(), $map[$i]['type']);
            }
        }

        if(!$stmt->execute()){
            throw new Exception("Query failed");
        }
        if($query_type == QUERY_TYPE_INSERT){
            $this->setId($pdo->lastInsertId());
        }
        $stmt->closeCursor();
    }

    public function save(){
        $this->check();

        if($this->isNew()){
            $this->edit(QUERY_TYPE_INSERT);
        }
        else{
            $this->edit(QUERY_TYPE_UPDATE);
        }
    }


    // récupérer des données
    public static function getUniqueById(int $id){
        $class = get_called_class();
        $orm = BucketParser::parse($class);
        $pdo = DB::getInstance()->getLink();
        $result = [];

        $stmt = $pdo->prepare("SELECT * FROM " . DB_PREFIX . $orm->getTable() . " WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if($stmt->execute()){
            $result = $stmt->fetch();
        }
        $stmt->closeCursor();
        return new $class($result);
    }

    public static function getMultiple(int $start = -1, int $amount = -1, string $options = "") : array{
        $class = get_called_class();
        $orm = BucketParser::parse($class);
        $pdo = DB::getInstance()->getLink();
        $results = [];

        $limit = ($start != -1 && $amount != -1) ? "LIMIT :start, :amount" : "";

        $stmt = $pdo->prepare("SELECT * FROM " . DB_PREFIX . $orm->getTable() . " " . $options . " " . $limit);
        if($start != -1 && $amount != -1){
            $stmt->bindValue(':start', $start, PDO::PARAM_INT);
            $stmt->bindValue(':amount', $amount, PDO::PARAM_INT);
        }

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if($stmt->execute()){
            while($result = $stmt->fetch()){
                $results[] = new $class($result);
            }
        }
        $stmt->closeCursor();
        return $results;
    }

    public static function deleteById(int $id, string $options = ""){
        $class = get_called_class();
        $orm = BucketParser::parse($class);
        $pdo = DB::getInstance()->getLink();

        $stmt = $pdo->prepare("DELETE FROM " . DB_PREFIX . $orm->getTable() . " WHERE id = :id " . $options);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $result = $stmt->execute();
        $stmt->closeCursor();
    }


    // setters
    public function setId(int $id){
        $this->id = $id;
    }

    //getters
    public function getId() : int{
        return $this->id;
    }
}
