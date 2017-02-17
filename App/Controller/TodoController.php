<?php
/**
* Gontroller des Todo
* @author METTER-ROTHAN Jérémie
*/

namespace App\Controller;

use App\Model\Todo;
use App\Model\Bucket\BucketFilter;

class TodoController extends BucketAbstractController
{
    public function list($page = -1) : array{
        $filter = [];

        $filter[] = new BucketFilter('creator_id', $_SESSION['uid'], \PDO::PARAM_INT);
        if(isset($_POST['name']) && $_POST['name'] != ''){
            $filter[] = new BucketFilter('name', $_POST['name'], \PDO::PARAM_STR, function($string){ return $string . "%";});
        }

        $data = Todo::getMultiple(array(
            'page' => (int)$page,
            'amount' => 10,
            'filter' => $filter,
            'order' => 'creation_date DESC'
        ));
        return $data;
    }

    public function edit(){
        $id = (isset($_POST['id'])) ? (int)$_POST['id'] : 0;

        $todo = Todo::getUniqueById($id);
        $todo->hydrate($_POST, true);
        $todo->save();

        return $todo;
    }

    public function delete(int $id){
        Todo::deleteById($id);
    }

    public function done(int $id, bool $done = true){
        $todo = Todo::getUniqueById($id);
        $todo->setDone($done);
        $todo->save();
    }
}
