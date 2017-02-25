<?php
/**
* Image
* @author METTER-ROTHAN Jérémie
*/

namespace App\Model;

use Imagine\Image\Point;
use Imagine\Image\Box;
use Imagine\Gd\Imagine;

/*
@table image
@field name, string
@field creator_id, int
*/

class Image extends Bucket\BucketAbstract
{
    private $name;
    private $creator_id;

    function __construct($data = NULL){
        $this->name = '';
        $this->creator_id = 0;

        parent::__construct($data);
    }

    /**
    * Enregistre sur le serveur une image et créé une entrée dans la base de donnée
    * @param array $file
    * @param array $options
    * @return Image
    */
    public static function upload(array $file, $options = []){
        $options['extensions'] = $options['extensions'] ?? [];
        $options['max_size'] = $options['max_size'] ?? [];

        $image = NULL;

        if(is_uploaded_file($file['tmp_name'])){
            $image = new Image();

            $filename = md5(uniqid(rand(), true));
            $extension = @explode('/', $file['type'])[1];

            if($file['error'] > 0){
                throw new \Exception(gettext("Error") . " " . $file['error']);
            }
            if(!in_array($extension, $options['extensions'])){
                throw new \Exception(sprintf(gettext("Invalid image extension for %s (only %s)"), $extension, implode($options['extensions'], ", ")));
            }
            if($file['size'] > $options['max_size']){
                throw new \Exception(gettext("File is too large"));
            }

            $image->setName($filename . '.' . $extension);
            $image->setCreatorId($_SESSION['uid']);

            $path = $image->getPath();

            if(!is_dir($path) || !move_uploaded_file($file['tmp_name'], $path)){
                throw new \Exception(gettext("Could not move image"));
            }

            $image->save();
        }

        return $image;
    }

    /**
    * Formate une image en photo de profil (Limite de taille et recadrage)
    * /!\ Écrase l'ancienne image
    * @param int $maxWidth
    * @param int $maxHeight
    */
    public function toProfilePic(int $maxWidth, int $maxHeight){
        $path = $this->getPath();
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $imagine = new Imagine();
        $image = $imagine->open($path);
        list($width, $height) = getimagesize($path);

        $cropSize = ($width > $height) ? $height : $width;
        $cropPosX = $width / 2 - $cropSize / 2;
        $cropPosY = $height / 2 - $cropSize / 2;

        // on créé un beau carré
        $image->crop(new Point($cropPosX, $cropPosY), new Box($cropSize, $cropSize));
        // on redimensionne selon les tailles max
        $image->resize(new Box($maxWidth, $maxHeight));

        // options
        $options = [];
        if($extension == 'jpeg' || $extension == 'jpg'){
            $options['jpeg_quality'] = 70;
        }
        else if($extension == 'png'){
            $options['png_compression_level'] = 9;
        }

        $image->save($path, $options);
    }

    public function jsonSerialize(){
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'creator_id' => $this->creator_id,
            'path' => $this->getPath(),
            'creation_date' => $this->creation_date
        );
    }

    protected function beforeInsert(){}

    protected function beforeUpdate(){}

    protected function afterInsert(){}

    protected function afterUpdate(){}


    public function setName(string $name){
        $this->name = $name;
    }
    public function setCreatorId(int $id){
        $this->creator_id = $id;
    }

    public function getName() : string{
        return $this->name;
    }
    public function getCreatorId() : int{
        return $this->creator_id;
    }
    public function getCreator() : User{
        return User::getUniqueById($this->creator_id);
    }

    public function getPath() : string{
        $dir = ROOT_UPLOADS . "users/" . $this->creator_id . "/";
        if($this->creator_id > 0 && !is_dir($dir)){
            mkdir($dir, 0777, true);
        }

        return $dir . $this->name;
    }
}
