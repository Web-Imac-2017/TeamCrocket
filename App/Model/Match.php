<?php
namespace App\Model;

class Match
{
    /**
    * Animal A => Animal B
    * @param Animal $a
    * @param Animal $b
    * @param bool $interested
    * @return bool
    */
    public static function swipe(Animal $a, Animal $b, bool $interested) : bool{
        DB::exec("
            INSERT INTO ".DATABASE_CFG['prefix']."animal_match (animal_a_id, animal_b_id, interested)
            VALUES(:animal_a_id, :animal_b_id, :interested)
            ON DUPLICATE KEY UPDATE interested = :interested
        ", array(
            [":animal_a_id", $a->getId(), \PDO::PARAM_INT],
            [":animal_b_id", $b->getId(), \PDO::PARAM_INT],
            [":interested", $interested, \PDO::PARAM_BOOL]
        ));

        return self::isMatch($a, $b);
    }

    /**
    * Vérifie si les deux animaux ont match
    * @param Animal $a
    * @param Animal $b
    * @return bool
    */
    public static function isMatch(Animal $a, Animal $b) : bool{
        $sql = "SELECT COUNT(*) as \"total\" FROM ".DATABASE_CFG['prefix']."animal_match WHERE animal_a_id = :aid AND animal_b_id = :bid AND interested = 1 AND (SELECT sub.interested FROM ".DATABASE_CFG['prefix']."animal_match sub WHERE sub.animal_b_id = :aid AND sub.animal_a_id = :bid) = 1";
        $data = array(
            [":aid", $a->getId(), \PDO::PARAM_INT],
            [":bid", $b->getId(), \PDO::PARAM_INT]
        );
        return ((int)DB::fetchUnique($sql, $data)['total'] > 0);
    }

    /**
    * Récupère une suggestion basé sur un profil animal et le propriétaire
    * Le résultat est choisi aléatoirement mais rend prioritaire les profils des propriétaires qui ont marqué l'animal comme étant intéressant
    * Si il n'existe plus de profil intéressés à matcher, on en sélectionne des nouveaux
    * @return NULL|Animal
    */
    public static function getSuggestion(Animal $animal, array $options = []){
        $sql = "";
        $sqlCondition = "";
        $data = [];

        if(isset($options['sex']) && $options['sex'] != ''){
            $sqlCondition .= " AND a.sex = :sex";
            $data[] = [':sex', $options['sex'], \PDO::PARAM_STR];
        }

        if(isset($options['species_id']) && $options['species_id'] != 0){
            $sqlCondition .= " AND a.species_id = :species_id";
            $data[] = [':species_id', $options['species_id'], \PDO::PARAM_INT];
        }


        $sql = "
            SELECT a.*, TRUNCATE(SQRT( POW(111.2 * (au.latitude - cu.latitude), 2) + POW(111.2 * (cu.longitude - au.longitude) * COS(au.latitude / 57.3), 2) ), 2) AS distance, IFNULL(am.interested, 0) amb_interest
            FROM ".DATABASE_CFG['prefix']."animal a
            INNER JOIN ".DATABASE_CFG['prefix']."user cu ON a.creator_id = cu.id
            INNER JOIN ".DATABASE_CFG['prefix']."user au ON :uid = au.id
            LEFT JOIN ".DATABASE_CFG['prefix']."animal_match am ON am.animal_a_id = a.id AND am.animal_b_id = :aid
            WHERE a.id != :aid
            AND a.active = 1
            AND a.banned = 0
            AND a.creator_id != :uid
            AND a.id NOT IN
                (SELECT animal_b_id FROM ".DATABASE_CFG['prefix']."animal_match WHERE animal_a_id = :aid)
            ".$sqlCondition."
            HAVING distance < 150
            ORDER BY amb_interest DESC, RAND()
            LIMIT 0, 1
        ";

        $data[] = [":aid", $animal->getId(), \PDO::PARAM_INT];
        $data[] = [":uid", $_SESSION['uid'], \PDO::PARAM_INT];


        $animal = DB::fetchUniqueObject("App\Model\Animal", $sql, $data);
        return $animal->getId() > 0 ? $animal : NULL;
    }

    /**
    * Retourne la liste des animaux dont le propriétaire a matché
    * @param $animal
    */
    public static function getMatchList(Animal $animal){
        $sql = "";
        $data = [];

        $sql = "
            SELECT a.* FROM ".DATABASE_CFG['prefix']."animal a
            WHERE a.id IN
                (SELECT animal_b_id FROM ".DATABASE_CFG['prefix']."animal_match am1 WHERE animal_a_id = :aid AND am1.interested = 1 AND
                    (SELECT am2.animal_a_id FROM ".DATABASE_CFG['prefix']."animal_match am2 WHERE am2.animal_a_id = am1.animal_b_id AND am2.animal_b_id = :aid AND am2.interested = 1 LIMIT 0, 1)
                >= 1)
            AND a.id != :aid
        ";

        $data[] = [":aid", $animal->getId(), \PDO::PARAM_INT];

        return (array)DB::fetchMultipleObject("App\Model\Animal", $sql, $data);
    }
}
