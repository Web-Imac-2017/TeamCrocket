<?php
/**
* Gontroller des User
* @author METTER-ROTHAN Jérémie
*/

namespace App\Controller;

use App\Model\User;
use App\Model\Bucket\BucketFilter;

class UserController extends BucketAbstractController
{
    public function list($page = -1) : array{
        $filter = [];

        $data = User::getMultiple(array(
            'page' => (int)$page,
            'amount' => 10,
            'filter' => $filter,
            'order' => 'creation_date DESC'
        ));
        return $data;
    }

    public function edit(){
        $id = (isset($_POST['id'])) ? (int)$_POST['id'] : 0;

        $user = User::getUniqueById($id);
        $user->hydrate($_POST, true);
        $user->save();

        return $user;
    }

    public function delete(int $id){
        User::deleteById($id);
    }

    public function done(int $id, bool $done = true){
        $user = User::getUniqueById($id);
        $user->setDone($done);
        $user->save();
    }
}
