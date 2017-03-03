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
@field species_id, int
@field cover_image_id, int
@field profile_image_id, int
@field creator_id, int
@field date_birth, date
@field description, string
@field banned, int, 1
*/

class Animal extends Bucket\BucketAbstract
{
    const SEX_MALE = 'm';
    const SEX_FEMALE = 'f';
    const SEX_HERMAPHRODITE = 'f';

    private $name;
    private $sex;
    private $species_id;
    private $cover_image_id;
    private $profile_image_id;
    private $creator_id;
    private $date_birth;
    private $description;
    private $banned;

    function __construct($data = NULL){
        $this->name = '';
        $this->sex = self::SEX_MALE;
        $this->species_id = 0;
        $this->creator_id = 0;
        $this->description = "";
        $this->banned = 0;

        parent::__construct($data);
    }

    public function jsonSerialize(){
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'sex' => $this->sex,
            'date_birth' => $this->date_birth,
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
        $class = get_called_class();
        $orm = Bucket\BucketParser::parse($class);

        $sqlHead = "SELECT a.*";
        $sqlFrom = "FROM ".DATABASE_CFG['prefix']."animal a";
        $sqlJoin = "INNER JOIN ".DATABASE_CFG['prefix']."user u ON a.creator_id = u.id";
        $sqlCondition = "WHERE a.active = 1 AND u.id != :user_id";
        $sqlLimit = "";
        $sqlOrder = "ORDER BY creation_date DESC, modification_date DESC";
        $sqlHaving = "";

        $data[] = [':user_id', $_USER->getId(), \PDO::PARAM_INT];

        /**
        * DISTANCE ou CITY NAME
        */
        if(isset($map['maxdistance']) && $map['maxdistance'] > 0){
            $sqlHead .= ", SQRT( POW(111.2 * (u.latitude - :latitude), 2) + POW(111.2 * (:longitude - u.longitude) * COS(u.latitude / 57.3), 2) ) AS distance";
            $sqlHaving .= "HAVING distance < :distance";
            $sqlOrder = "ORDER BY distance, creation_date DESC, modification_date DESC";

            $data[] = [":latitude", $_USER->getLatitude(), \PDO::PARAM_STR];
            $data[] = [":longitude", $_USER->getLongitude(), \PDO::PARAM_STR];
            $data[] = [":distance", (int)$map['maxdistance'], \PDO::PARAM_INT];
        }
        else if(isset($map['city']) && $map['city'] != ''){
            $data[] = [':city', $map['city'] . "%", \PDO::PARAM_STR];
            $sqlCondition .= " AND city LIKE :city";
        }

          /**
        * Age
        */
        if(isset($map['date_birth']) && $map['date_birth'] != ''){
          bday=$map[date_birth];
          SELECT DATEDIFF(hour,$bday,GETDATE())/8766 AS age
          //$data[] = [':date_birth', $map['date_birth'], \PDO::PARAM_STR];
          $sqlCondition .= " AND ".$age"< :ageMin ,".$age"> :ageMax";
        }
        /**
        * LIMIT
        */
        if(isset($map['start']) && isset($map['amount']) && $map['start'] != -1 && $map['amount'] != -1){
            $data[] = [':start', (int)$map['start'], \PDO::PARAM_INT];
            $data[] = [':amount', (int)$map['amount'], \PDO::PARAM_INT];
            $sqlLimit .= " LIMIT :start, :amount";
        }

        /**
        * NAME
        */
        if(isset($map['name']) && $map['name'] != ''){
            $data[] = [':name', $map['name'] . "%", \PDO::PARAM_STR];
            $sqlCondition .= " AND name LIKE :name";
        }

        /**
        * SPECIES
        */
        if(isset($map['species_id']) && $map['species_id'] != 0){
            $data[] = [':species_id', (int)$map['species_id'], \PDO::PARAM_INT];
            $sqlCondition .= " AND species_id = :species_id";
        }

        /**
        * SEX
        */
        if(isset($map['sex']) && $map['sex'] != ''){
            $data[] = [':sex', $map['sex'], \PDO::PARAM_STR];
            $sqlCondition .= " AND a.sex = :sex";
        }



        $sql = $sqlHead . " " . $sqlFrom . " " . $sqlJoin . " " . $sqlCondition . " " . $sqlHaving. " " . $sqlLimit . " " . $sqlOrder;
        return DB::fetchMultipleObject($class, $sql, $data);
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
    }
    protected function afterUpdate(){
        $this->saveCharacteristics();
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

    /**
    * Retourne la liste des commentaires associées à l'animal
    */
    public function getComments() : array{
        $sql = "SELECT * FROM ".DATABASE_CFG['prefix']."animal_comment WHERE animal_id = :id AND active = 1 ORDER BY creation_date DESC";
        $data = array(
            [":id", $this->getId(), \PDO::PARAM_INT]
        );
        return (array)DB::fetchMultipleObject("App\Model\Comment", $sql, $data);
    }

    //Getters
    public function getName() : string{
        return $this->name;
    }
    public function getSex() : string{
        return $this->sex;
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
    public function getBanned() : int{
        return $this->banned;
    }

    // setters
    public function setName(string $name){
        $this->name = $name;
    }
    public function setSex(string $sex){
        $this->sex = $sex;
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
}
