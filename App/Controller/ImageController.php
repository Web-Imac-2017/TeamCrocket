<?php
/**
*
*/

namespace App\Controller;

use App\Model\Image;

class ImageController
{
    /**
    * Supprime un profil modéré
    * @param string $table nom de la table
    * @param int $id ID du profil
    * @param bool $dirty ID du profil
    * @return int id supprimé
    */
    public function markdirty(int $image_id, int $dirty){
        $image = Image::getUniqueById($image_id);

        if($image->getId() == 0){
            throw new \Exception(sprintf(gettext("This picture n°%s does not exist"), $image_id));
        }
        $image->markDirty($dirty);

        return array(
            'dirty' => $dirty,
            'id' => $image->getId()
        );
    }
}
