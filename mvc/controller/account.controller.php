<?php
/**
* Exemple sans angularJS
*/

$user = $_USER;


// modification / création utilisateur
if(isset($_POST['user'])){
    $user->hydrate($_POST['user'], true);
    try{
        $user->save();
        $_SESSION['uid'] = $user->getId();
        header("Location:index.php");
    }
    catch(Bucket\BucketSaveException $e){
        // la sauvegarde a echoué
        echo '<pre>';
        $user->showErrors();
        echo '</pre>';
    }
}
