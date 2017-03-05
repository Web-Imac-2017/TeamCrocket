<?php
/**
* Gontroller des profils animaux
* @author PORCHER Cédric
*/

namespace App\Controller;

use App\Model\Animal;
use App\Model\Species;
use App\Model\Image;
use App\Model\Characteristic;

class ProfileController extends BucketAbstractController
{
    public function list_species() : array{
        return Species::filter($_POST);
    }

    public function list_characteristics() : array{

    }

    public function list() : array{
        return Animal::filter($_POST);
    }

    /**
    * Récupère un profil
    * @param int $id ID du profil
    */
    public function get(int $id = 0) : Animal{
        $animal = Animal::getUniqueById($id);
        if($animal->getId() == 0){
            throw new \Exception(sprintf(gettext("Profile %s does not exist"), 'n°'.$id));
        }
        return $animal;
    }

    /**
    * Modifie ou créé un profil animal
    */
    public function edit() : Animal{
        $id = (isset($_POST['id'])) ? (int)$_POST['id'] : 0;

        $animal = Animal::getUniqueById($id);
        $animal->hydrate($_POST, true);
        $animal->save();

        return $animal;
    }

    /**
    * Supprime un profil
    * @param int $id ID du profil
    */
    public function delete(int $id){
        Animal::deleteById($id);
    }

    /**
    * Supprime un profil modéré
    * @param string $table nom de la table
    * @param int $id ID du profil
    * @param bool $dirty ID du profil
    * @return int id supprimé
    */
    public function markdirty(int $animal_id, int $dirty){
        $animal = Animal::getUniqueById($animal_id);

        if($animal->getId() == 0){
            throw new \Exception(sprintf(gettext("This picture n°%s does not exist"), $animal_id));
        }
        $animal->markDirty($dirty);

        return array(
            'dirty' => $dirty,
            'id' => $animal->getId()
        );
    }


    /**
    * Upload une image pour un profil d'animal
    */
    public function upload(){
        $animal = Animal::getUniqueById($_POST['id'] ?? 0);
        if($animal->getCreatorId() != $_SESSION['uid']){
            throw new \Exception(gettext("You cannot do this"));
        }
        return $animal->uploadImage();
    }

    /**
    * Supprime une image d'un profil d'animal
    * @param int $id ID de l'image à supprimer
    */
    public function delete_image(int $id){
        Image::deleteById($id);
    }
}
