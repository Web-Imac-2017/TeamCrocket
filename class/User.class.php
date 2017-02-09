<?php
/*
@table user
@field id, int
@field nickname, string
@field password, string
@field lastname, string
@field firstname, string
@field email, string
@field sex, string
@field image, string
@field description, string
@field city, string
@field country, string
@field latitude, float
@field longitude, float
@field date_birth, date
*/

class User extends Bucket implements BucketInterface
{
    const SEX_MALE = 'h';
    const SEX_FEMALE = 'f';

    const PASSWORD_SALT = 'Im4c#';

    private $nickname = "";
    private $password = "";
    private $old_password;
    private $new_password;
    private $confirm_password;
    private $lastname = "";
    private $firstname = "";
    private $email = "";
    private $sex = SEX_MALE;
    private $image = "";
    private $description = "";
    private $city = "";
    private $latitude = 0;
    private $longitude = 0;
    private $country = "FRA";
    private $date_birth;

    function __construct($data = NULL){
        parent::__construct($data);
    }

    public function isNew() : bool{
        return (!$this->id);
    }

    // permet de contrôler l'intégrité des valeurs avant de les envoyer
    public function check(){
        // cas où on modifie le mot de passe
        if($this->new_password && $this->id > 0){
            if($this->new_password != $this->confirm_password){
                $this->addError("password", "New and password confirmation does not match");
            }
            if($this->password != User::hashPassword($this->old_password)){
                $this->addError("password", "Wrong old password");
            }
            if(!testPassword($this->new_password)){
                $this->addError("password", "Invalid format");
            }

            // on assigne le nouveau mot de passe à la valeur stockée dans la BDD
            $this->password = User::hashPassword($this->new_password);
        }

        if($this->new_password && $this->id == 0){
            if(!testPassword($this->new_password)) $this->addError("password", "Invalid format");
            $this->password = User::hashPassword($this->new_password);
        }

        if(!testMail($this->email)) $this->addError("email", "Invalid format");
        if(!testUsername($this->nickname)) $this->addError("nickname", "Invalid format");
    }

    public static function hashPassword(string $password) : string{
        return sha1(self::PASSWORD_SALT . '/' . $password);
    }

    // setters
    public function setNickname(string $nickname){
        $this->nickname = $nickname;
    }
    public function setPassword(string $password){
        $this->password = $password;
    }
    public function setOld_password(string $password){
        $this->old_password = $password;
    }
    public function setNew_password(string $password){
        $this->new_password = $password;
    }
    public function setConfirm_password(string $password){
        $this->confirm_password = $password;
    }
    public function setLastname(string $lastname){
        $this->lastname = $lastname;
    }
    public function setFirstname(string $firstname){
        $this->firstname = $firstname;
    }
    public function setEmail(string $email){
        $this->email = $email;
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
}
