<?php
/**
* Gestion générique des fonctionnalités CRUD d'un objet
* @author METTER-ROTHAN Jérémie
*/
namespace App\Model\Bucket;

use \App\Model\DB;

abstract class BucketAbstract implements BucketInterface, \JsonSerializable
{
    protected $id;
    protected $creation_date;
    protected $modification_date;
    protected $active;

    protected function __construct($data = NULL){
        $this->id = 0;
        $this->active = 1;

        if(is_array($data)){
            $this->hydrate($data);
        }
    }

    public abstract function jsonSerialize();

    public static function getKeySetter(string $key){
        return 'set'.implode('', array_map('ucfirst', explode('_', $key)));
    }

    public static function getKeyGetter(string $key){
        return 'get'.implode('', array_map('ucfirst', explode('_', $key)));
    }

    public function hydrate(array $data = [], bool $check = false){
        $class = get_called_class();
        $orm = BucketParser::parse($class);

        foreach($data as $key => $value){
            $method = self::getKeySetter($key);
            if(method_exists($class, $method)){
                $this->$method($value, $check);
            }
        }
    }

    /**
    * Construit une requête SQL d'insertion de l'objet courant et l'exécute
    * @return void
    */
    private function insert(){
        $orm = BucketParser::parse(get_called_class());
        $pdo = DB::getInstance()->getLink();

        // insertion de données
        $query = "INSERT INTO " . DATABASE_CFG['prefix'] . $orm->getTable() . "(".join($orm->getMap(), ", ").", creation_date) VALUES(".join(array_map(function($field){
            return ":".$field;
        }, $orm->getMap()), ", ").", NOW());";
        $stmt = $pdo->prepare($query);
        $stmt = $this->bind($orm, $stmt);

        if(!$stmt->execute()){
            throw new BucketException(gettext("Query failed"));
        }
        $this->setId($pdo->lastInsertId());
        $stmt->closeCursor();
    }

    /**
    * Construit une requête SQL de mise à jour de l'objet courant et l'exécute
    * @return void
    */
    private function update(){
        $orm = BucketParser::parse(get_called_class());
        $pdo = DB::getInstance()->getLink();

        // mise à jour de données
        $query = "UPDATE " . DATABASE_CFG['prefix'] . $orm->getTable() . " SET ".join(array_map(function($field){
            return $field . " = :". $field;
        }, $orm->getMap()), ", ").", modification_date = NOW() WHERE id = :id;";
        $stmt = $pdo->prepare($query);

        $stmt = $this->bind($orm, $stmt);
        $stmt->bindValue('id', $this->getId(), \PDO::PARAM_INT);

        if(!$stmt->execute()){
            throw new BucketException(gettext("Query failed"));
        }

        $stmt->closeCursor();
    }

    /**
    * Lie les valeurs de la table à l'objet Bucket
    * @param BucketClass $orm
    * @param PDOStatement $stmt
    */
    private function bind(BucketClass $orm, \PDOStatement $stmt) : \PDOStatement{
        $map = $orm->getMap();

        for($i = 0, $n = count($map); $i < $n; $i++){
            $field = $map[$i];

            $method = self::getKeyGetter($field->getName());

            // on applique le filtre beforeSend (callback) si il existe à la valeur avant l'édition
            if($field->getBeforeSend() != NULL){
                $value = call_user_func($field->getBeforeSend(), $this->$method());
            }
            else{
                $value = $this->$method();
            }

            if(method_exists($this, $method)){
                $type = (is_null($value)) ? \PDO::PARAM_NULL : $field->getType();
                $stmt->bindValue($field->getName(), $value, $type);
            }
        }
        return $stmt;
    }

    public function save(){
        $this->checkPermission();

        if($this->isNew()){
            $this->beforeInsert();
            $this->insert();
            $this->afterInsert();
        }
        else{
            $this->beforeUpdate();
            $this->update();
            $this->afterUpdate();
        }
    }

    public function checkPermission(){
        // vérifie les permissions pour les classes possédant un champs creator_id
        $getCreator = self::getKeyGetter('creator_id');

        if(method_exists($this, $getCreator)){
            // on vérifie que l'utilisateur est connecté
            if($_SESSION['uid'] == 0){
                throw new \Exception(gettext("You must sign in"));
            }

            if(!$this->isNew()){
                // on vérifie que le créateur est bien l'utilisateur connecté
                if($this->$getCreator() != $_SESSION['uid']){
                    throw new \Exception(gettext("Insufficient permission"));
                }
            }
        }
    }

    public function isNew() : bool{
        return (!$this->id);
    }

    /**
    * Permet d'effectuer des actions AVANT insertion des données dans la base
    * @return void
    */
    abstract protected function beforeInsert();

    /**
    * Permet d'effectuer des actions AVANT mise à jour des données dans la base
    * @return void
    */
    abstract protected function beforeUpdate();

    /**
    * Permet d'effectuer des actions APRES insertion des données dans la base
    * @return void
    */
    abstract protected function afterInsert();

    /**
    * Permet d'effectuer des actions APRES mise à jour des données dans la base
    * @return void
    */
    abstract protected function afterUpdate();



    final public static function getUniqueById(int $id){
        $result = [];

        $class = get_called_class();
        if($id == 0){
            return new $class;
        }

        $orm = BucketParser::parse($class);
        $pdo = DB::getInstance()->getLink();

        $stmt = $pdo->prepare("SELECT * FROM " . DATABASE_CFG['prefix'] . $orm->getTable() . " WHERE active = 1 AND id = :id");
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);

        if($stmt->execute()){
            $result = $stmt->fetch();
        }
        $stmt->closeCursor();
        return new $class($result);
    }

    final public static function getMultiple(array $options = []) : array{
        $results = [];

        // traitement des options
        $start = (isset($options['start'])) ? (int)$options['start'] : -1;
        $amount = (isset($options['amount'])) ? (int)$options['amount'] : -1;
        $page = (isset($options['page'])) ? (int)$options['page'] : -1;
        $order = (isset($options['order'])) ? 'ORDER BY ' . $options['order'] : '';
        $filters = (isset($options['filter'])) ? $options['filter'] : [];

        if($page > 0 && $amount > 0){
            $start = ($page - 1) * $amount;
        }

        $filter = implode(' AND ', array_map('static::makeFilter', $filters));
        $limit = ($start != -1 && $amount != -1) ? "LIMIT :start, :amount" : "";



        // traitement requête
        $class = get_called_class();
        $orm = BucketParser::parse($class);
        $pdo = DB::getInstance()->getLink();

        $stmt = $pdo->prepare("SELECT * FROM " . DATABASE_CFG['prefix'] . $orm->getTable() . " WHERE active = 1 " . ($filter != '' ? ' AND ' : '') . $filter . " " . $order . " " . $limit);
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);

        if($start != -1 && $amount != -1){
            $stmt->bindValue(':start', $start, \PDO::PARAM_INT);
            $stmt->bindValue(':amount', $amount, \PDO::PARAM_INT);
        }

        if(isset($options['filter'])){
            foreach($options['filter'] as $filter){
                $stmt->bindValue(':'.$filter->getName(), $filter->getValue(), $filter->getType());
            }
        }

        if($stmt->execute()){
            while($result = $stmt->fetch()){
                $results[] = new $class($result);
            }
        }
        $stmt->closeCursor();
        return $results;
    }

    /**
    * Retourne le filtre formaté pour la requête SQL permettant de récupérer la liste des éléments de la base
    * @param array $filters Tableau d'objets BucketFilter
    * @return string
    */
    protected static function makeFilter(BucketFilter $filter) : string{
        switch($filter){
            default :
                return $filter->getName() . " = :" . $filter->getName();
        }
    }

    final public static function deleteById(int $id, string $options = ""){
        $item = self::getUniqueById($id);
        if($item->getId() == 0){
            throw new \Exception(gettext("Not found"));
        }
        $item->checkPermission();

        $orm = BucketParser::parse(get_called_class());
        $pdo = DB::getInstance()->getLink();

        $stmt = $pdo->prepare("DELETE FROM " . DATABASE_CFG['prefix'] . $orm->getTable() . " WHERE id = :id " . $options);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        $result = $stmt->execute();
        $stmt->closeCursor();
    }


    // setters
    public function setId(int $id){
        $this->id = $id;
    }
    public function setCreationDate($date){
        $this->creation_date = $date;
    }
    public function setModificationDate($date){
        $this->modification_date = $date;
    }
    public function setActive(int $active = 1){
        $this->active = $active;
    }

    //getters
    public function getId() : int{
        return $this->id;
    }
    public function getCreationDate(){
        return $this->creation_date;
    }
    public function getModificationDate(){
        return $this->modification_date;
    }
    public function getActive() : int{
        return $this->active;
    }
}
