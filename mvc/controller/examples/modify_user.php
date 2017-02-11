<?php
// modifie l'utilisateur avec l'ID
// récupère une instance de l'utilisateur
$user = User::getUniqueById(93);

try{
    // on modifie les champs ci-dessous
    $user->hydrate(array(
        'nickname' => 'test',
        'sex' => User::SEX_FEMALE,
        'date_birth' => '1993-05-12',
        'email' => 'test@gmail.com'
    ));
    $user->save();
    echo "L'utilisateur {$user->getId()} a été modifié !\n";
}
catch(Bucket\BucketSaveException $e){
    $user->showErrors();
}
