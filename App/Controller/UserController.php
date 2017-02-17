<?php
/**
* Gontroller des User
* @author METTER-ROTHAN Jérémie
*/

namespace App\Controller;

use App\Model\User;
use App\Model\Log;
use App\Model\Bucket\BucketFilter;

class UserController extends BucketAbstractController
{
    public function list($page = -1) : array{
        $filter = [];

        $data = User::getMultiple(array(
            'page' => (int)$page,
            'amount' => 10,
            'filter' => $filter,
            'order' => 'creation_date DESC'
        ));
        return $data;
    }

    public function edit(){
        $id = (isset($_POST['id'])) ? (int)$_POST['id'] : 0;

        $user = User::getUniqueById($id);
        $user->hydrate($_POST, true);
        $user->save();

        return $user;
    }

    public function delete(int $id){
        User::deleteById($id);
    }

    public function login(){
        if(!isset($_SESSION['login_attempts'])){
            $_SESSION['login_attempts'] = 0;
        }

        if($_SESSION['login_attempts'] > 10){
            throw new \Exception("Too many login attempts");
        }
        $_SESSION['login_attempts']++;

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';



        if(!User::userExists($email)){
            throw new \Exception(gettext("No account existing for the given email adress"));
        }
        if(!User::isVerified($email)){
            throw new \Exception(gettext("Please verify your account"));
        }

        $id = User::login($email, $password);
        if($id == 0){
            throw new \Exception(gettext("Wrong credentials, login failed"));
        }

        $_SESSION['uid'] = $id;
        $_SESSION['login_attempts'] = 0;

        $user = User::getUniqueById($id);
        LogConnexion::register($user);
        return $user;
    }

    public function disconnect(){
        $_SESSION['uid'] = 0;
    }

    public function verify(string $email, string $token){
        $user = User::getUniqueByEmail($email);
        if($user->getId() == 0){
            throw new \Exception("No account existing for the given email adress");
        }
        $user->verifyAccount($token);
    }

    public function forgottenpassword(string $email){
        $user = User::getUniqueByEmail($email);
        if($user->getId() == 0){
            throw new \Exception("No account existing for the given email adress");
        }
        $user->createRecoveryToken();
    }

    public function reset(string $email, string $token, string $new_password = ''){
        $user = User::getUniqueByEmail($email);
        if($user->getId() == 0){
            throw new \Exception("No account existing for the given email adress");
        }
        $user->resetPassword($token, $new_password);
    }

    public function test(){
        $user = User::getUniqueByEmail('jmetterrothan@gmail.com');
        $user->createVerificationToken();
    }
}
