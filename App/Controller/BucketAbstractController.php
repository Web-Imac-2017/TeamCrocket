<?php
/**
* Gontroller
* @author METTER-ROTHAN Jérémie
*/

namespace App\Controller;

abstract class BucketAbstractController
{
    /**
    * List elements
    * @param int $page
    * @return array
    */
    public abstract function list($page = -1) : array;

    /**
    * Update / Insert elements
    */
    public abstract function edit();

    /**
    * Delete elements
    * @param int $id
    */
    public abstract function delete(int $id);
}
