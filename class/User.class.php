<?php
/*
@table user
@field id, int
@field nickname, string
@field email, string
*/
class User extends Bucket implements BucketInterface
{
    private $nickname = "";
    private $email = "";

    function __construct($data = NULL){
        parent::__construct($data);
    }

    public function isNew() : bool{
        return (!$this->id);
    }

    public function check() : bool{
        return true;
    }

    // setters
    public function setNickname(string $nickname){
        $this->nickname = $nickname;
    }
    public function setEmail(string $email){
        $this->email = $email;
    }

    // getters
    public function getNickname() : string{
        return $this->nickname;
    }
    public function getEmail() : string{
        return $this->email;
    }
}
