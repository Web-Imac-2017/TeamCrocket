<?php
/**
* Gontroller des Characteristic
* @author METTER-ROTHAN Jérémie
*/

namespace App\Controller;

use App\Model\Species;
use App\Model\Characteristic;

class CharacteristicController extends BucketAbstractController
{
    /**
    * Lie une caractéristique à une espèce
    */
    public function link(){
        $this->handle_link('link');
    }

    /**
    * Supprime le lien d'une caractéristique à une espèce
    */
    public function unlink(){
        $this->handle_link('unlink');
    }


    private function handle_link($function){
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
    * Récupère la liste des espèces
    */
    public function list(): array{
        return Characteristic::filter($_POST);
    }

    /**
    * Récupère une espèce
    * @param int $id ID de l'espèce
    */
    public function get(int $id = 0) : Characteristic{
        $characteristic = Characteristic::getUniqueById($id);
        if($characteristic->getId() == 0){
            throw new \Exception(sprintf(gettext("Characteristic %s does not exist"), 'n°'.$id));
        }
        return $characteristic;
    }

    /**
    * Modifie ou créé une espèce
    */
    public function edit() : Characteristic{
        $id = (isset($_POST['id'])) ? (int)$_POST['id'] : 0;

        $characteristic = Characteristic::getUniqueById($id);
        $characteristic->hydrate($_POST, true);
        $characteristic->save($id == 0);

        return $characteristic;
    }

    /**
    * Supprime une espèce
    */
    public function delete(int $id){
        Characteristic::deleteById($id);
    }
}
