<?php
session_start();

define('DEBUG', true);

/**
* Init
*/

// paths
define('ROOT', '.');
define('ROOT_MODEL', ROOT.'/mvc/model');
define('ROOT_CONTROLLER', ROOT.'/mvc/controller');
define('ROOT_VIEW', ROOT.'/mvc/view');
define('ROOT_INC', ROOT.'/inc');
define('ROOT_UPLOADS', ROOT.'/uploads');

// langs
define('AVAILABLE_LANG', array('fr_FR', 'en_US'));

// files
define('PROFILE_PIC_EXTENSION', array('jpeg', 'jpg', 'png', 'gif'));
define('PROFILE_PIC_MAX_SIZE', 1048576 * 2); // 2mo
define('PROFILE_PIC_MAX_WIDTH', 400);
define('PROFILE_PIC_MAX_HEIGHT', 400);

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
    $path = ROOT_MODEL."/".str_replace('\\', '/', $class).".php";
    if(file_exists($path)){
        require $path;
    }
});

// fonctions globales
require_once ROOT_INC."/functions.php";
// gestion de la langue
require_once ROOT_INC."/lang.php";
// gestion de la session
require_once ROOT_INC."/connexion.php";



// vue
include(ROOT."/layout.php");
