<?php
/**
* Gontroller des Comment
* @author METTER-ROTHAN Jérémie
*/

namespace App\Controller;

use App\Model\Comment;

class CommentController extends BucketAbstractController
{
    /**
    * Récupère les commentaires associés à un profil
    */
    public function list(): array{
        return Comment::filter($_POST);
    }

    /**
    * Récupère un commentaire
    * @param int $id ID du commentaire
    */
    public function get(int $id = 0) : Comment{
        $comment = Comment::getUniqueById($id);
        if($comment->getId() == 0){
            throw new \Exception(sprintf(gettext("Comment %s does not exist"), 'n°'.$id));
        }
        return $comment;
    }

    /**
    * Modifie ou créé un commentaire
    */
    public function edit() : Comment{
        $id = (isset($_POST['id'])) ? (int)$_POST['id'] : 0;

        $comment = Comment::getUniqueById($id);
        $comment->hydrate($_POST, true);
        $comment->save($id == 0);

        return $comment;
    }

    /**
    * Supprime un commentaire
    */
    public function delete(int $id){
        Comment::deleteById($id);
    }
}
