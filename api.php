<?php
if(!defined('ROOT')){
    define('ROOT', './');
}
if(!defined('ROOT_INC')){
    define('ROOT_INC', ROOT.'inc/');
}

require_once(ROOT_INC . 'init.php');

// API
$request = $_GET['request'] ?? '';

$request != NULL && preg_match('#api\/(.*)\/(.*)(?:\/(.*)\/?)?$#iU', $request, $matches);
$export = array();

$route = NULL;
$controller = NULL;
$task = NULL;
$args = [];

@array_shift($matches);
@list($controller, $task, $args) = $matches;

try{
    $class = "\App\\Controller\\".ucfirst($controller) . 'Controller';

    if(!class_exists($class)){
        throw new Exception(sprintf(gettext("Invalid controller '%s'"), $controller));
    }
    if(!method_exists($class, $task)){
        throw new Exception(sprintf(gettext("Invalid task '%s'"), $task));
    }

    $temp = new $class();

    $export['output'] = $temp->$task(...explode('/', $args));
    $export['success'] = true;
}
catch(Exception $e){
    $export['message'] = $e->getMessage();
    $export['success'] = false;
}

header('Content-Type: application/json');
echo json_encode($export);
die();
