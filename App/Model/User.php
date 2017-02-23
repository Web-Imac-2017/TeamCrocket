<?php
/**
* Utilisateur
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model;

/*
@table user
@field nickname, string
@field password, string, hashPassword
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
@field verified, int
*/

class User extends Bucket\BucketAbstract
{
    // profile picture
    const SEX_MALE = 'h';
    const SEX_FEMALE = 'f';

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

    function __construct($data = NULL){
        $this->nickname = "";
        $this->password = "";
        $this->lastname = "";
        $this->firstname = "";
        $this->email = "";
        $this->sex = self::SEX_MALE;
        $this->description = "";
        $this->city = "";
        $this->latitude = 0;
        $this->longitude = 0;
        $this->country_id = 73;
        $this->date_birth;
        $this->verified = 0;

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
            'country_id' => $this->country_id,
            'date_birth' => $this->date_birth,
            'creation_date' => $this->creation_date
        );
    }

    // geocoding
    public function getLatLong(){
        $address = $this->city . ', '. $this->getCountry()->getNicename();
        $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');
        $output = json_decode($geocode);

        if($output->status == 'OK'){
            $this->setLatitude($output->results[0]->geometry->location->lat);
            $this->setLongitude($output->results[0]->geometry->location->lng);
        }
    }

    // reverse geocoding
    public function getCityFromCoord(){
        $geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$this->getLatitude().','.$this->getLongitude().'&result_type=country|locality&key=AIzaSyCjXk_CjR3VFOABhIhnZwu6K21V7m_gJw0');
        $output = json_decode($geocode);

        if($output->status == 'OK'){
            $this->setCity($output->results[0]->address_components[0]->long_name);
            $this->setCountryId(Country::getCountryIdByISO($output->results[0]->address_components[3]->short_name));
        }
    }

    /**
    * Retourne la liste des animaux pour l'utilisateur courant
    * @param int $start
    * @param int $amount
    * @return array Tableau d'objets Animal
    */
    public function getAnimalList(int $start = -1, int $amount = -1) : array{
        $limit = ($start != -1 && $amount != -1) ? "LIMIT :start, :amount" : "";
        $data = [];
        $data[] = [":id", $this->id, \PDO::PARAM_INT];

        if($start != -1 && $amount != -1){
            $data[] = [":start", $start, \PDO::PARAM_INT];
            $data[] = [":amount", $amount, \PDO::PARAM_INT];
        }

        $sql = "SELECT * FROM ".DATABASE_CFG['prefix']."animal WHERE owner_id = :id AND active = 1 {$limit}";

        return DB::fetchMultipleObject('App\Model\Animal', $sql, $data);
    }

    protected function beforeInsert(){
        // on vérifie que l'utilisateur n'existe pas encore
        if(User::userExists($this->email)){
            throw new \Exception(gettext("An account already exists with this email adress"));
        }

        // reCAPTCHA
        $this->handleCaptcha();

        // photo de profil
        $this->handleProfilePic();
    }

    protected function beforeUpdate(){
        // API GEOLOC
        $this->getLatLong();

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


        // photo de profil
        $this->handleProfilePic();
    }

    protected function afterInsert(){
        $this->createVerificationToken();
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

            if($image->getId() > 0){
                $image->toProfilePic(400, 400);

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
        $sql = "SELECT id FROM ".DATABASE_CFG['prefix']."user WHERE email = :email AND password = :password AND active = 1 LIMIT 0, 1";
        $data = array(
            [":email", $email, \PDO::PARAM_STR],
            [":password", hashPassword($password), \PDO::PARAM_STR]
        );
        return (int)(DB::fetchUnique($sql, $data)['id']);
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

    /**
    * Vérifie l'existence d'un ID de compte
    * /!\ Ne permet pas de savoir si le compte est vérifié, juste si il existe
    * @param int $id
    * @return bool
    */
    public static function userExistsById(int $id) : bool{
        $sql = "SELECT id FROM ".DATABASE_CFG['prefix']."user WHERE id = :id AND active = 1 LIMIT 0, 1";
        $data = array( [":id", $id, \PDO::PARAM_INT] );

        return (DB::fetchUnique($sql, $data)['id'] > 0);
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
        $this->save();

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
                    <tr><td><a href="http://'.$_SERVER['HTTP_HOST'].'/'.GLOBAL_CFG['subdir'].'/index.php?task=verify&email='.$this->email.'&token='.$token.'">'.sprintf(gettext("Verify %s"), $this->email).'</a></td></tr>
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
        $this->save();

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
                    <tr><td><a href="http://'.$_SERVER['HTTP_HOST'].'/'.GLOBAL_CFG['subdir'].'/index.php?task=reset&email='.$this->email.'&token='.$token.'">Reset my password</a></td></tr>
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

    // setters
    public function setNickname(string $nickname, bool $check = false){
        if($check && !testUsername($nickname)) throw new \Exception(gettext("Invalid nickname format"));
        else $this->nickname = $nickname;
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
        if($check && !testMail($email)) throw new \Exception(gettext("Invalid email format"));
        else $this->email = $email;
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
    public function setLatitude(float $lat){
        $this->latitude = $lat;
    }
    public function setLongitude(float $lng){
        $this->longitude = $lng;
    }
    public function setCountryId(string $country_id){
        $this->country_id = $country_id;
    }
    public function setDateBirth(string $date = NULL, bool $check = false){
        if($check && !testAge($date)) throw new \Exception(gettext("You must be at least 13 years old"));
        $this->date_birth = $date;
    }
    public function setVerified(int $verified){
        $this->verified = $verified;
    }

    // getters
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
    public function getImage() : Image{
        return Image::getUniqueById((int)$this->image_id);
    }
    public function getDescription() : string{
        return $this->description;
    }
    public function getCity() : string{
        return $this->city;
    }
    public function getLatitude() : float{
        return $this->latitude;
    }
    public function getLongitude() : float{
        return $this->longitude;
    }
    public function getCountryId() : int{
        return $this->country_id;
    }
    public function getCountry() : Country{
        return Country::getUniqueById($this->country_id);
    }
    public function getDateBirth(){
        return $this->date_birth;
    }
    public function getVerified() : int{
        return $this->verified;
    }
}
