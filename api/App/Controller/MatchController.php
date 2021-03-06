<?php
/**
* Gontroller des User
* @author METTER-ROTHAN Jérémie
*/

namespace App\Controller;

use App\Model\User;
use App\Model\Animal;
use App\Model\Match;

class MatchController
{
    /**
    * Retourne une suggestion pour un animal et son propriétaire
    * @param int $animal_id
    */
    public function get(int $animal_id){
        global $_USER;

        $animal = Animal::getUniqueById($animal_id);
        if($animal->getId() == 0){
            throw new \Exception(gettext("Unknown animal ID"));
        }
        if($animal->getUser()->getId() != $_USER->getId()){
            throw new \Exception(gettext("You must be the owner"));
        }
        return Match::getSuggestion($animal, $_POST);
    }

    /**
    * Permet de sauvegarder le choix de l'utilisateur vis à vis du "prétendant"
    * Retourne true/false si le choix engendre un match
    * @param int $aID
    * @param int $bID
    * @param bool $interested
    * @return bool
    */
    public function swipe(int $aID, int $bID, bool $interested){
        global $_USER;

        $a = Animal::getUniqueById($aID);
        $b = Animal::getUniqueById($bID);

        if($a->getId() == 0 || $b->getId() == 0){
            throw new \Exception(sprintf(gettext("Unknown animal ID [%s][%s]"), $a->getId(), $b->getId()));
        }
        if($a->getUser()->getId() != $_USER->getId()){
            throw new \Exception(gettext("You must be the owner"));
        }

        return array('match' => Match::swipe($a, $b, $interested), 'interested' => $interested);
    }

    /**
    * Retourne la liste des matchs pour un animal
    * @param int $animal_id
    * @return array
    */
    public function list(int $animal_id){
        global $_USER;

        $animal = Animal::getUniqueById($animal_id);

        if($animal->getUser()->getId() != $_USER->getId()){
            throw new \Exception(gettext("You must be the owner"));
        }

        return Match::getMatchList($animal);
    }

    /**
    * Permet de déterminer si deux animaux ont match
    * @param int $aID
    * @param int $bID
    * @return bool
    */
    public function status(int $aID, int $bID){
        global $_USER;

        $a = Animal::getUniqueById($aID);
        $b = Animal::getUniqueById($bID);

        if($a->getUser()->getId() != $_USER->getId()){
            throw new \Exception(gettext("You must be the owner"));
        }

        return Match::isMatch($a, $b);
    }
}
