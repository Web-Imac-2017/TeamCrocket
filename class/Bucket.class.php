<?php
/**
* Gestion générique des fonctionnalités CRUD d'un objet
* @author METTER-ROTHAN Jérémie
*/

define('QUERY_TYPE_INSERT', 1);
define('QUERY_TYPE_UPDATE', 2);

abstract class Bucket
{
    protected $id = 0;
    protected $creation_date;
    protected $modification_date;
    protected $active = 1;
    private $errorlist = [];

    protected function __construct($data = NULL){
        if(is_array($data)){
            $this->hydrate($data);
        }
    }

    public function isNew() : bool{
        return (!$this->id);
    }


    public function hydrate(array $data = []){
        $class = get_called_class();
        $orm = BucketParser::parse($class);
        $fields = $orm->getFields();

        foreach($data as $key => $value){
            /*
            if(!in_array($key, $fields) && $key != 'creation_date' && $key != 'modification_date'){
                continue;
            }
            */
            $method = 'set'.ucfirst($key);
            if(method_exists($class, $method)){
                $this->$method($value);
            }
        }
    }

    /**
    * Construit une requête SQL d'insertion ou de mise à jour de l'objet courant et l'exécute
    * @param int $query_type Constante définissant le mode INSERT / UPDATE de la requête
    * @return void
    */
    private function edit(int $query_type){
        $class = get_called_class();
        $orm = BucketParser::parse($class);
        $pdo = DB::getInstance()->getLink();
        $map = $orm->getMap();


        // on génère la requête SQL
        if($query_type == QUERY_TYPE_INSERT){
            // insertion de données
            $query = "INSERT INTO " . DB_PREFIX . $orm->getTable() . "(".join($orm->getFields(), ", ").", creation_date) VALUES(".join(array_map(function($field){
                return ":".$field;
            }, $orm->getFields()), ", ").", NOW());";
        }
        else{
            // mise à jour de données
            $query = "UPDATE " . DB_PREFIX . $orm->getTable() . " SET ".join(array_map(function($field){
                return $field . " = :". $field;
            }, $orm->getFields()), ", ").", modification_date = NOW() WHERE id = :id;";
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

        // on vérifie qu'il n'y a aucune erreur bloquante empêchant d'exécuter la requête
        if(count($this->errorlist) == 0){
            try{
                if($this->isNew()){
                    $this->edit(QUERY_TYPE_INSERT);
                }
                else{
                    $this->edit(QUERY_TYPE_UPDATE);
                }
            } catch(PDOException $e){
                /**
                * TODO : Gérer les autres cas
                */
                switch($e->getCode()){
                    case "23000" :
                        $this->addError("db", "duplicate entry");
                        break;
                }
            }
        }

        // on affiche TOUTES les erreurs
        if(count($this->errorlist) > 0){
            throw new BucketSaveException("Could not save, check error list for more details");
        }
    }


    final public static function getUniqueById(int $id){
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

    final public static function getMultiple(int $start = -1, int $amount = -1, string $options = "") : array{
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

    final public static function deleteById(int $id, string $options = ""){
        $class = get_called_class();
        $orm = BucketParser::parse($class);
        $pdo = DB::getInstance()->getLink();

        $stmt = $pdo->prepare("DELETE FROM " . DB_PREFIX . $orm->getTable() . " WHERE id = :id " . $options);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $result = $stmt->execute();
        $stmt->closeCursor();
    }


    public function addError(string $property, string $message = ""){
        $this->errorlist[] = new BucketError(get_called_class(), $property, $message);
    }

    public function showErrors(){
        $errorlist = $this->getErrorlist();
        echo "Errors : \n";
        foreach($errorlist as $error){
            echo $error."\n";
        }
        echo "\n";
    }


    // setters
    public function setId(int $id){
        $this->id = $id;
    }
    public function setCreation_date($date){
        $this->creation_date = $date;
    }
    public function setModification_date($date){
        $this->modification_date = $date;
    }
    public function setActive(int $active = 1){
        $this->active = $active;
    }

    //getters
    public function getId() : int{
        return $this->id;
    }
    public function getCreation_date(){
        return $this->creation_date;
    }
    public function getModification_date(){
        return $this->modification_date;
    }
    public function getActive() : int{
        return $this->active;
    }
    public function getErrorlist() : array{
        return $this->errorlist;
    }
}
