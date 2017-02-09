<?php
session_start();

define('DEBUG', true);

/**
* Init
*/

// paths
define('ROOT_CLASS', './class');
define('ROOT_INC', './inc');

// langs
define('AVAILABLE_LANG', array('fr_FR', 'en_US'));

// vérifications
define('REGEX_PASSWORD', '#(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$#');
define('REGEX_NICKNAME', '#^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$#');
define('REGEX_EMAIL', '#[\w\.]+@[\w\-]+\.[a-z]{2,4}#');

// database
define('DB_HOST', 'localhost');
define('DB_NAME', 'teamcrocket');
define('DB_PREFIX', 'ajkl7_');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');



if(DEBUG){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}


/*
* Autoloader
*/
spl_autoload_register(function($class){
    $path = ROOT_CLASS."/".str_replace('\\', '/', $class).".class.php";
    if(file_exists($path)){
        require $path;
    }
});

require_once ROOT_INC."/lang.php";


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

// Compte de l'utilisateur courant
$GLOBALS['_USER'] = User::getUniqueById($_SESSION['uid']);



require_once ROOT_INC."/functions.php";

include("test.php");
