<?php
/**
* Gestion générique des fonctionnalités CRUD d'un objet
* @author METTER-ROTHAN Jérémie
*/
namespace App\Model\Bucket;

use \App\Model\DB;
use \App\Model\User;

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
        global $_USER;

        $class = get_called_class();
        $orm = BucketParser::parse($class);

        foreach($data as $key => $value){
            $method = self::getKeySetter($key);
            if(method_exists($class, $method)){
                $this->$method($value, $check);
            }
        }
    }

    public function markDirty(int $dirty = 0){
        $orm = BucketParser::parse(get_called_class());

        $date = ($dirty == 1) ? "date_last_moderation = NOW(), " : "";
        $sql = "UPDATE ".DATABASE_CFG['prefix']."{$orm->getTable()} SET {$date} dirty = :dirty WHERE id = :id";
        $values = array(
            [':id', $this->getId(), \PDO::PARAM_INT],
            [':dirty', $dirty, \PDO::PARAM_INT]
        );

        DB::exec($sql, $values);
    }

    public static function getDirtyList() : array{
        $class = get_called_class();
        $orm = BucketParser::parse($class);

        $sql = "SELECT * FROM ".DATABASE_CFG['prefix']."{$orm->getTable()} WHERE dirty = 0 AND active = 1";
        return (array)DB::fetchMultipleObject($class, $sql);
    }


    /**
    * Construit une requête SQL d'insertion de l'objet courant et l'exécute
    * @return void
    */
    private function insert(bool $bypass = false){
        global $_USER;

        $orm = BucketParser::parse(get_called_class());
        $pdo = DB::getInstance()->getLink();

        if(!$bypass){
            if(!$_USER->hasPermission($orm->getGroup(), User::PERMISSION_CREATE)){
                throw new BucketException(sprintf(gettext("Insufficient permission [%s][%s]"), $orm->getGroup(), User::PERMISSION_CREATE));
            }
        }

        // retire de la liste les champs protégés
        $temp = $orm->getMap();
        $map = [];
        for($i = 0, $n = count($temp); $i < $n; $i++){
            if($temp[$i]->getAccessLevel() === BucketField::ACCESS_LEVEL_ADMIN && !$_USER->isAdmin($orm->getGroup())){
                continue;
            }
            $map[] = $temp[$i];
        }

        // insertion de données
        $query = "INSERT INTO " . DATABASE_CFG['prefix'] . $orm->getTable() . "(".join($map, ", ").", creation_date) VALUES(".join(array_map(function($field){
            return ":".$field;
        }, $map), ", ").", NOW());";
        $stmt = $pdo->prepare($query);
        $stmt = $this->bind($map, $stmt);

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
    private function update(bool $bypass = false){
        global $_USER;

        $orm = BucketParser::parse(get_called_class());
        $pdo = DB::getInstance()->getLink();

        if(!$bypass){
            // on vérifie les permissions
            if(!$this->isAuthor() && !$_USER->hasPermission($orm->getGroup(), User::PERMISSION_UPDATE)){
                throw new BucketException(sprintf(gettext("Insufficient permission [%s][%s]"), $orm->getGroup(), User::PERMISSION_UPDATE));
            }
        }

        // retire de la liste les champs protégés
        $temp = $orm->getMap();
        $map = [];
        for($i = 0, $n = count($temp); $i < $n; $i++){
            if($temp[$i]->getAccessLevel() === BucketField::ACCESS_LEVEL_ADMIN && !$_USER->isAdmin($orm->getGroup())){
                continue;
            }
            $map[] = $temp[$i];
        }

        // mise à jour de données
        $query = "UPDATE " . DATABASE_CFG['prefix'] . $orm->getTable() . " SET ".join(array_map(function($field){
            return $field . " = :". $field;
        }, $map), ", ").", modification_date = NOW() WHERE id = :id;";
        $stmt = $pdo->prepare($query);

        $stmt = $this->bind($map, $stmt);
        $stmt->bindValue('id', $this->getId(), \PDO::PARAM_INT);

        if(!$stmt->execute()){
            throw new BucketException(gettext("Query failed"));
        }

        $stmt->closeCursor();
    }

    /**
    * Lie les valeurs de la table à l'objet Bucket
    * @param array $map
    * @param PDOStatement $stmt
    */
    private function bind(array $map, \PDOStatement $stmt) : \PDOStatement{
        for($i = 0, $n = count($map); $i < $n; $i++){
            $field = $map[$i];

            $method = self::getKeyGetter($field->getName());
            $value = $this->$method();

            if(method_exists($this, $method)){
                $type = ($value == NULL) ? \PDO::PARAM_NULL : $field->getType();
                $stmt->bindValue($field->getName(), $value, $type);
            }
        }
        return $stmt;
    }

    public function save(bool $bypass = false){
        global $_USER;

        if($this->isNew()){
            $this->beforeInsert();
            $this->insert($bypass);
            $this->afterInsert();
        }
        else{
            $this->beforeUpdate();
            $this->update($bypass);
            $this->afterUpdate();
        }
    }

    public function isAuthor() : bool{
        // vérifie les permissions pour les classes possédant un champs creator_id
        $getCreator = self::getKeyGetter('creator_id');
        // on vérifie que l'utilisateur est connecté
        if(method_exists($this, $getCreator)){
            if(!$this->isNew()){
                // on vérifie que le créateur est bien l'utilisateur connecté
                if($_SESSION['uid'] > 0 && $this->$getCreator() == $_SESSION['uid']){
                    return true;
                }
            }
            else{
                if($_SESSION['uid'] > 0){
                    return true;
                }
            }
        }

        return false;
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

    /**
    * Fonction de filtrage par défaut à écraser si on veut affiner l'algo
    */
    public static function filter(array $map = []) : array{
        $data = [];
        $limit = "";

        $class = get_called_class();
        $orm = BucketParser::parse($class);

        if(isset($map['start']) && isset($map['amount']) && $map['start'] != -1 && $map['amount'] != -1){
            $data[] = [':start', (int)$map['start'], \PDO::PARAM_INT];
            $data[] = [':amount', (int)$map['amount'], \PDO::PARAM_INT];
            $limit = "LIMIT :start, :amount";
        }

        $sql = "SELECT * FROM ".DATABASE_CFG['prefix'].$orm->getTable()." WHERE active = 1 " . $limit.";";
        return DB::fetchMultipleObject($class, $sql, $data);
    }


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


    final public static function deleteById(int $id, string $options = ""){
        global $_USER;

        $orm = BucketParser::parse(get_called_class());
        $pdo = DB::getInstance()->getLink();
        $item = self::getUniqueById($id);

        // on vérifie si l'objet existe
        if($item->getId() == 0){
            throw new \Exception(gettext("Not found"));
        }
        
        // on vérifie les permissions
        if(!$item->isAuthor() && !$_USER->hasPermission($orm->getGroup(), User::PERMISSION_DELETE)){
            throw new BucketException(sprintf(gettext("Insufficient permission [%s][%s]"), $orm->getGroup(), User::PERMISSION_DELETE));
        }

        $stmt = $pdo->prepare("DELETE FROM " . DATABASE_CFG['prefix'] . $orm->getTable() . " WHERE id = :id " . $options);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        //$result = $stmt->execute();
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
