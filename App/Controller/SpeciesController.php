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
    * Ajoute une caractéristique à une espèce
    */
    public function add_characteristic(){
        $this->mod_characteristic('addCharacteristic');
    }

    /**
    * Supprime une caractéristique à une espèce
    */
    public function delete_characteristic(){
        $this->mod_characteristic('removeCharacteristic');
    }


    private function mod_characteristic($function){
        global $_USER;

        $species_id = $_POST['species_id'] ?? 0;
        $characteristic_id = $_POST['characteristic_id'] ?? 0;

        $species = Species::getUniqueById($species_id);

        if(!$_USER->isAdmin('animal_profile')){
            throw new \Exception(gettext("Insufficient permission"));
        }
        if($species->getId() == 0){
            throw new \Exception(sprintf(gettext("Species %s does not exist"), 'n°'.$species_id));
        }
        if($characteristic_id == 0){
            throw new \Exception(gettext("Invalid characteristic"));
        }

        if(method_exists($species, $function)){
            $species->$function($characteristic_id);
        }
    }

    /**
    * Récupère la liste des caractéristiques pour une espèce
    * @param int $id ID de l'espèce
    */
    public function list_characteristic(int $id = 0) : array{
        $species = Species::getUniqueById($id);
        if($species->getId() == 0){
            throw new \Exception(sprintf(gettext("Species %s does not exist"), 'n°'.$id));
        }
        return $species->getCharacteristics();
    }

    /**
    * Récupère la liste des caractéristiques pour une espèce
    * @param int $id ID de l'espèce
    */
    public function list_all_characteristic() : array{
        return Characteristic::filter($_POST);
    }

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
