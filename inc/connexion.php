<?php
/**
* Utilisateur
*/
if(isset($_GET['disconnect'])){
    unset($_SESSION['uid']);
    header("Location:index.php");
}
if(!isset($_SESSION['uid'])){
    $_SESSION['uid'] = 0;
}

// login
if(isset($_POST['login'])){
    $id = User::login($_POST['login']['email'], $_POST['login']['password']);

    if($id > 0){
        $_SESSION['uid'] = $id;
        header("Location:index.php");
    }
}

if(isset($_GET['token'], $_GET['email'])){
    $user = User::getUniqueByEmail($_GET['email']);
    if($user->getId() > 0){
        $user->verifyAccount($_GET['token']);
    }
}

// Compte de l'utilisateur courant
$GLOBALS['_USER'] = User::getUniqueById($_SESSION['uid']);
