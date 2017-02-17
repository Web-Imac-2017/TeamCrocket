<?php
/**
 * Imagine autoloader
 * @param string $classname The name of the class to load
 */
function ImagineAutoload($classname){
    $filename = ROOT_INC.strtolower(str_replace('\\', '/', $classname)).'.php';
    if(is_readable($filename)) {
        require $filename;
    }
}

spl_autoload_register('ImagineAutoload', false, true);
