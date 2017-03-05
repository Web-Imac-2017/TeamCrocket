<?php
if(!defined('ROOT')){
    define('ROOT', '../');
}
if(!defined('ROOT_INC')){
    define('ROOT_INC', ROOT.'inc/');
}

require_once(ROOT_INC . 'init.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Backend</title>
        <link rel="stylesheet/less" type="text/css" href="../less/style.less" />
        <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.7.2/less.min.js"></script>
    </head>
    <body>
        <header id="top" class="row">
            <div class="wrapper">
                <h1 class="col-12">Administration : </h1>
            </div>
        </header>
        <div class="wrapper">
            <div class="row">
                <div class="col-4">
                    <h4>Dirty profils</h4>
                    <form id="dirty-profil-form" method="post" action="api" data-ctrl="profile" data-task="#">
                        <div class="form-group">
                            <ul class="list" id="list-dirty-profil">
                                <?php
                                $dirtyList = App\Model\Animal::getDirtyList();

                                foreach($dirtyList as $dirty){
                                    echo '<li class="animal" data-id="'.$dirty->getId().'">
                                    <a href="?pid='.$dirty->getId().'" target="_blank">'.$dirty->getName().'</a>
                                    <a class="btn btn-success exec float-right" data-method="post" data-ctrl="profile" data-task="markdirty" data-args="'.$dirty->getId().'/1"><i class="fa fa-check" aria-hidden="true"></i></a>
                                    </li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <h4>Dirty profils pictures</h4>
                    <form id="dirty-profil-picture-form" method="post" action="api" data-ctrl="profile" data-task="#">
                        <div class="form-group">
                            <ul class="list" id="list-dirty-profil-pictures">
                                <?php
                                $dirtyListPictures = App\Model\Image::getDirtyList();

                                foreach($dirtyListPictures as $image){
                                    echo '<li class="animal-picture" data-id="'.$image->getId().'">

                                    <a href="'.$image->getPath().'" target="_blank">
                                        <div class="image-preview" style="background-image:url(\''.$image->getPath().'\')"></div>
                                    </a>

                                    <a class="btn btn-delete exec float-right" data-method="post" data-ctrl="image" data-task="markdirty" data-args="'.$image->getId().'/2"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    <a class="btn btn-success exec float-right" data-method="post" data-ctrl="image" data-task="markdirty" data-args="'.$image->getId().'/1"><i class="fa fa-check" aria-hidden="true"></i></a>
                                    </li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script src="../script/fontawesome.js"></script>
        <script>
        var callbacks = {
            profile : {
                markdirty : function(data){
                    console.log(data);
                    if(data.success){
                        var dirty = data.output.dirty;
                        var id = data.output.id;
                        if(dirty == 1) $('.animal[data-id='+id+']').remove();
                    }
                }
            },
            image : {
                markdirty : function(data){
                    console.log(data);
                    if(data.success){
                        var dirty = data.output.dirty;
                        var id = data.output.id;
                        if(dirty == 1 || dirty == 2) $('.animal-picture[data-id='+id+']').remove();
                    }
                }
            }
        };

        $(function(){
            $('body').on('click', '.exec', function(e){
                e.preventDefault();

                var $btn = $(this);
                var ctrl = $btn.attr('data-ctrl');
                var task = $btn.attr('data-task');
                var args = $btn.attr('data-args');
                var content = $btn.attr('data-content');
                var data = (content != '' && content != null) ? JSON.parse(content) : [];
                console.log(args, data);
                $.ajax({
                    method : 'post',
                    url : 'api/'+ctrl+'/'+task+'/'+args,
                    data : data,
                    cache : false,
                    processData : false,
                    contentType : false,
                    success : function(data){
                        var func = callbacks[ctrl][task];
                        if(typeof func === 'function'){
                            func(data);
                        }
                    }
                });
            });
        });
        </script>
    </body>
</html>
