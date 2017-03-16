<?php
/**
* Gontroller des Species
* @author METTER-ROTHAN Jérémie
*/

namespace App\Controller;

use App\Model\Species;
use App\Model\Characteristic;

class SpeciesController extends BucketAbstractController
{
    /**
    * Récupère la liste des espèces
    */
    public function list(): array{
        return Species::filter($_POST);
    }

    /**
    * Récupère une espèce
    * @param int $id ID de l'espèce
    */
    public function get(int $id = 0) : Species{
        $species = Species::getUniqueById($id);
        if($species->getId() == 0){
            throw new \Exception(sprintf(gettext("Species %s does not exist"), 'n°'.$id));
        }
        return $species;
    }

    /**
    * Modifie ou créé une espèce
    */
    public function edit() : Species{
        $id = (isset($_POST['id'])) ? (int)$_POST['id'] : 0;

        $species = Species::getUniqueById($id);
        $species->hydrate($_POST, true);
        $species->save($id == 0);

        return $species;
    }

    /**
    * Supprime une espèce
    */
    public function delete(int $id){
        Species::deleteById($id);
    }
}
