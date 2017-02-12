<?php
/**
* Gère les actions liées au compte utilisateur et à la session
* @author METTER-ROTHAN Jérémie
*/


if(!isset($_SESSION['uid'])){
    $_SESSION['uid'] = 0;
}

// Compte de l'utilisateur courant
$GLOBALS['_USER'] = User::getUniqueById($_SESSION['uid']);



if(isset($_REQUEST['task'])){
    switch($_REQUEST['task']){
        case 'subscribe' :
        case 'edit_profile' :
            if(isset($_POST['user'])){
                $_USER->hydrate($_POST['user'], true);

                try{
                    $_USER->save();
                }
                catch(Bucket\BucketSaveException $e){}
            }
            break;

        case 'disconnect' :
            $_SESSION['uid'] = 0;
            header("Location:index.php");
            break;

        case 'login' :
            $id = User::login($_POST['email'], $_POST['password']);

            if($id > 0){
                $_SESSION['uid'] = $id;
                header("Location:index.php");
            }
            else{
                $_USER->addError("login", "Failed to log in");
            }
            break;


        case 'verify' :
            $email = $_GET['email'] ?? '';
            $token = $_GET['token'] ?? '';

            $user = User::getUniqueByEmail($email);
            if($user->getId() > 0){
                $user->verifyAccount($token);
            }
            else{
                $_USER->addError("verify", "No account is registered with the email adress '{$email}'");
            }
            break;


        case 'reset' :
            $email = $_POST['email'] ?? '';

            $user = User::getUniqueByEmail($email);
            if($user->getId() > 0){
                $user->createRecoveryToken();
            }
            else{
                $_USER->addError("reset", "No account is registered with the email adress '{$email}'");
            }
            break;


        case 'recover' :
            $email = $_POST['email'] ?? '';
            $token = $_POST['token'] ?? '';
            $new_password = $_POST['new_password'] ?? '';

            $user = User::getUniqueByEmail($email);
            if($user->getId() > 0){
                $user->resetPassword($token, $new_password);
            }
            else{
                $_USER->addError("recover", "No account is registered with the email adress '{$email}'");
            }
            break;
    }
}
