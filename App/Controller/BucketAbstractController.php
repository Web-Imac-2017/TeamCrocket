<?php
/**
* Controller
* @author METTER-ROTHAN Jérémie
*/

namespace App\Controller;

abstract class BucketAbstractController
{
    /**
    * Retourne une liste d'élément
    * @param int $page
    * @return array
    */
    public abstract function list($page = -1) : array;

    /**
    * Update / Insert un élément
    */
    public abstract function edit();

    /**
    * Supprime un élément
    * @param int $id
    */
    public abstract function delete(int $id);

    /**
    * Récupère un élément
    * @param int $id
    */
    public abstract function get(int $id = 0);
}
