<?php
/**
* Utilisateur
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model;

use \Imagine\Image\Point;
use \Imagine\Image\Box;
use \Imagine\Gd\Imagine;

/*
@table user
@field nickname, string
@field password, string, hashPassword
@field lastname, string
@field firstname, string
@field email, string
@field sex, string
@field image, string
@field description, string
@field city, string
@field country, string, formatCountry
@field latitude, float
@field longitude, float
@field date_birth, date
@field verified, int
*/

class User extends Bucket\BucketAbstract
{
    // profile picture
    const PROFILE_PIC_EXTENSION = array('jpeg', 'jpg', 'png', 'gif');
    const PROFILE_PIC_MAX_SIZE = 1048576 * 2; // 2mo
    const PROFILE_PIC_MAX_WIDTH = 400;
    const PROFILE_PIC_MAX_HEIGHT = 400;

    const SEX_MALE = 'h';
    const SEX_FEMALE = 'f';

    private $nickname;
    private $password;
    private $lastname;
    private $firstname;
    private $email;
    private $sex;
    private $image;
    private $description;
    private $city;
    private $latitude;
    private $longitude;
    private $country;
    private $date_birth;
    private $verified;

    function __construct($data = NULL){
        $this->nickname = "";
        $this->password = "";
        $this->lastname = "";
        $this->firstname = "";
        $this->email = "";
        $this->sex = self::SEX_MALE;
        $this->image = "";
        $this->description = "";
        $this->city = "";
        $this->latitude = 0;
        $this->longitude = 0;
        $this->country = "FRA";
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
            'image' => $this->image,
            'description' => $this->description,
            'city' => $this->city,
            'position' => array(
                'lat' => $this->latitude,
                'lng' => $this->longitude
            ),
            'country' => $this->country,
            'date_birth' => $this->date_birth,
            'creation_date' => $this->creation_date
        );
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
        if($_SESSION['uid'] == 0){
            throw new \Exception("You must sign in");
        }

        // on gère l'édition du mot de passe
        $old_password = $_POST['user']['old_password'] ?? null;
        $new_password = $_POST['user']['new_password'] ?? null;
        $confirm_password = $_POST['user']['confirm_password'] ?? null;

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
        // image de profil
        $upload = $_FILES['image_file'] ?? null;

        if(is_uploaded_file($upload['tmp_name'])){
            $dir = ROOT_UPLOADS . "/users/" . $this->nickname . "/";
            $filename = $nom = md5(uniqid(rand(), true));
            $extension = @explode('/', $upload['type'])[1];

            // vérifications de l'intégrité du fichier
            if($_FILES['image_file']['error'] > 0){
                throw new \Exception(gettext("Error") . " " . $_FILES['image_file']['error']);
            }
            if(!in_array($extension, self::PROFILE_PIC_EXTENSION)){
                throw new \Exception(sprintf(gettext("Invalid image extension (only %s)"), implode(self::PROFILE_PIC_EXTENSION, ", ")));
            }
            if($upload['size'] > self::PROFILE_PIC_MAX_SIZE){
                throw new \Exception(gettext("File is too large"));
            }

            // création du dossier de destination si il n'existe pas encore
            if(!is_dir($dir)){
                mkdir($dir, 0777, true);
            }

            // déplacement du fichier depuis le dossier tmp
            $path = $dir . $filename . '.' . $extension;
            if(!move_uploaded_file($upload['tmp_name'], $path)){
                throw new \Exception(gettext("Could not move image"));
            }
            else{
                // traitement sur le fichier
                $imagine = new Imagine();
                $image = $imagine->open($path);
                list($width, $height) = getimagesize($path);

                $cropSize = ($width > $height) ? $height : $width;
                $cropPosX = $width / 2 - $cropSize / 2;
                $cropPosY = $height / 2 - $cropSize / 2;

                // on créé un beau carré
                $image->crop(new Point($cropPosX, $cropPosY), new Box($cropSize, $cropSize));
                // on redimensionne selon les tailles max
                $image->resize(new Box(self::PROFILE_PIC_MAX_WIDTH, self::PROFILE_PIC_MAX_HEIGHT));

                // options
                $options = [];
                if($extension == 'jpeg' || $extension == 'jpg'){
                    $options['jpeg_quality'] = 70;
                }
                else if($extension == 'png'){
                    $options['png_compression_level'] = 9;
                }

                // enregistrement
                $image->save($path, $options);


                $this->image = $path;
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
        $sql = "SELECT id FROM ".DATABASE_CFG['prefix']."user WHERE email = :email AND password = :password AND verified = 1 AND active = 1 LIMIT 0, 1";
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
    * @return bool
    */
    public static function userExists(string $email) : int{
        $sql = "SELECT id FROM ".DATABASE_CFG['prefix']."user WHERE email = :email AND active = 1 LIMIT 0, 1";
        $data = array( [":email", $email, \PDO::PARAM_STR] );

        return ((int)(DB::fetchUnique($sql, $data)['id']) > 0);
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
                    <tr><td><a href="http://'.$_SERVER['HTTP_HOST'].'/'.GLOBAL_CFG['subdir'].'/api/user/verify/'.$this->email.'/'.$token.'">'.sprintf(gettext("Verify %s"), $this->email).'</a></td></tr>
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
                    <tr><td><a href="http://'.$_SERVER['HTTP_HOST'].'/'.GLOBAL_CFG['subdir'].'/api/user/reset/'.$this->email.'/'.$token.'">Reset my password</a></td></tr>
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
    public function setImage(string $path){
        $this->image = $path;
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
    public function setCountry(string $country){
        $this->country = $country;
    }
    public function setDateBirth(string $date = NULL){
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
    public function getImage() : string{
        return $this->image;
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
    public function getCountry() : string{
        return $this->country;
    }
    public function getDateBirth(){
        return $this->date_birth;
    }
    public function getVerified() : int{
        return $this->verified;
    }
}
