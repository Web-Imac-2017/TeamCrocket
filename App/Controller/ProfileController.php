<?php
/**
* Gontroller des profils animaux
* @author PORCHER Cédric
*/

namespace App\Controller;

use App\Model\Animal;
use App\Model\Image;

class ProfileController extends BucketAbstractController
{
    public function list() : array{
        return Animal::filter($_POST);
    }

    /**
    * Récupère les commentaires associés à un profil
    * @param int $id ID du profil
    */
    public function comments(int $id = 0): array{
        $animal = Animal::getUniqueById($id);
        if($animal->getId() == 0){
            throw new \Exception(sprintf(gettext("Profile %s does not exist"), 'n°'.$id));
        }
        return $animal->getComments();
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
    * @return int id supprimé
    */
    public function delete(int $id){
        Animal::deleteById($id);
        return $id;
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
    * @return int id supprimé
    */
    public function delete_image(int $id){
        Image::deleteById($id);
        return $id;
    }
}
