<?php
/**
* Interface de la classe Bucket
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model\Bucket;

interface BucketInterface
{
    /**
    * Permet de déterminer si l'objet doit être inséré dans la base (true) ou modifié (false)
    * @return bool
    */
    public function isNew() : bool;

    /**
    * @param array $data Liste des propriétés de l'objet à remplir ou écraser (key:value)
    */
    public function hydrate(array $data = [], bool $check = false);

    /**
    * Sauvegarde l'instance de l'objet dans la base de donnée
    * @return void
    * @throws Exception Si il existe des erreurs bloquantes empêchant d'exécuter la sauvegarde
    */
    public function save();

    /**
    * Retourne un objet
    * @param int $id Identifiant de la ligne
    * @return Instance de la classe fille
    * @throws PDOException
    */
    public static function getUniqueById(int $id);

    /**
    * Retourne plusieurs objets
    * @param int $start Décalage de la tête de lecture dans la base
    * @param int $amount Nombre d'élément maximum à récupérer
    * @param string $options
    * @return array Liste d'instances de la classe fille
    * @throws PDOException
    */
    public static function getMultiple(array $options = []) : array;

    /**
    * Supprime un élément de la base de donnée en fonction de son ID
    * @param int $id
    * @param string $options
    * @return void
    * @throws PDOException
    */
    public static function deleteById(int $id, string $options = "");
}
