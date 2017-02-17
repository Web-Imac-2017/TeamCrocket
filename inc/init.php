<?php
session_start();

define('ROOT_APP', ROOT.'App/');
define('ROOT_MODEL', ROOT_APP.'Model/');
define('ROOT_CONTROLLER', ROOT_APP.'Controller/');

// On charge le fichier de configuration
$config = parse_ini_file(ROOT.'/config/config.ini', true);
define('DATABASE_CFG', $config['database']);
define('GLOBAL_CFG', $config['global']);

if(GLOBAL_CFG['debug']){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

spl_autoload_register(function($class){
    $path = ROOT . str_replace('\\', '/', $class).".php";
    if(file_exists($path)){
        require $path;
    }
});

require ROOT_INC."PHPMailer/PHPMailerAutoload.php";
require ROOT_INC."Imagine/ImagineAutoload.php";

if(!isset($_SESSION['uid'])){
    $_SESSION['uid'] = 0;
}
if(!isset($_SESSION['language'])){
    $_SESSION['language'] = 'en_US';
}


if(!defined('LC_MESSAGES')){
    define('LC_MESSAGES', 6); // fix PHP Amel
}

// nom du dossier (ici le même que la langue)
$domain = $_SESSION['language'];

putenv('LANG='.$_SESSION['language']);
setlocale(LC_MESSAGES, $_SESSION['language']);
bindtextdomain($domain, './locale');
bind_textdomain_codeset($domain, 'UTF-8');
textdomain($domain);
