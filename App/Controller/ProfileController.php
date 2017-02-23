<?php
/**
* Gontroller des profils animaux
* @author PORCHER Cédric
*/

namespace App\Controller;

use App\Model\Animal;
use App\Model\Image;
use App\Model\Bucket\BucketFilter;

class ProfileController extends BucketAbstractController
{
    /**
    * Récupère la liste des profils
    * @param int $page
    */
    public function list($page = -1) : array{
        $filter = [];
        $filter[] = new BucketFilter('owner_id', $_SESSION['uid'], \PDO::PARAM_INT);

        $data = Animal::getMultiple(array(
            'page' => (int)$page,
            'amount' => 10,
            'filter' => $filter,
            'order' => 'creation_date DESC'
        ));
        return $data;
    }

    /**
    * Récupère un profil
    * @param int $id ID du profil
    */
    public function get(int $id = 0) : Animal{
        $animal = Animal::getUniqueById($id);
        if($animal->getId() == 0){
            throw new \Exception(sprintf(gettext("Profile n°%s does not exist"), $id));
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
        return $id;
    }

    public function upload(){
        $animal = Animal::getUniqueById($_POST['id'] ?? 0);
        if($animal->getOwnerId() != $_SESSION['uid']){
            throw new \Exception(gettext("You cannot do this"));
        }
        return $animal->uploadImage();
    }

    public function delete_image(int $id){
        Image::deleteById($id);
        return $id;
    }
}
