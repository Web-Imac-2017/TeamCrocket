<?php
namespace App\Model;

class LogConnexion
{
    public static function register(User $user){
        DB::exec("
            INSERT INTO ".DATABASE_CFG['prefix']."user_log_connexion (user_id, ip_adress, user_agent)
            VALUES (:user_id, :ip_adress, :user_agent)
        ", array(
            [":user_id", $user->getId(), \PDO::PARAM_INT],
            [":ip_adress", $_SERVER['REMOTE_ADDR'], \PDO::PARAM_STR],
            [":user_agent", $_SERVER['HTTP_USER_AGENT'], \PDO::PARAM_STR]
        ));
    }
}
