<?php
/**
* Envoi une requête POST
* @param string $url
* @param array $data (key|value)
* @return mixed
*/
function curl_post(string $url, array $data = []){
    //open connection
    $ch = curl_init($url);

    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, count($data));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //execute post
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}


function crypto_rand_secure($min, $max){
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd >= $range);
    return $min + $rnd;
}

/**
* Génération d'une clé aléatoire
* @param int $length Nombre de caractère de la clé
* @return string $token
*/
function getToken(int $length){
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet) - 1;
    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max)];
    }
    return $token;
}


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
