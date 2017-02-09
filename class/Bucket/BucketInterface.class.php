<?php
namespace Bucket;

/**
* Interface de la classe Bucket
* @author METTER-ROTHAN Jérémie
*/

interface BucketInterface
{
    /**
    * Permet de déterminer si l'objet doit être inséré dans la base (true) ou modifié (false)
    * @return bool
    */
    public function isNew() : bool;

    /**
    * Permet de contrôler l'intégrité des valeurs avant de les envoyer
    * @return void
    */
    public function check();

    /**
    * @param array $data Liste des propriétés de l'objet à remplir ou écraser (key:value)
    */
    public function hydrate(array $data = []);

    /**
    * Sauvegarde l'instance de l'objet dans la base de donnée
    * @return void
    * @throws BucketSaveException Si il existe des erreurs bloquantes empêchant d'exécuter la sauvegarde
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
    public static function getMultiple(int $start = -1, int $amount = -1, string $options = "") : array;

    /**
    * Supprime un élément de la base de donnée en fonction de son ID
    * @param int $id
    * @param string $options
    * @return void
    * @throws PDOException
    */
    public static function deleteById(int $id, string $options = "");

    /**
    * Ajoute une erreur personnalisable à la liste des erreurs
    * @param string $property Propriété à l'origine de l'erreur (un champs de la base en général)
    * @param string $message Message décrivant l'erreur
    */
    public function addError(string $property, string $message = "");

    /**
    * affiche de manière lisible la liste des erreurs (pour le debug)
    */
    public function showErrors();
}
