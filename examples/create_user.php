<?php
// création d'un utilisateur
$user = new User(array(
    'nickname' => 'metterrothan',
    'firstname' => 'Jérémie',
    'lastname' => 'METTER-ROTHAN',
    'sex' => User::SEX_MALE,
    'date_birth' => '1993-05-09',
    'password' => '1234abCDE@',
    'email' => 'jmetterrothan@gmail.com'
));

try{
    $user->save();
    echo "L'utilisateur {$user->getId()} a été ajouté !\n";
}
catch(BucketSaveException $e){
    // la sauvegarde a echoué
    $user->showErrors();
}
