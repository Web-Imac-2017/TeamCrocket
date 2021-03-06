<?php
/**
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model;

class DB implements DBInterface
{
    private $pdo;
    public static $instance = NULL;

    private function __construct(){
        try{
            $this->pdo = new \PDO("mysql:host=". DATABASE_CFG['host'] . ";dbname=".DATABASE_CFG['name'], DATABASE_CFG['user'], DATABASE_CFG['password'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch(Exception $e){
            echo $e->getMessage() . "\n";
        }
    }

    private function __clone(){}

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
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);

        if($stmt->execute()){
            $result = $stmt->fetch();
        }
        $stmt->closeCursor();
        return $result;
    }

    final public static function fetchUniqueObject($class, string $sql, array $values = []){
        return new $class(self::fetchUnique($sql, $values));
    }


    final public static function fetchMultiple(string $sql, array $values = []){
        $pdo = self::getInstance()->getLink();
        $result = null;

        $stmt = $pdo->prepare($sql);
        foreach($values as $temp){
            $stmt->bindValue($temp[0], $temp[1], $temp[2]);
        }
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);

        if($stmt->execute()){
            $result = $stmt->fetchAll();
        }
        $stmt->closeCursor();
        return $result;
    }

    final public static function fetchMultipleObject($class, string $sql, array $values = []){
        $pdo = self::getInstance()->getLink();
        $results = [];

        $stmt = $pdo->prepare($sql);
        foreach($values as $temp){
            $stmt->bindValue($temp[0], $temp[1], $temp[2]);
        }
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);

        if($stmt->execute()){
            while($result = $stmt->fetch()){
                $results[] = new $class($result);
            }
        }
        $stmt->closeCursor();
        return $results;
    }

    final public static function exec(string $sql, array $values = []){
        $pdo = self::getInstance()->getLink();

        $stmt = $pdo->prepare($sql);
        foreach($values as $temp){
            $stmt->bindValue($temp[0], $temp[1], $temp[2]);
        }

        $stmt->execute();
        $stmt->closeCursor();
    }

    final public static function execMultiple(string $sql, array $values = []){
        $pdo = self::getInstance()->getLink();

        $stmt = $pdo->prepare($sql);
        try{
            $pdo->beginTransaction();
            for($i = 0, $n = count($values); $i < $n; $i++){
                foreach($values[$i] as $temp){
                    $stmt->bindValue($temp[0], $temp[1], $temp[2]);
                }
                $stmt->execute();
            }
            $pdo->commit();

        } catch(Exception $e){
            $pdo->rollBack();
            throw $e;
        }
    }

    public function getLink(){ return $this->pdo; }
}
