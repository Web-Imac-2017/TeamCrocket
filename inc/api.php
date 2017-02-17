<?php
// API
$request = $_GET['request'] ?? '';

if(preg_match('#api\/(.*)\/(.*)(?:\/(.*)\/?)?$#iU', $request, $matches)){
    $route = null;
    $controller = null;
    $task = null;
    $args = [];

    array_shift($matches);
    @list($controller, $task, $args) = $matches;

    $success = false;
    $output = null;
    $message = '';

    try{
        $class = "\App\\Controller\\".ucfirst($controller) . 'Controller';

        if(!class_exists($class)){
            throw new Exception(sprintf(gettext("Invalid controller '%s'"), $controller));
        }
        if(!method_exists($class, $task)){
            throw new Exception(sprintf(gettext("Invalid task '%s'"), $task));
        }

        $temp = new $class();
        $output = $temp->$task(...explode('/', $args));
        $success = true;
    }
    catch(Exception $e){
        $message = $e->getMessage();
    }
    finally{
        header('Content-Type: application/json');
        $export = [];
        $export['success'] = $success;
        if($message != ''){
            $export['message'] = $message;
        }
        if($output != null){
            $export['output'] = $output;
        }

        echo json_encode($export);
    }

    die();
}
