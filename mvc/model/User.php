<?php
/**
* Utilisateur
* @author METTER-ROTHAN Jérémie
*/

/*
@table user
@field id, int
@field nickname, string
@field password, string, User::hashPassword
@field lastname, string
@field firstname, string
@field email, string
@field sex, string
@field image, string
@field description, string
@field city, string
@field country, string, User::formatCountry
@field latitude, float
@field longitude, float
@field date_birth, date
@field verified, int
*/

class User extends Bucket\Bucket
{
    const SEX_MALE = 'h';
    const SEX_FEMALE = 'f';

    const PASSWORD_SALT = 'Im4c#';

    private $nickname = "";
    private $password = "";
    private $lastname = "";
    private $firstname = "";
    private $email = "";
    private $sex = self::SEX_MALE;
    private $image = "";
    private $description = "";
    private $city = "";
    private $latitude = 0;
    private $longitude = 0;
    private $country = "FRA";
    private $date_birth;
    private $verified = 0;

    function __construct($data = NULL){
        parent::__construct($data);
    }

    protected function beforeInsert(){
        // on vérifie que l'utilisateur n'existe pas encore
        if(User::userExists($this->email)){
            $this->addError("email", "An account already exists with this email adress");
        }


        // photo de profil
        $this->handleProfilePic();
    }

    protected function beforeUpdate(){
        // on gère l'édition du mot de passe
        $old_password = $_POST['user']['old_password'] ?? null;
        $new_password = $_POST['user']['new_password'] ?? null;
        $confirm_password = $_POST['user']['confirm_password'] ?? null;

        if($new_password){
            if($new_password != $confirm_password){
                $this->addError("password", "New and password confirmation does not match");
            }
            if($this->password != self::hashPassword($old_password)){
                $this->addError("password", "Wrong old password");
            }

            // on assigne le nouveau mot de passe à la valeur stockée dans la BDD
            $this->setPassword($new_password, true);
        }


        // photo de profil
        $this->handleProfilePic();
    }

    protected function afterInsert(){}

    protected function afterUpdate(){}

    /**
    * Permet de gérer l'envoi et le traitement de la photo de profil
    * @return void
    */
    protected function handleProfilePic(){
        // image de profil
        $upload = $_FILES['image_file'] ?? null;

        try{
            if(is_uploaded_file($upload['tmp_name'])){
                $dir = ROOT_UPLOADS . "/users/" . $this->nickname . "/";
                $filename = $nom = md5(uniqid(rand(), true));
                $extension = @explode('/', $upload['type'])[1];

                // vérifications de l'intégrité du fichier
                if($_FILES['image_file']['error'] > 0){
                    throw new Exception("Error " . $_FILES['image_file']['error']);
                }
                if(!in_array($extension, PROFILE_PIC_EXTENSION)){
                    throw new Exception("Invalid image extension (only " . implode(PROFILE_PIC_EXTENSION, ", ") . ")");
                }
                if($upload['size'] > PROFILE_PIC_MAX_SIZE){
                    throw new Exception("File is too large");
                }

                // création du dossier de destination si il n'existe pas encore
                if(!is_dir($dir)){
                    mkdir($dir, 0777, true);
                }

                // déplacement du fichier depuis le dossier tmp
                $path = $dir . $filename . '.' . $extension;
                if(!move_uploaded_file($upload['tmp_name'], $path)){
                    throw new Exception("image", "Could not move image");
                }
                else{
                    // traitement sur le fichier
                    $imagine = new Imagine\Gd\Imagine();
                    $image = $imagine->open($path);
                    list($width, $height) = getimagesize($path);

                    $cropSize = ($width > $height) ? $height : $width;
                    $cropPosX = $width / 2 - $cropSize / 2;
                    $cropPosY = $height / 2 - $cropSize / 2;

                    // on créé un beau carré
                    $image->crop(new Imagine\Image\Point($cropPosX, $cropPosY), new Imagine\Image\Box($cropSize, $cropSize));
                    // on redimensionne selon les tailles max
                    $image->resize(new Imagine\Image\Box(PROFILE_PIC_MAX_WIDTH, PROFILE_PIC_MAX_HEIGHT));

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
        catch(Exception $e){
            $this->addError("image", $e->getMessage());
        }
    }

    /**
    * Permet de crypter un mot de passe
    * @param string $password Mot de passe en clair
    * @return string Version hashé du mot de passe
    */
    public static function hashPassword(string $password) : string{
        return (!is_sha1($password)) ? sha1(self::PASSWORD_SALT . '/' . $password) : $password;
    }

    /**
    * Retourne le code du pays selon le format ISO 3166-2
    * @param string $country
    * @return string Code pays formaté
    */
    public static function formatCountry(string $country) : string{
        return strtoupper(substr($country, 0, 3));
    }

    /**
    * Interroge la base de donnée sur une combinaison email/mot de passe
    * @param string $email
    * @param string $password
    * @return int ID du compte correspondant à la combinaison email/mot de passe
    */
    public static function login(string $email, string $password) : int{
        $sql = "SELECT id FROM ".DB_PREFIX."user WHERE email = :email AND password = :password AND verified = 1 LIMIT 0, 1";
        $data = array(
            [":email", $email, PDO::PARAM_STR],
            [":password", self::hashPassword($password), PDO::PARAM_STR]
        );
        return (int)(DB::fetchUnique($sql, $data)['id']);
    }

    /**
    * Détermine si le compte associé à une adresse email est vérifié
    * @param string $email
    * @return bool
    */
    public static function isVerified(string $email) : bool{
        $sql = "SELECT id FROM ".DB_PREFIX."user WHERE email = :email AND verified = 1 AND active = 1 LIMIT 0, 1";
        $data = array(
            [":email", $email, PDO::PARAM_STR]
        );

        return (int)(DB::fetchUnique($sql, $data)['id']) > 0;
    }

    /**
    * Retourne l'ID du compte associé à une adresse email vérifiée (permet de savoir si le compte existe si il est > 0)
    * /!\ Ne permet pas de savoir si le compte est vérifié, juste si il existe
    * @param string $email
    * @return bool
    */
    public static function userExists(string $email) : int{
        $sql = "SELECT id FROM ".DB_PREFIX."user WHERE email = :email AND active = 1 LIMIT 0, 1";
        $data = array(
            [":email", $email, PDO::PARAM_STR]
        );

        return (int)(DB::fetchUnique($sql, $data)['id']);
    }


    // setters
    public function setNickname(string $nickname, bool $check = false){
        if($check && !testUsername($nickname)) $this->addError("nickname", gettext("Invalid format"));
        else $this->nickname = $nickname;
    }
    public function setPassword(string $password, bool $check = false){
        if($check && !testPassword($password)) $this->addError("password", gettext("Invalid format"));
        $this->password = $password;
    }
    public function setLastname(string $lastname){
        $this->lastname = $lastname;
    }
    public function setFirstname(string $firstname){
        $this->firstname = $firstname;
    }
    public function setEmail(string $email, bool $check = false){
        if($check && !testMail($email)) $this->addError("email", gettext("Invalid format"));
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
    public function setDate_birth(string $date = NULL){
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
    public function getDate_birth(){
        return $this->date_birth;
    }
    public function getVerified() : int{
        return $this->verified;
    }
}
