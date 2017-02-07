<?php
/**
* Check if a string is a valid email
* @param string $email
* @return boolean
*/
function testMail(string $email) : bool{
    // returns true if mail adress in parameter is valid
    return (preg_match('#[\w\.]+@[\w\-]+\.[a-z]{2,4}#', $email, $match) == 1);
}

/**
* Check if a string is a valid username
* @param string $username
* @return boolean
*/
function testUsername(string $username) : bool{
    // return true if username is valid
    return (preg_match('#^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$#', $username, $match) == 1);
}

/**
* Check if a string is a valid password
* @param string $password
* @return boolean
*/
function testPassword(string $password) : bool{
    return (preg_match('#(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$#', $password, $match) == 1);
}


/**
* @param string $str
* @return boolean
*/
function is_sha1(string $str) : bool{
    return preg_match('/^[0-9a-f]{40}$/i', $str);
}


/**
* Test if all arguments are not empty
* @return bool
*/
function mempty(...$args) : bool{
    for($k = 0, $n = count($args); $k < $n; $k++){
        if(empty($args[$k])){
            return false;
        }
    }

    return true;
}
