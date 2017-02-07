<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(1);

// paths
define('ROOT_CLASS', './class');


// database
define('DB_HOST', 'localhost');
define('DB_NAME', 'teamcrocket');
define('DB_PREFIX', 'ajkl7_');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

// autoloader
spl_autoload_register(function($class){
    $path = ROOT_CLASS."/".$class.".class.php";
    if(file_exists($path)){
        require $path;
    }
});


require("./inc/functions.php");
include("test.php");
