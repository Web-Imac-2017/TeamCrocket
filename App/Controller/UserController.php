<?php
/**
* Gontroller des User
* @author METTER-ROTHAN Jérémie
*/

namespace App\Controller;

use App\Model\User;
use App\Model\LogConnexion;
use App\Model\Country;

class UserController extends BucketAbstractController
{
    public function whois() : User{
        $user = User::getUniqueById($_SESSION['uid']);
        if($user->getId() == 0){
            throw new \Exception(gettext("You must sign in"));
        }
        return $user;
    }

    public function list() : array{
        return User::filter($_POST);
    }

    public function list_countries() : array{
        return Country::filter($_POST);
    }

    public function list_animal() : array{
        $user = User::getUniqueById($_SESSION['uid']);
        if($user->getId() == 0){
            throw new \Exception(gettext("You must sign in"));
        }
        return $user->getAnimalList($_POST);
    }

    /**
    * Récupère un utilisateur
    * @param int $id ID de l'utilisateur
    */
    public function get(int $id = 0) : User{
        $user = User::getUniqueById($id);
        if($user->getId() == 0){
            throw new \Exception(sprintf(gettext("User profile %s does not exist"), 'n°'.$id));
        }
        return $user;
    }

    /**
    * Modifie ou créé un utilisateur
    */
    public function edit() : User{
        $id = (isset($_POST['id'])) ? (int)$_POST['id'] : 0;

        $user = User::getUniqueById($id);
        $user->hydrate($_POST, true);
        $user->save($id == 0);

        return $user;
    }

    /**
    * Supprime un utilisateur
    * @param int $id ID de l'utilisateur
    */
    public function delete(int $id){
        User::deleteById($id);
    }

    /**
    * Connecte l'utilisateur
    * Gère également la vérification du compte dans le cas où le token est fourni avec les informations d'authentification
    */
    public function login(){
        if($_SESSION['uid'] > 0){
            throw new \Exception(gettext("Already logged in"));
        }

        if(!isset($_SESSION['login_attempts'])){
            $_SESSION['login_attempts'] = 0;
        }

        if($_SESSION['login_attempts'] > 10){
            /*
            * TODO Réactiver la limite
            */
            #throw new \Exception(gettext("Too many login attempts"));
        }
        $_SESSION['login_attempts']++;

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if(!User::userExists($email)){
            throw new \Exception(gettext("No account existing for the given email adress"));
        }
        if(!User::isVerified($email)){
            if(isset($_POST['token'])){
                $this->verify($email, $_POST['token']);
            }
            else{
                throw new \Exception(gettext("Please verify your account"));
            }
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

    /**
    * Déconnecte l'utilisateur
    */
    public function logout(){
        $_SESSION['uid'] = 0;
    }

    /**
    * Vérifie le compte d'un utilisateur
    * @param string $email
    * @param string $token
    */
    public function verify(string $email, string $token){
        $user = User::getUniqueByEmail($email);
        if($user->getId() == 0){
            throw new \Exception(gettext("No account existing for the given email adress"));
        }
        $user->verifyAccount($token);
    }

    /**
    * Créé un token de récupération du mot de passe et envoi le mail correspondant
    */
    public function forgottenpassword(string $email){
        $user = User::getUniqueByEmail($email);
        if($user->getId() == 0){
            throw new \Exception(gettext("No account existing for the given email adress"));
        }
        $user->createRecoveryToken();
    }

    /**
    * Change le mot de passe de l'utilisateur suite à une demande de récupération
    */
    public function reset(){
        $email = $_POST['email'] ?? '';
        $token = $_POST['token'] ?? '';
        $password1 = $_POST['password1'] ?? '';
        $password2 = $_POST['password2'] ?? '';
        if($password1 !== $password2){
            throw new Exception(gettext("Password confirmation does not match"));
        }

        $user = User::getUniqueByEmail($email);
        if($user->getId() == 0){
            throw new \Exception(gettext("No account existing for the given email adress"));
        }
        $user->resetPassword($token, $password1);
    }
}
