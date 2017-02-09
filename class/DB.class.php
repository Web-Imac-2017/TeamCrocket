<?php
/**
* @author METTER-ROTHAN Jérémie
*/

class DB implements DBInterface
{
    private $host;
    private $base;
    private $user;
    private $password;
    private $prefix;

    private $pdo;
    public static $instance = NULL;

    private function __construct(){
        $this->host = DB_HOST;
        $this->base = DB_NAME;
        $this->prefix = DB_PREFIX;
        $this->user = DB_USER;
        $this->password = DB_PASSWORD;

        $this->connect();
    }

    private function __clone(){}

    private function connect(){
        try{
            $this->pdo = new PDO("mysql:host=". $this->host . ";dbname=".$this->base, $this->user, $this->password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(Exception $e){
            echo $e->getMessage() . "\n";
        }
    }

    public static function getInstance() : DB{
        if(!static::$instance instanceof static){
            static::$instance = new static;
        }

        return static::$instance;
    }

    public function __destroy(){
        $this->pdo = null;
    }


    final public static function fetchUnique(string $sql, array $values = []){
        $pdo = self::getInstance()->getLink();
        $result = null;

        $stmt = $pdo->prepare($sql);
        foreach($values as $temp){
            $stmt->bindValue($temp[0], $temp[1], $temp[2]);
        }
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if($stmt->execute()){
            $result = $stmt->fetch();
        }
        $stmt->closeCursor();
        return $result;
    }


    final public static function fetchMultiple(string $sql, array $values = []){
        $pdo = self::getInstance()->getLink();
        $result = null;

        $stmt = $pdo->prepare($sql);
        foreach($values as $temp){
            $stmt->bindValue($temp[0], $temp[1], $temp[2]);
        }
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if($stmt->execute()){
            $result = $stmt->fetchAll();
        }
        $stmt->closeCursor();
        return $result;
    }


    public function getLink(){ return $this->pdo; }
    public function getPrefix(){ return $this->prefix; }
}
