<?php
/**
* Vérifie si l'adresse email en paramètre correspond à la REGEX
* @param string $email
* @return boolean
*/
function testMail(string $email) : bool{
    // returns true if mail adress in parameter is valid
    return (preg_match(REGEX_EMAIL, $email, $match) == 1);
}

/**
* Vérifie si le nom d'utilisateur en paramètre correspond à la REGEX
* @param string $username
* @return boolean
*/
function testUsername(string $username) : bool{
    // return true if username is valid
    return (preg_match(REGEX_NICKNAME, $username, $match) == 1);
}

/**
* Vérifie si le mot de passe en paramètre correspond à la REGEX
* @param string $password
* @return boolean
*/
function testPassword(string $password) : bool{
    return (preg_match(REGEX_PASSWORD, $password, $match) == 1);
}


/**
* Vérifie si le string est une empreinte sha1
* @param string $str
* @return boolean
*/
function is_sha1(string $str) : bool{
    return preg_match('/^[0-9a-f]{40}$/i', $str);
}


/**
* Détermine si la liste d'argument n'est pas empty
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
