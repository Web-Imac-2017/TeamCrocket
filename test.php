<?php
echo '<pre>';

// création d'un utilisateur
$user = new User(array(
    'nickname' => 'dudule',
    'sex' => User::SEX_MALE,
    'date_birth' => '1993-05-09',
    'email' => 'mario222@gmail.com'
));


try{
    $user->save();
    echo "L'utilisateur {$user->getId()} a été ajouté !\n";
}
catch(BucketSaveException $e){
    // la sauvegarde a echoué
    $user->showErrors();
}


// supprime un utilisateur avec l'ID 1
// User::deleteById(1);


// modifie l'utilisateur avec l'ID 80
// récupère une instance de l'utilisateur 1
$user = User::getUniqueById(80);

try{
    $user->hydrate(array(
        'nickname' => 'test',
        'sex' => User::SEX_FEMALE,
        'date_birth' => '1993-05-12',
        'email' => 'test@gmail.com'
    ));
    $user->save();
    echo "L'utilisateur {$user->getId()} a été modifié !\n";
}
catch(BucketSaveException $e){
    $user->showErrors();
}



// récupère la liste de tous les utilisateurs
$userlist = User::getMultiple();
var_dump($userlist);


echo '</pre>';
