<?php
// créé l'utilisateur Mario
$data = array(
    'nickname' => 'Mario',
    'email' => 'mario@gmail.com'
);
$user = new User($data);
$user->save();


// modifie l'utilisateur avec l'ID 1
$user = User::getUniqueById(1);
$data = array(
    'nickname' => 'TROUDUC'
);
$user->hydrate($data);
$user->save();


// récupère une instance de l'utilisateur 1
$user = User::getUniqueById(1);
var_dump($user);


// récupère la liste de tous les utilisateurs
$userlist = User::getMultiple();
var_dump($userlist);


// supprime l'utilisateur avec l'ID 2
User::deleteById(2);
