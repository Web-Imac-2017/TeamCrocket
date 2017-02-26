<?php
/**
* Gontroller des User
* @author METTER-ROTHAN Jérémie
*/

namespace App\Controller;

use App\Model\User;
use App\Model\Message;
use App\Model\MessageGroup;

class MessengerController
{
    public function list() : array{
        return Message::filter($_POST);
    }

    /**
    * Ajouter / Modifie un message
    */
    public function send() : Message{
        $message = new Message();
        $message->hydrate($_POST, true);
        $message->setCreatorId($_SESSION['uid']);
        $message->save();

        return $message;
    }

    /**
    * Charge une conversation, si elle n'existe pas encore, on la crée
    */
    public function load() : MessageGroup{
        $friend_uid = (int)$_POST['friend_uid'];
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

    public function fetch() : array{
        $group_id = (int)$_POST['group_id'] ?? 0;
        $last_update = (int)$_POST['last_update'] ?? 0;

        $group = MessageGroup::getUniqueById($group_id);
        if($group->getId() == 0){
            throw new \Exception(gettext("Unknown message group"));
        }
        return $group->getList($last_update);
    }
}
