<?php
/**
* Interface de la classe DB
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model;

interface DBInterface
{
    /**
    * Retourne l'instance active de la classe DB, si elle n'existe pas encore on l'initialise en plus
    * @return object Instance de la classe DB
    */
    public static function getInstance() : DB;

    /**
    * Retourne une ligne unique de la base de donnée correspondant à la requête SQL
    * @param string $sql Requête SQL à exécuter
    * @param array $values Valeurs à lier à la requête (bindValue)
    * @return array|null Résultat de la requête
    */
    public static function fetchUnique(string $sql, array $values = []);

    /**
    * Retourne plusieurs lignes de la base de donnée correspondant à la requête SQL
    * @param string $sql Requête SQL à exécuter
    * @param array $values Valeurs à lier à la requête (bindValue)
    * @return array|null Tableau de résultats de la requête
    */
    public static function fetchMultiple(string $sql, array $values = []);

    /**
    * Retourne un objet
    * @param string $class
    * @param string $sql
    * @param array $values
    * @return stdClass
    */
    public static function fetchUniqueObject($class, string $sql, array $values = []);

    /**
    * Retourne une liste d'objets
    * @param string $class
    * @param string $sql
    * @param array $values
    * @return stdClass
    */
    public static function fetchMultipleObject($class, string $sql, array $values = []);
}
