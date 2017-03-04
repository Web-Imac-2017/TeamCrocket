<?php
define('ROOT', './');
define('ROOT_INC', ROOT.'inc/');

require(ROOT_INC . 'init.php');

// API
$request = $_GET['request'] ?? '';
$export = array();

preg_match('#(.*)\/(.*)(?:\/(.*)\/?)?$#iU', $request, $matches);
$route = NULL;
$controller = NULL;
$task = NULL;
$args = [];

array_shift($matches);
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
