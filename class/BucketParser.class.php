<?php
class BucketParser
{
    private static $list = [];

    public static function parse(string $class){
        if(self::$list[$class] instanceof BucketClass){
            // empêche de parser la même classe 2 fois
            return self::$list[$class];
        }

        $filename = $class . ".class.php";
        $path = ROOT_CLASS."/". $filename;
        if(!file_exists($path)){
            throw new Exception("Could not class '".$filename."'");
        }

        $handle = fopen($path, 'r');
        if($handle){
            $table = "";
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

                    case 'field' :
                        $temp = array_map('trim', explode(',', $value));
                        //Ordre des valeurs : <name>, <type>
                        $name = $temp[0];

                        switch($temp[1]){
                            case "int" :
                                $type = PDO::PARAM_INT;
                                break;

                            case "string" :
                            case "float" :
                            case "date" :
                                $type = PDO::PARAM_STR;
                                break;

                            default :
                                $type = PDO::PARAM_NULL;
                        }

                        $map[] = array(
                            'name' => $name,
                            'type' => $type
                        );
                        break;
                }
            }

            self::$list[$class] = new BucketClass($table, $map);
            fclose($handle);

            return self::$list[$class];
        }
    }
}
