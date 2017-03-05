<?php
/**
* Comment
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model;

/*
@table animal_comment
@group animal_profile
@field animal_id, int
@field creator_id, int
@field content, string
*/

class Comment extends Bucket\BucketAbstract
{
    private $content;
    private $animal_id;
    private $creator_id;

    function __construct($data = NULL){
        $this->content = '';
        $this->animal_id = 0;
        $this->creator_id = 0;

        parent::__construct($data);
    }

    public function jsonSerialize(){
        return array(
            'id' => $this->id,
            'content' => $this->content,
            'animal_id' => $this->animal_id,
            'creator' => $this->getCreator(),
            'creation_date' => (!empty($this->creation_date)) ? $this->creation_date : gettext('now'),
            'modification_date' => $this->modification_date,
            'is_author' => ($_SESSION['uid'] == $this->creator_id)
        );
    }

    /**
    * Filtres disponibles
    *
    * - page
    * - animal_id
    */
    public static function filter(array $map = []) : array{
        global $_USER;

        $class = get_called_class();
        $orm = Bucket\BucketParser::parse($class);

        $data = [];

        // page
        $currentPage = (int)($map['page'] ?? 0);
        $amountPerPage = 10;
        $maxPage = 0;
        $total = 0;



        $sqlCondition = [];
        $sqlHaving = [];

        $sqlHeadCount = "SELECT COUNT(c.id) as total";
        $sqlHeadList = "SELECT c.*";
        $sqlFrom = "FROM ".DATABASE_CFG['prefix']."animal_comment c";
        $sqlJoin = "";
        $sqlCondition[] = "c.active = 1";
        $sqlLimit = "";
        $sqlOrder = "ORDER BY c.creation_date DESC, c.modification_date DESC";


        /**
        * ANIMAL
        */
        if(isset($map['animal_id']) && $map['animal_id'] != 0){
            $data[] = [':animal_id', (int)$map['animal_id'], \PDO::PARAM_INT];
            $sqlCondition[] = "animal_id = :animal_id";
        }

        /**
        * CREATOR
        */
        if(isset($map['creator_id']) && $map['creator_id'] != 0){
            $data[] = [':creator_id', (int)$map['creator_id'], \PDO::PARAM_INT];
            $sqlCondition[] = "creator_id = :creator_id";
        }

        /**
        *
        * CALCUL DU TOTAL
        *
        */
        $sqlConditionTemp = (count($sqlCondition) > 0) ? "WHERE " . join(' AND ', $sqlCondition) : "";
        $sqlHavingTemp = (count($sqlHaving) > 0) ? "HAVING " . join(' AND ', $sqlHaving) : "";

        $sqlCount = $sqlHeadCount . " " . $sqlFrom . " " . $sqlJoin . " " . $sqlConditionTemp . " " . $sqlHavingTemp;
        $total = (int)DB::fetchUnique($sqlCount, $data)['total'];



        /**
        *
        * LIST FILTRÉE
        *
        */

        /**
        * LIMIT
        */
        if($total == 0){
            $currentPage = 0;
        }
        if($currentPage > 0){
            $maxPage = ceil($total / $amountPerPage);

            if($currentPage > $maxPage){
                $currentPage = $maxPage;
            }

            $start = ($currentPage - 1) * $amountPerPage;

            $data[] = [':start', $start, \PDO::PARAM_INT];
            $data[] = [':amount', $amountPerPage, \PDO::PARAM_INT];
            $sqlLimit .= " LIMIT :start, :amount";
        }


        $sqlConditionTemp = (count($sqlCondition) > 0) ? "WHERE " . join(' AND ', $sqlCondition) : "";
        $sqlHavingTemp = (count($sqlHaving) > 0) ? "HAVING " . join(' AND ', $sqlHaving) : "";

        $sqlList = $sqlHeadList . " " . $sqlFrom . " " . $sqlJoin . " " . $sqlConditionTemp . " " . $sqlHavingTemp . " " . $sqlOrder . " " . $sqlLimit;
        $list = DB::fetchMultipleObject($class, $sqlList, $data);



        // données formatés
        $output = [];

        if($currentPage != 0){
            $output['current_page'] = $currentPage;
            $output['page_count'] = $maxPage;
            $output['page_amount'] = $amountPerPage;
        }
        $output['item_total'] = $total;
        $output['data'] = $list;

        return $output;
    }

    protected function beforeInsert(){
        $this->setCreatorId($_SESSION['uid']);
    }
    protected function beforeUpdate(){}

    protected function afterInsert(){}
    protected function afterUpdate(){}


    public function setContent(string $content){
        $this->content = $content;
    }
    public function setAnimalId(int $id){
        $this->animal_id = $id;
    }
    public function setCreatorId(int $id){
        $this->creator_id = $id;
    }

    public function getContent() : string{
        return $this->content;
    }
    public function getAnimalId() : int{
        return $this->animal_id;
    }
    public function getCreatorId() : int{
        return $this->creator_id;
    }
    public function getCreator() : User{
        return User::getUniqueById($this->creator_id);
    }
}
