<?php
/**
* Profil d'un animal
* @author PORCHER Cédric
*/


namespace App\Model;

/*
@table animal
@group animal_profile
@field name, string
@field sex, string
@field info_like, string
@field info_dislike, string
@field species_id, int
@field cover_image_id, int
@field profile_image_id, int
@field creator_id, int
@field date_birth, date
@field description, string
@field banned, int, 1
@field dirty, bool
*/

class Animal extends Bucket\BucketAbstract
{
    const SEX_MALE = 'm';
    const SEX_FEMALE = 'f';
    const SEX_HERMAPHRODITE = 'f';

    private $name;
    private $sex;
    private $info_like;
    private $info_dislike;
    private $species_id;
    private $cover_image_id;
    private $profile_image_id;
    private $creator_id;
    private $date_birth;
    private $description;
    private $banned;
    private $dirty;

    function __construct($data = NULL){
        $this->name = '';
        $this->sex = self::SEX_MALE;
        $this->info_like = '';
        $this->info_dislike = '';
        $this->species_id = 0;
        $this->creator_id = 0;
        $this->description = "";
        $this->banned = 0;
        $this->dirty = 0;

        parent::__construct($data);
    }

    public function jsonSerialize(){
        $creator = $this->getUser();

        return array(
            'id' => $this->id,
            'name' => $this->name,
            'sex' => $this->sex,
            'like' => $this->info_like,
            'city' => $creator->getCity(),
            'dislike' => $this->info_dislike,
            'date_birth' => $this->date_birth,
            'characteristics' => $this->getCharacteristics(),
            'age' => $this->getAge(),
            'cover_image' => $this->getCoverImage(),
            'profile_image' => $this->getProfileImage(),
            'creator_id' => $this->creator_id,
            'species' => $this->getSpecies(),
            'description' => $this->description,
            'creation_date' => $this->creation_date
        );
    }

    /**
    * Filtres disponibles
    *
    * - maxdistance
    * - city
    * - start
    * - amount
    * - name
    * - species_id
    * - sex
    */
    public static function filter(array $map = []) : array{
        global $_USER;

        $data = [];

        $currentPage = (int)($map['page'] ?? 0);
        $amountPerPage = 5;
        $maxPage = 0;
        $total = 0;

        $class = get_called_class();
        $orm = Bucket\BucketParser::parse($class);

        $sqlCondition = [];
        $sqlHaving = [];

        $sqlHeadCount = "SELECT COUNT(a.id) as total, FLOOR(DATEDIFF(CURDATE(), a.date_birth) / 365.2422) as age";
        $sqlHeadList = "SELECT a.*, FLOOR(DATEDIFF(CURDATE(), a.date_birth) / 365.2422) as age";
        $sqlFrom = "FROM ".DATABASE_CFG['prefix']."animal a";
        $sqlJoin = "INNER JOIN ".DATABASE_CFG['prefix']."user u ON a.creator_id = u.id";
        $sqlCondition[] = "a.active = 1 AND a.banned = 0 AND u.id != :user_id";
        $sqlLimit = "";
        $sqlOrder = "ORDER BY a.creation_date DESC, a.modification_date DESC";

        $data[] = [':user_id', $_USER->getId(), \PDO::PARAM_INT];

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
        * DISTANCE ou CITY NAME
        */
        if(isset($map['maxdistance']) && $map['maxdistance'] > 0){
            $sqlHeadList .= ", SQRT( POW(111.2 * (u.latitude - :latitude), 2) + POW(111.2 * (:longitude - u.longitude) * COS(u.latitude / 57.3), 2) ) AS distance";

            $sqlHaving[] = "distance < :distance";
            $sqlOrder = "ORDER BY distance, a.creation_date DESC, a.modification_date DESC";

            $data[] = [":latitude", $_USER->getLatitude(), \PDO::PARAM_STR];
            $data[] = [":longitude", $_USER->getLongitude(), \PDO::PARAM_STR];
            $data[] = [":distance", (int)$map['maxdistance'], \PDO::PARAM_INT];
        }
        else if(isset($map['city']) && $map['city'] != ''){
            $data[] = [':city', $map['city'] . "%", \PDO::PARAM_STR];
            $sqlCondition[] = "city LIKE :city";
        }

        /**
        * SEX
        */
        if(isset($map['sex']) && $map['sex'] != ''){
            $data[] = [':sex', $map['sex'], \PDO::PARAM_STR];
            $sqlCondition[] = "a.sex = :sex";
        }

        /**
        * AGE
        */
        if(isset($map['age_min']) && isset($map['age_max'])){
            $min = (int)$map['age_min'];
            $max = (int)$map['age_max'];

            if($min > 0 && $max > 0){
                // on compare entre le MIN et le MAX
                $data[] = [':age_min', $min, \PDO::PARAM_INT];
                $data[] = [':age_max', $max, \PDO::PARAM_INT];
                $sqlHaving[] = "(age >= :age_min AND age <= :age_max)";
            }
            else if($min == 0 && $max > 0){
                // on compare X plus grand que MAX
                $data[] = [':age', $max, \PDO::PARAM_INT];
                $sqlHaving[] = "age <= :age";
            }
            else{
                // on compare X plus petit que MIN
                $data[] = [':age', $min, \PDO::PARAM_INT];
                $sqlHaving[] = "age >= :age";
            }
        }

        /**
        * NAME
        */
        if(isset($map['name']) && $map['name'] != ''){
            $data[] = [':name', $map['name'] . "%", \PDO::PARAM_STR];
            $sqlCondition[] = "name LIKE :name";
        }

        /**
        * SPECIES
        */
        if(isset($map['species_id']) && $map['species_id'] != 0){
            $data[] = [':species_id', (int)$map['species_id'], \PDO::PARAM_INT];
            $sqlCondition[] = "species_id = :species_id";
        }

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
        $this->uploadCoverImage();
        $this->uploadProfileImage();
        $this->setCreatorId($_SESSION['uid']);
    }
    protected function beforeUpdate(){
        $this->uploadCoverImage();
        $this->uploadProfileImage();
    }

    protected function afterInsert(){
        $this->saveCharacteristics();
        $this->markDirty(0);
    }
    protected function afterUpdate(){
        $this->saveCharacteristics();
        $this->markDirty(0);
    }

    public function markDirty(bool $dirty = false){
        $date = ($dirty == 1) ? "date_last_moderation = NOW(), " : "";
        $sql = "UPDATE ".DATABASE_CFG['prefix']."animal SET {$date} dirty = :dirty WHERE id = :id";
        $values = array(
            [':id', $this->getId(), \PDO::PARAM_INT],
            [':dirty', $dirty, \PDO::PARAM_BOOL]
        );

        DB::exec($sql, $values);
    }

    private function saveCharacteristics(){
        if(!isset($_POST['characteristic'])){
            return;
        }

        $data = [];
        $sql = "
            INSERT INTO ".DATABASE_CFG['prefix']."animal_characteristic (animal_id, characteristic_id, value)
            VALUES(:animal_id, :characteristic_id, :value)
            ON DUPLICATE KEY UPDATE value = :value;
        ";

        $list = Characteristic::getList($this);
        foreach($list as $c){
            $value = $_POST['characteristic'][$c->getId()] ?? '';
            $data[] = array(
                [':animal_id', $this->getId(), \PDO::PARAM_INT],
                [':characteristic_id', $c->getId(), \PDO::PARAM_INT],
                [':value', $c->formatValue($value), \PDO::PARAM_STR]
            );
        }

        DB::execMultiple($sql, $data);
    }

    public function uploadImage(){
        $image = NULL;

        if(isset($_FILES['image_file']) && is_uploaded_file($_FILES['image_file']['tmp_name'])){
            $image = Image::upload($_FILES['image_file'], array(
                'extensions' => array('jpeg', 'jpg', 'png', 'gif'),
                'max_size' => 1048576 * 4
            ));

            if($image instanceof Image){
                $image->createThumbnail(300);

                $sql = "INSERT IGNORE INTO ".DATABASE_CFG['prefix']."animal_gallery(animal_id, image_id) VALUES(:animal_id, :image_id)";
                $values = array(
                    [':animal_id', $this->getId(), \PDO::PARAM_INT],
                    [':image_id', $image->getId(), \PDO::PARAM_INT]
                );
                DB::exec($sql, $values);
            }
        }
        else{
            throw new \Exception(gettext("No file"));
        }

        return $image;
    }

    /**
    * Permet de gérer l'envoi et le traitement de la photo de profil
    * @return void
    */
    protected function uploadProfileImage(){
        if(isset($_FILES['profile_file'])){
            $image = Image::upload($_FILES['profile_file'], array(
                'extensions' => array('jpeg', 'jpg', 'png', 'gif'),
                'max_size' => 1048576 * 4
            ));

            if($image instanceof Image){
                Image::remove($this->getProfileImage());

                $image->toProfilePic(400, 400);
                $image->createThumbnail(150);
                $this->setProfileImageId($image->getId());
            }
        }
    }

    protected function uploadCoverImage(){
        $image = NULL;

        if(isset($_FILES['cover_file']) && is_uploaded_file($_FILES['cover_file']['tmp_name'])){
            $image = Image::upload($_FILES['cover_file'], array(
                'extensions' => array('jpeg', 'jpg', 'png'),
                'max_size' => 1048576 * 8
            ));

            if($image instanceof Image){
                // on supprime l'ancienne image de couverture
                Image::remove($this->getCoverImage());
                $image->createThumbnail(300);
                // on enregistre la nouvelle image de couverture
                $this->setCoverImageId($image->getId());
            }
        }

        return $image;
    }

    /**
    * Retourne la liste des images associées à l'animal
    */
    public function getImageList() : array{
        $sql = "SELECT i.* FROM ".DATABASE_CFG['prefix']."image i INNER JOIN ".DATABASE_CFG['prefix']."animal_gallery g ON i.id = g.image_id WHERE g.animal_id = :id AND active = 1";
        $data = array(
            [":id", $this->getId(), \PDO::PARAM_INT]
        );
        return (array)DB::fetchMultipleObject("App\Model\Image", $sql, $data);
    }

    public static function getDirtyList() : array{
        $sql = "SELECT * FROM ".DATABASE_CFG['prefix']."animal WHERE dirty = 0 AND active = 1";
        $data = [];
        return (array)DB::fetchMultipleObject("App\Model\Animal", $sql, $data);
    }

    //Getters
    public function getName() : string{
        return $this->name;
    }
    public function getSex() : string{
        return $this->sex;
    }
    public function getInfoLike() : string{
        return $this->info_like;
    }
    public function getInfoDislike() : string{
        return $this->info_dislike;
    }
    public function getSpeciesId() : int{
        return $this->species_id;
    }
    public function getCoverImageId(){
        return $this->cover_image_id;
    }
    public function getProfileImageId(){
        return $this->profile_image_id;
    }
    public function getCreatorId() : int{
        return $this->creator_id;
    }
    public function getDateBirth(){
        return $this->date_birth;
    }
    public function getAge() : int{
        return dateToAge((string)$this->getDateBirth());
    }
    public function getDescription() : string{
        return $this->description;
    }
    public function getSpecies() : Species{
        return Species::getUniqueById($this->species_id);
    }
    public function getUser() : User{
        return User::getUniqueById($this->creator_id);
    }
    public function getCoverImage(){
        return ($this->cover_image_id > 0) ? Image::getUniqueById($this->cover_image_id) : NULL;
    }
    public function getProfileImage(){
        return ($this->profile_image_id > 0) ? Image::getUniqueById($this->profile_image_id) : NULL;
    }
    public function getCharacteristics(){
        return Characteristic::getList($this);
    }
    public function getBanned() : int{
        return $this->banned;
    }
    public function getDateLastModeration(){
        return $this->date_last_moderation;
    }
    public function getDirty() : bool{
        return $this->dirty;
    }

    // setters
    public function setName(string $name){
        $this->name = $name;
    }
    public function setSex(string $sex){
        $this->sex = $sex;
    }
    public function setInfoLike(string $like){
        $this->info_like = $like;
    }
    public function setInfoDislike(string $dislike){
        $this->info_dislike = $dislike;
    }
    public function setSpeciesId(int $species){
        $this->species_id = $species;
    }
    public function setCoverImageId($id){
        $this->cover_image_id = $id;
    }
    public function setProfileImageId($id){
        $this->profile_image_id = $id;
    }
    public function setCreatorId(int $proprio){
        $this->creator_id = $proprio;
    }
    public function setDescription(string $descr){
        $this->description = $descr;
    }
    public function setDateBirth(string $date = NULL){
        $this->date_birth = $date;
    }
    public function setBanned(int $banned){
        $this->banned = $banned;
    }
    public function setDateLastModeration(string $date = NULL){
        $this->date_last_moderation = $date;
    }
}
