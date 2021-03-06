<?php
/**
* Utilisateur
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model;

/*
@table user
@group user_profile
@field nickname, string
@field password, string
@field lastname, string
@field firstname, string
@field email, string
@field sex, string
@field image_id, int
@field description, string
@field city, string
@field country_id, int
@field latitude, float
@field longitude, float
@field date_birth, date
@field verified, int, 1
@field banned, int, 1
*/

class User extends Bucket\BucketAbstract
{
    // profile picture
    const SEX_MALE = 'm';
    const SEX_FEMALE = 'f';

    const PERMISSION_READ = 'read';
    const PERMISSION_CREATE = 'create';
    const PERMISSION_UPDATE = 'update';
    const PERMISSION_DELETE = 'delete';
    const PERMISSION_ADMIN = 'admin';

    private $nickname;
    private $password;
    private $lastname;
    private $firstname;
    private $email;
    private $sex;
    private $image_id;
    private $description;
    private $city;
    private $latitude;
    private $longitude;
    private $country_id;
    private $date_birth;
    private $verified;
    private $banned;

    private static $permission = [];

    function __construct($data = NULL){
        $this->nickname = "";
        $this->password = "";
        $this->lastname = "";
        $this->firstname = "";
        $this->email = "";
        $this->sex = self::SEX_MALE;
        $this->description = "";
        $this->city = "";
        $this->latitude = NULL;
        $this->longitude = NULL;
        $this->country_id = 73;
        $this->date_birth;
        $this->verified = 0;
        $this->banned = 0;

        parent::__construct($data);
    }

    public function jsonSerialize(){
        return array(
            'id' => $this->id,
            'nickname' => $this->nickname,
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'email' => $this->email,
            'sex' => $this->sex,
            'image' => $this->getImage(),
            'description' => $this->description,
            'city' => $this->city,
            'position' => array(
                'lat' => $this->latitude,
                'lng' => $this->longitude
            ),
            'country' => $this->getCountry(),
            'date_birth' => $this->date_birth,
            'age' => $this->getAge(),
            'creation_date' => $this->creation_date
        );
    }

    /**
    * Filtres disponibles
    *
    * - nickname
    * - start
    * - amount
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

        $sqlHeadList = "SELECT u.*";
        $sqlHeadCount = "SELECT COUNT(u.id) as total";

        $sqlFrom = "FROM ".DATABASE_CFG['prefix']."user u";
        $sqlJoin = "";
        $sqlCondition = "WHERE u.active = 1 AND u.id != :user_id";
        $sqlLimit = "";
        $sqlOrder = "ORDER BY u.creation_date DESC, u.modification_date DESC";
        $sqlHaving = "";

        $data[] = [':user_id', $_USER->getId(), \PDO::PARAM_INT];

        /**
        *
        * CALCUL DU TOTAL
        *
        */

        $sqlCount = $sqlHeadCount . " " . $sqlFrom . " " . $sqlJoin . " " . $sqlCondition . " " . $sqlHaving;
        $total = (int)DB::fetchUnique($sqlCount, $data)['total'];


        /**
        *
        * LISTE FILTRÉE
        *
        */

        /**
        * NAME
        */
        if(isset($map['nickname']) && $map['nickname'] != ''){
            $data[] = [':nickname', $map['nickname'] . "%", \PDO::PARAM_STR];
            $sqlCondition .= " AND nickname LIKE :nickname";
        }

        /**
        * SEX
        */
        if(isset($map['sex']) && $map['sex'] != ''){
            $data[] = [':sex', $map['sex'], \PDO::PARAM_STR];
            $sqlCondition .= " AND u.sex = :sex";
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


        $sqlList = $sqlHeadList . " " . $sqlFrom . " " . $sqlJoin . " " . $sqlCondition . " " . $sqlHaving . " " . $sqlOrder . " " . $sqlLimit;
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

    // geocoding
    public function getLatLong(){
        //$address = $this->city . ', '. $this->getCountry()->getNicename();
        $address = $this->city;
        $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.urlencode($address));
        $output = json_decode($geocode);

        if($output->status == 'OK'){
            $this->setLatitude($output->results[0]->geometry->location->lat);
            $this->setLongitude($output->results[0]->geometry->location->lng);
        }
    }

    // reverse geocoding
    public function getCityFromCoord(){
        $geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$this->latitude.','.$this->longitude.'&result_type=country|locality&key=AIzaSyCjXk_CjR3VFOABhIhnZwu6K21V7m_gJw0');
        $output = json_decode($geocode);

        if($output->status == 'OK'){
            $this->setCity($output->results[0]->address_components[0]->long_name);
            $this->setCountryId(Country::getCountryIdByISO($output->results[0]->address_components[3]->short_name));
        }
    }


    /**
    * Détermine si l'utilisateur a la permission d'effectuer une action
    * @param string $group Groupe de permission
    * @param string $type Type de permission
    * @return bool
    */
    public function hasPermission(string $group, string $type) : bool{
        $list = $this->getPermissionList(false);
        if(!isset($list[$group])){
            return false;
        }
        if(!isset($list[$group][$type])){
            return false;
        }
        return (bool)$list[$group][$type];
    }

    /**
    * Récupère une permission
    * @param string $name
    * @return int
    */
    public static function getPermissionGroupIdByName(string $name) : int{
        return (int)(DB::fetchUnique(
            "SELECT id FROM ".DATABASE_CFG['prefix']."permission_group WHERE name = :name AND active = 1",
            array( [':name', $name, \PDO::PARAM_STR] )
        )['id']);
    }

    /**
    * Vérifie si un groupe de permission existe
    * @param int $id
    * @return bool
    */
    public static function isPermissionGroup(int $id) : bool{
        if($id == 0){
            return false;
        }
        return ((int)(DB::fetchUnique(
            "SELECT id FROM ".DATABASE_CFG['prefix']."permission_group WHERE id = :id",
            array( [':id', $id, \PDO::PARAM_INT] )
        )['id']) > 0);
    }


    /**
    * Permet de changer une permission
    * @param int|string $group
    * @param string $type
    * @param bool $permission
    */
    public function definePermission($group, string $type, bool $permission){
        $pname = substr($type, 0, 1);
        $group_id = is_int($group) ? $group : self::getPermissionGroupIdByName($group);

        // on vérifie que le groupe de permission existe
        if(!self::isPermissionGroup($group_id)){
            throw new \Exception(gettext("Undefined permission group"));
        }

        $sql = "
            INSERT INTO ".DATABASE_CFG['prefix']."user_permission (group_id, user_id, ".$pname.")
            VALUES(:group_id, :user_id, :permission)
            ON DUPLICATE KEY UPDATE ".$pname." = :permission;
        ";

        $data = array(
            [':group_id', $group_id, \PDO::PARAM_INT],
            [':user_id', $this->id, \PDO::PARAM_INT],
            [':permission', (int)$permission, \PDO::PARAM_INT]
        );

        DB::exec($sql, $data);
    }


    /**
    * Permet de changer plusieurs permissions
    * @param int|string $group
    * @param array $data
    */
    public function defineMultiplePermission($group, array $data = []){
        foreach($data as $key => $value){
            $this->definePermission($group, $key, $value);
        }
    }

    /**
    * Récupère la liste des permissions
    * @param bool $cache Force la récupération depuis la base ou le cache
    * @return array
    */
    public function getPermissionList(bool $cache = true){
        if(!$cache || !isset(self::$permission[$this->getId()])){
            $sql = "
            SELECT m.name,
            	IFNULL((SELECT p.r FROM ".DATABASE_CFG['prefix']."user_permission p WHERE p.user_id = :user_id AND p.group_id = m.id), 0) as \"read\",
                IFNULL((SELECT p.c FROM ".DATABASE_CFG['prefix']."user_permission p WHERE p.user_id = :user_id AND p.group_id = m.id), 0) as \"create\",
                IFNULL((SELECT p.u FROM ".DATABASE_CFG['prefix']."user_permission p WHERE p.user_id = :user_id AND p.group_id = m.id), 0) as \"update\",
                IFNULL((SELECT p.d FROM ".DATABASE_CFG['prefix']."user_permission p WHERE p.user_id = :user_id AND p.group_id = m.id), 0) as \"delete\",
                IFNULL((SELECT p.a FROM ".DATABASE_CFG['prefix']."user_permission p WHERE p.user_id = :user_id AND p.group_id = m.id), 0) as \"admin\"
            FROM ".DATABASE_CFG['prefix']."permission_group m
            WHERE m.active = 1;
            ";

            $data = DB::fetchMultiple($sql, array(
                [':user_id', $this->id, \PDO::PARAM_INT]
            ));

            $temp = [];
            for($i = 0, $n = count($data); $i < $n; $i++){
                $index = $data[$i]['name'];
                array_shift($data[$i]);
                $temp[$index] = array_map('boolval', $data[$i]);
            }

            self::$permission[$this->getId()] = $temp;
        }

        return self::$permission[$this->getId()];
    }


    public function isAdmin(string $group){
        if(isset(self::$permission[$this->getId()][$group])){
            return self::$permission[$this->getId()][$group]['admin'];
        }
        return false;
    }

    /**
    * Retourne la liste des animaux pour l'utilisateur courant
    * @param int $start
    * @param int $amount
    * @return array Tableau d'objets Animal
    */
    public function getAnimalList(array $map = []) : array{
        $currentPage = (int)($map['page'] ?? 0);
        $amountPerPage = 10;
        $maxPage = 0;
        $total = 0;

        $data = [];
        $data[] = [":id", $this->id, \PDO::PARAM_INT];


        $sqlHeadList = "SELECT *";
        $sqlHeadCount = "SELECT COUNT(*) as \"total\"";
        $sqlBody = "FROM ".DATABASE_CFG['prefix']."animal WHERE creator_id = :id AND active = 1";
        $sqlLimit = "";

        $sqlCount = $sqlHeadCount . " " . $sqlBody . " " . $sqlLimit;
        $total = (int)DB::fetchUnique($sqlCount, $data)['total'];

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

        $sqlList = $sqlHeadList . " " . $sqlBody . " " . $sqlLimit;
        $list = DB::fetchMultipleObject('App\Model\Animal', $sqlList, $data);

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


    /**
    * Retourne la liste des utilisateurs à X km à la ronde
    * @param int $distance
    * @return array
    */
    public function getListNearbyUser(int $distance){
        $sql = "
            SELECT u.*, SQRT( POW(111.2 * (u.latitude - :latitude), 2) + POW(111.2 * (:longitude - u.longitude) * COS(u.latitude / 57.3), 2) ) AS distance
            FROM ".DATABASE_CFG['prefix']."user u
            WHERE u.id != :id
            HAVING distance < :distance
            ORDER BY distance;
        ";

        return DB::fetchMultipleObject('App\Model\User', $sql, array(
            [":id", $this->id, \PDO::PARAM_INT],
            [":latitude", $this->latitude, \PDO::PARAM_STR],
            [":longitude", $this->longitude, \PDO::PARAM_STR],
            [":distance", $distance, \PDO::PARAM_INT]
        ));
    }


    protected function beforeInsert(){
        $this->password = hashPassword($this->password);

        // reCAPTCHA
        $this->handleCaptcha();

        // photo de profil
        $this->handleProfilePic();

        // geoloc
        if(isset($_POST['latitude']) && isset($_POST['longitude'])){
            $this->getCityFromCoord();
        }
        else if(isset($_POST['city'])){
            $this->getLatLong();
        }
    }

    protected function beforeUpdate(){
        // on gère l'édition du mot de passe
        $old_password = $_POST['old_password'] ?? null;
        $new_password = $_POST['new_password'] ?? null;
        $confirm_password = $_POST['confirm_password'] ?? null;

        if($new_password){
            if($new_password != $confirm_password){
                throw new \Exception(gettext("New and password confirmation does not match"));
            }
            if($this->password != hashPassword($old_password)){
                throw new \Exception(gettext("Wrong old password"));
            }

            // on assigne le nouveau mot de passe à la valeur stockée dans la BDD
            $this->setPassword($new_password, true);
        }

        $this->password = hashPassword($this->password);

        // photo de profil
        $this->handleProfilePic();

        // geoloc
        if(isset($_POST['latitude']) && isset($_POST['longitude'])){
            $this->getCityFromCoord();
        }
        else if(isset($_POST['city'])){
            $this->getLatLong();
        }
    }


    protected function afterInsert(){
        $this->createVerificationToken();

        // ajout des permissions basiques
        $this->defineMultiplePermission('animal_profile', array('read' => true, 'create' => true));
        $this->defineMultiplePermission('image', array('read' => true, 'create' => true));
        $this->defineMultiplePermission('messenger', array('read' => true, 'create' => true));
    }

    protected function afterUpdate(){}

    /**
    * Vérification du captcha avec l'API reCAPTCHA de Google
    */
    protected function handleCaptcha(){
        // récupération du captcha
        $temp = $_POST['g-recaptcha-response'] ?? '';

        $captcha = json_decode(curl_post('https://www.google.com/recaptcha/api/siteverify', array(
            'secret' => '6LcIPBUUAAAAAObdZCAIudQA_1qdaN_kzAKwBKkW',
            'response' => $temp,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        )));

        if(!$captcha || !$captcha->success){
            throw new \Exception(gettext("Failed verifying captcha"));
        }
    }

    /**
    * Permet de gérer l'envoi et le traitement de la photo de profil
    * @return void
    */
    protected function handleProfilePic(){
        if(isset($_FILES['image_file'])){
            $image = Image::upload($_FILES['image_file'], array(
                'extensions' => array('jpeg', 'jpg', 'png', 'gif'),
                'max_size' => 1048576 * 4
            ));

            if($image instanceof Image){
                Image::remove($this->getImage());

                $image->toProfilePic(400, 400);
                $image->createThumbnail(150);
                $this->setImageId($image->getId());
            }
        }
    }

    /**
    * Retourne une instance de la classe User à partir du mail
    * @param string $email
    * @return User
    */
    public static function getUniqueByEmail(string $email) : User{
        $sql = "SELECT * FROM ".DATABASE_CFG['prefix']."user WHERE email = :email AND active = 1 LIMIT 0, 1";
        $data = array( [":email", $email, \PDO::PARAM_STR] );

        return new User(DB::fetchUnique($sql, $data));
    }


    /**
    * Interroge la base de donnée sur une combinaison email/mot de passe
    * @param string $email
    * @param string $password
    * @return int ID du compte correspondant à la combinaison email/mot de passe
    */
    public static function login(string $email, string $password) : int{
        $sql = "SELECT id FROM ".DATABASE_CFG['prefix']."user WHERE email = :email AND password = :password AND banned = 0 AND active = 1 LIMIT 0, 1";
        $data = array(
            [":email", $email, \PDO::PARAM_STR],
            [":password", hashPassword($password), \PDO::PARAM_STR]
        );
        return (int)(DB::fetchUnique($sql, $data)['id']);
    }

    /**
    * Récupère les informations sur le status d'un compte
    * @param string $email
    * @return bool
    */
    public static function accountStatus(string $email) : array{
        $sql = "SELECT id, verified, banned FROM ".DATABASE_CFG['prefix']."user WHERE email = :email LIMIT 0, 1";
        $data = array( [":email", $email, \PDO::PARAM_STR] );

        $result = DB::fetchUnique($sql, $data);
        return array(
            'exists' => ($result['id'] > 0),
            'verified' => (bool)$result['verified'] ?? false,
            'banned' => (bool)$result['banned'] ?? false
        );
    }


    /**
    * Détermine si le compte associé à une adresse email est vérifié
    * @param string $email
    * @return bool
    */
    public static function isVerified(string $email) : bool{
        $sql = "SELECT id FROM ".DATABASE_CFG['prefix']."user WHERE email = :email AND verified = 1 AND active = 1 LIMIT 0, 1";
        $data = array( [":email", $email, \PDO::PARAM_STR] );

        return ((int)(DB::fetchUnique($sql, $data)['id']) > 0);
    }

    /**
    * Retourne l'ID du compte associé à une adresse email vérifiée (permet de savoir si le compte existe si il est > 0)
    * /!\ Ne permet pas de savoir si le compte est vérifié, juste si il existe
    * @param string $email
    * @return int
    */
    public static function userExists(string $email) : int{
        $sql = "SELECT id FROM ".DATABASE_CFG['prefix']."user WHERE email = :email AND active = 1 LIMIT 0, 1";
        $data = array( [":email", $email, \PDO::PARAM_STR] );

        return ((int)(DB::fetchUnique($sql, $data)['id']) > 0);
    }

    public static function userExistsById(int $id) : int{
        $sql = "SELECT id FROM ".DATABASE_CFG['prefix']."user WHERE id = :id AND active = 1 LIMIT 0, 1";
        $data = array( [":id", $id, \PDO::PARAM_INT] );

        return ((int)(DB::fetchUnique($sql, $data)['id']) > 0);
    }

    /**
    * @param string $nickname
    * @return bool
    */
    public static function isNicknameAvailable(string $nickname) : bool{
        $sql = "SELECT id FROM ".DATABASE_CFG['prefix']."user WHERE id != :id AND nickname = :nickname LIMIT 0, 1";
        $data = array( [":id", $_SESSION['uid'], \PDO::PARAM_INT], [":nickname", $nickname, \PDO::PARAM_STR] );

        return (DB::fetchUnique($sql, $data)['id'] == 0);
    }

    /**
    * @param string $email
    * @return bool
    */
    public static function isEmailAvailable(string $email) : bool{
        $sql = "SELECT id FROM ".DATABASE_CFG['prefix']."user WHERE id != :id AND email = :email LIMIT 0, 1";
        $data = array( [":id", $_SESSION['uid'], \PDO::PARAM_INT], [":email", $email, \PDO::PARAM_STR] );

        return (DB::fetchUnique($sql, $data)['id'] == 0);
    }

    /**
    * Permet de vérifier l'adresse email d'un utilisateur
    * @param string $token
    * @return void
    */
    public function verifyAccount(string $token){
        $sql = "SELECT token FROM ".DATABASE_CFG['prefix']."user_verification WHERE user_id = :id AND date_exp > NOW() LIMIT 0, 1";
        $data = array( [":id", $this->id, \PDO::PARAM_INT] );

        $storedToken = DB::fetchUnique($sql, $data)['token'];

        if(empty($storedToken)){
            throw new \Exception(gettext("Could not verify your account, no existing token"));
        }
        if(empty($token) || $storedToken !== $token){
            throw new \Exception(gettext("Invalid token"));
        }

        $this->verified = 1;
        $this->save(true);

        DB::exec("DELETE FROM ". DATABASE_CFG['prefix'] ."user_verification WHERE user_id = :id", array( [":id", $this->id, \PDO::PARAM_INT] ));
    }

    /**
    * Créé une clé de vérification associée au compte de l'utilisateur
    */
    public function createVerificationToken(){
        $token = getToken(32);

        DB::exec("
            INSERT INTO ".DATABASE_CFG['prefix']."user_verification (user_id, token, date_exp)
            VALUES(:id, :token, DATE_ADD(NOW(), INTERVAL 2 DAY))
            ON DUPLICATE KEY UPDATE token = :token, date_exp = DATE_ADD(NOW(), INTERVAL 2 DAY)
        ", array(
            [":id", $this->id, \PDO::PARAM_INT],
            [":token", $token, \PDO::PARAM_STR]
        ));

        $this->sendValidationMail($token);
    }


    /**
    * TODO : Créer un template HTML et compléter la fonction
    * Envoi le mail contenant le lien pour confirmer son compte
    * @param string $token
    * @return void
    */
    private function sendValidationMail(string $token){
        $mail = new \PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->setFrom(GLOBAL_CFG['email']);
        $mail->AddReplyTo(GLOBAL_CFG['noreply']);
        $mail->addAddress($this->email);

        $mail->isHTML(true);

        ob_start();
        echo '
        <html>
            <body>
                <table>
                    <tr><td>'.gettext("Verify your email adress").'</td></tr>
                    <tr><td>'.gettext("To finish setting up your account, we just need to make sure this email adress is yours. Please follow the link bellow (link expires in 48h) :").'</td></tr>
                    <tr><td><a href="https://'.GLOBAL_CFG['www'].'/?task=verify&email='.$this->email.'&token='.$token.'">'.sprintf(gettext("Verify %s"), $this->email).'</a></td></tr>
                </table>
            </body>
        </html>
        ';
        $html = ob_get_contents();
        ob_end_clean();

        $mail->Subject = gettext("Verify your email adress");
        $mail->Body = $html;
        $mail->send();
    }



    /**
    * Créé une clé de vérification associée au compte de l'utilisateur
    */
    public function createRecoveryToken(){
        $token = getToken(32);

        DB::exec("
            INSERT INTO ".DATABASE_CFG['prefix']."user_reset_password (user_id, token, date_exp)
            VALUES(:id, :token, DATE_ADD(NOW(), INTERVAL 1 DAY))
            ON DUPLICATE KEY UPDATE token = :token, date_exp = DATE_ADD(NOW(), INTERVAL 1 DAY)
        ", array(
            [":id", $this->id, \PDO::PARAM_INT],
            [":token", $token, \PDO::PARAM_STR]
        ));

        $this->sendResetMail($token);
    }

    /**
    * Retourne l'ID du compte associé à une adresse email vérifiée (permet de savoir si le compte existe si il est > 0)
    * /!\ Ne permet pas de savoir si le compte est vérifié, juste si il existe
    * @param string $token
    * @return void
    */
    public function resetPassword(string $token, string $password){
        $sql = "SELECT token FROM ".DATABASE_CFG['prefix']."user_reset_password WHERE user_id = :id AND date_exp > NOW() LIMIT 0, 1";
        $data = array( [":id", $this->id, \PDO::PARAM_INT] );

        $storedToken = DB::fetchUnique($sql, $data)['token'];

        if(empty($storedToken)){
            throw new \Exception(gettext("Could not reset password, no existing token"));
        }
        if(empty($token) || $storedToken !== $token){
            throw new \Exception(gettext("Invalid token"));
        }

        $this->setPassword($password, true);
        $this->save(true);

        DB::exec("DELETE FROM ". DATABASE_CFG['prefix'] ."user_reset_password WHERE user_id = :id", array( [":id", $this->id, \PDO::PARAM_INT] ));
    }


    /**
    * TODO : Créer un template HTML et compléter la fonction
    * Envoi le mail contenant le lien pour reset son mot de passe
    * @param string $token
    * @return void
    */
    private function sendResetMail(string $token){
        $mail = new \PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->setFrom(GLOBAL_CFG['email']);
        $mail->AddReplyTo(GLOBAL_CFG['noreply']);
        $mail->addAddress($this->email);

        $mail->isHTML(true);

        ob_start();
        echo '
        <html>
            <body>
                <table>
                    <tr><td>'.gettext("Please visit the following page to reset your password (link expires in 24h) :").'</td></tr>
                    <tr><td><a href="https://'.GLOBAL_CFG['www'].'/?task=reset&email='.$this->email.'&token='.$token.'">Reset my password</a></td></tr>
                </table>
            </body>
        </html>
        ';
        $html = ob_get_contents();
        ob_end_clean();

        $mail->Subject = gettext("Password reset request");
        $mail->Body = $html;
        $mail->send();
    }


    public static function deleteById(int $id, string $options = ""){
        DB::exec("DELETE FROM ".DATABASE_CFG['prefix']."image WHERE creator_id = :id", array([':id', $id, \PDO::PARAM_INT]));
        parent::deleteById($id, $options);
    }

    // setters
    public function setNickname(string $nickname, bool $check = false){
        if($check){
            if(!testUsername($nickname)){
                throw new \Exception(gettext("Invalid nickname format"));
            }
            if($this->nickname != $nickname && !User::isNicknameAvailable($nickname)){
                throw new \Exception(gettext("Nickname already used"));
            }
        }

        $this->nickname = $nickname;
    }
    public function setPassword(string $password, bool $check = false){
        if($check && !testPassword($password)) throw new \Exception(gettext("Invalid password format"));
        $this->password = $password;
    }
    public function setLastname(string $lastname){
        $this->lastname = $lastname;
    }
    public function setFirstname(string $firstname){
        $this->firstname = $firstname;
    }
    public function setEmail(string $email, bool $check = false){
        if($check){
            if(!testMail($email)){
                throw new \Exception(gettext("Invalid email format"));
            }
            if($this->email != $email && !User::isEmailAvailable($email)){
                throw new \Exception(gettext("Email already used"));
            }
        }

        $this->email = $email;
    }
    public function setSex(string $sex){
        $this->sex = $sex;
    }
    public function setImageId($id){
        $this->image_id = $id;
    }
    public function setDescription(string $desc){
        $this->description = $desc;
    }
    public function setCity(string $city){
        $this->city = $city;
    }
    public function setLatitude($lat){
        $this->latitude = (!empty($lat)) ? $lat : NULL;
    }
    public function setLongitude($lng){
        $this->longitude = (!empty($lng)) ? $lng : NULL;
    }
    public function setCountryId(int $country_id){
        $this->country_id = $country_id;
    }
    public function setDateBirth(string $date = NULL, bool $check = false){
        if($check && !testAge($date))
            throw new \Exception(gettext("You must be at least 13 years old"));
        $this->date_birth = $date;
    }
    public function setDateBirth2(array $date_brith, bool $check = false){
        $day = (int)$date_brith['day'];
        $month = (int)$date_brith['month'];
        $year = (int)$date_brith['year'];

        $date = date("Y-d-m", strtotime($year.'-'.$month.'-'.$day));

        if($check && !testAge($date))
            throw new \Exception(gettext("You must be at least 13 years old"));

        $this->date_birth = $date;
    }
    public function setVerified(int $verified){
        $this->verified = $verified;
    }
    public function setBanned(int $banned){
        $this->banned = $banned;
    }

    // getters
    public function getCreatorId() : int{
        return $this->id;
    }
    public function getNickname() : string{
        return $this->nickname;
    }
    public function getPassword() : string{
        return $this->password;
    }
    public function getLastname() : string{
        return $this->lastname;
    }
    public function getFirstname() : string{
        return $this->firstname;
    }
    public function getEmail() : string{
        return $this->email;
    }
    public function getSex() : string{
        return $this->sex;
    }
    public function getImageId(){
        return $this->image_id;
    }
    public function getImage(){
        return ($this->image_id > 0) ? Image::getUniqueById($this->image_id) : NULL;
    }
    public function getDescription() : string{
        return $this->description;
    }
    public function getCity() : string{
        return $this->city;
    }
    public function getLatitude(){
        return $this->latitude;
    }
    public function getLongitude(){
        return $this->longitude;
    }
    public function getCountryId() : int{
        return $this->country_id;
    }
    public function getCountry(){
        return ($this->country_id > 0) ? Country::getUniqueById($this->country_id) : NULL;
    }
    public function getDateBirth(){
        return $this->date_birth;
    }
    public function getAge() : int{
        return dateToAge((string)$this->getDateBirth());
    }
    public function getVerified() : int{
        return $this->verified;
    }
    public function getBanned() : int{
        return $this->banned;
    }
}
