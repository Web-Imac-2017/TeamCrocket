<?php
/**
* Gontroller des User
* @author METTER-ROTHAN Jérémie
*/

namespace App\Controller;

use App\Model\User;
use App\Model\Message;
use App\Model\MessageGroup;

class MessengerController extends BucketAbstractController
{
    /**
    * Récupère la liste des conversation pour l'utilisateur connecté
    */
    public function list() : array{
        if($_SESSION['uid'] == 0){
            throw new \Exception(gettext("You must sign in"));
        }
        return MessageGroup::getGroupList();
    }

    /**
    * Récupère la liste des messages
    */
    public function fetch() : array{
        $group_id = (int)($_POST['group_id'] ?? 0);
        $last_update = (int)($_POST['last_update'] ?? 0);

        $group = MessageGroup::getUniqueById($group_id);
        if($group->getId() == 0){
            throw new \Exception(gettext("Unknown message group"));
        }
        if(!$group->isMember($_USER)){
            throw new \Exception(gettext("You don't belong to this group"));
        }
        return $group->getMessageList($last_update);
    }

    /**
    * Ajouter / Modifie un message
    */
    public function edit() : Message{
        $message = new Message();
        $message->hydrate($_POST, true);
        $message->setCreatorId($_SESSION['uid']);
        $message->save();

        return $message;
    }

    /**
    * Charge une conversation, si elle n'existe pas encore, on la crée
    */
    public function init() : MessageGroup{
        $friend_uid = (int)($_POST['friend_uid'] ?? 0);
        if(!User::userExistsById($friend_uid)){
            throw new \Exception(gettext("Unknown friend uid"));
        }

        $group = MessageGroup::getUniqueByMembers($friend_uid, $_SESSION['uid']);

        if($group->getId() == 0){
            $group->setUserAId($_SESSION['uid']);
            $group->setUserBId($friend_uid);
            $group->save();
        }
        return $group;
    }

    /**
    * Supprime un message
    */
    public function delete(int $id){
        Message::deleteById($id);
    }

    public function get(int $id = 0){
        $message = Message::getUniqueById($id);

        if($message->getId() == 0){
            throw new \Exception(sprintf(gettext("Message %s does not exist"), 'n°'.$id));
        }
        return $message;
    }
}
