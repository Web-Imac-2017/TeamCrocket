<?php
/**
* Gontroller des Todo
* @author METTER-ROTHAN Jérémie
*/

namespace App\Controller;

use App\Model\Todo;

class TodoController extends BucketAbstractController
{
    public function list() : array{
        return Todo::filter($_POST);
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
