<?php
/**
* Parse une classe pour récupérer la structure de la table correspondante dans la base de donnée
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model\Bucket;

class BucketParser
{
    private static $list = [];

    public static function parse(string $class){
        if(isset(self::$list[$class]) && self::$list[$class] instanceof BucketClass){
            // empêche de parser la même classe 2 fois
            return self::$list[$class];
        }

        $filename = $class . ".php";
        $path = ROOT. str_replace('\\', '/', $filename);

        if(!file_exists($path)){
            throw new BucketException(sprintf(gettext("Could not find class '%s'"), $filename));
        }

        $handle = fopen($path, 'r');
        if($handle){
            $table = "";
            $group = "";
            $map = [];

            // on parcourt chaque ligne du fichier
            while(($line = fgets($handle)) !== false){
                // on vérifie si la ligne doit être interprêtée par le parser
                if($line[0] != '@'){
                    continue;
                }

                $line = substr(trim($line), 1);
                $pos = strpos($line, ' '); // position du séparateur (espace)
                $type = trim(substr($line, 0, $pos)); // type de donnée (table, field)
                $value = trim(substr($line, $pos));

                switch($type){
                    case 'table' :
                        $table = $value;
                        break;

                    case 'group' :
                        $group = $value;
                        break;

                    case 'field' :
                        $temp = array_map('trim', explode(',', $value));

                        //Ordre des valeurs : <name>, <type>
                        $name = $temp[0];
                        $access_level = (isset($temp[2])) ? (int)$temp[2] : BucketField::ACCESS_LEVEL_USER;

                        switch($temp[1]){
                            case "int" :
                                $type = \PDO::PARAM_INT;
                                break;

                            case "string" :
                            case "float" :
                            case "date" :
                                $type = \PDO::PARAM_STR;
                                break;

                            default :
                                $type = \PDO::PARAM_NULL;
                        }

                        $map[] = new BucketField($name, $type, $access_level);
                        break;
                }
            }

            self::$list[$class] = new BucketClass($table, $group, $map);
            fclose($handle);

            return self::$list[$class];
        }
    }
}
