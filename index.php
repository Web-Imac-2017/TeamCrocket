<?php
if(!defined('ROOT')){
    define('ROOT', './');
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
        <link rel="stylesheet/less" type="text/css" href="./less/style.less" />
        <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.7.2/less.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script src="./script/fontawesome.js"></script>
    </head>
    <body>
        <header id="top" class="row">
            <div class="wrapper">
                <h1 class="col-12">Debug tool : </h1>
            </div>
        </header>
        <div class="wrapper">
            <?php
                $page = $_GET['page'] ?? '';
                if($page == 'match') include ROOT . 'match.php';
                else include ROOT . 'user.php';
            ?>
        </div>
        <div class="user-info">
            <?php if($_USER->getId()): ?>
            <form id="disconnect-form" method="post" action="api" data-ctrl="user" data-task="logout">
                <div class="form-group clearfix"><input type="submit" class="btn btn-red float-right" value="Logout"></div>
            </form>
            <?php endif; ?>
        </div>
        <script>
        $('input[name=maxdistance]').on('input change', function(e){
            $('#maxdistance-value').html($(this).val() + ' km');
        });

        var $profile_pic;

        // fonctions de callback pour les requêtes Ajax appelée automatiquement
        var callbacks = callbacks || {};

        // callbacks pour le controlleur de la classe User
        callbacks.user = {
            // tâche "login"
            login : function(data){
                if(!data.success){
                    return;
                }
                setTimeout(function(){
                    location.reload();
                }, 200);
            },
            logout : function(data){
                if(!data.success){
                    return;
                }
                location.reload();
            },
            list : function(data){
                var list = data.output || [];
                var $list = $('#owner_list');
                $list.html('');
                $.each(list.data, function(i, item){
                    var pic = (item.image != null) ? 'background-image:url('+item.image.thumb_path+')' : '';
                    $list.append('<div class="owner" data-id="'+item.id+'">\
                        <div class="owner-pic" style="'+pic+'"></div>\
                        <div class="owner-details">\
                            <h5 class="owner-name">'+item.nickname+'</h5>\
                            <span class="details-like"><b>Habite :</b> '+item.city+'</span>\
                            <span class="details-cdate">'+item.creation_date+'</span>\
                        </div>\
                    </div>');
                });
            }
        };

        callbacks.profile = {
            upload : function(data){
                $("#profile-animal-form2 .list").append('<li data-id="'+data.output.id+'">\
                    <a target="_blank" href="'+data.output.thumb_path+'">'+data.output.name+'</a>\
                    <a class="btn btn-delete exec float-right" data-method="post" data-ctrl="profile" data-task="delete_image" data-args="'+data.output.id+'"><i class="fa fa-trash" aria-hidden="true"></i></a>\
                </li>')
            },
            delete_image : function(data){
                if(data.success){
                    $('#list-animal-gallery li[data-id='+data.output+']').remove();
                }
            },
            delete : function(data){
                if(data.success){
                    $('#list-animal li[data-id='+data.output+']').remove();
                }
            },
            list : function(data){
                var list = data.output || [];
                var $list = $('#animal_list');
                $list.html('');
                $.each(list.data, function(i, item){
                    var icon = (item.sex == 'm') ? "fa-mars" : "fa-venus";
                    var pic = (item.profile_image != null) ? 'background-image:url('+item.profile_image.thumb_path+')' : '';
                    $list.append('<div class="animal" data-id="'+item.id+'">\
                        <div class="animal-pic" style="'+pic+'"></div>\
                        <div class="animal-details">\
                            <h5 class="animal-name">'+item.name + '<span class="details-species"> <i class="fa ' + icon + '"></i> ' + item.species.name +', '+ item.age +' ans</span></h5>\
                            <span class="details-like"><b>Aime :</b> '+item.like+'</span>\
                            <span class="details-like"><b>Habite :</b> '+item.city+'</span>\
                            <span class="details-cdate">'+item.creation_date+'</span>\
                        </div>\
                    </div>');
                });
            }
        }

        callbacks.comment = {
            edit : function(data){
                $('#profile-animal-form3').find('*[name="content"]').val('');
                $('#comments').prepend('<div class="comment" data-id="'+data.output.id+'">\
                    <img alt="" src="'+data.output.creator.image.thumb_path+'">\
                    <div class="comment-inner">\
                        <h5>'+data.output.creator.nickname+'</h5>\
                        <p>'+data.output.content+'</p>\
                        <ul class="comment-options">\
                            <li><a class="btn btn-delete exec" data-method="post" data-ctrl="comment" data-task="delete" data-args="'+data.output.id+'"><i class="fa fa-trash" aria-hidden="true"></i></a></li>\
                        </ul>\
                        <div class="comment-date">'+data.output.creation_date+'</div>\
                    </div>\
                </div>');
            },
            delete : function(data){
                if(data.success){
                    $('.comment[data-id='+data.output+']').remove();
                }
            }
        };

        $(function(){
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(function(position){
                    $('#profile-form').find('*[name=latitude]').val(position.coords.latitude);
                    $('#profile-form').find('*[name=longitude]').val(position.coords.longitude);

                    $('#sub-form').find('*[name=latitude]').val(position.coords.latitude);
                    $('#sub-form').find('*[name=longitude]').val(position.coords.longitude);
                });
            }

            /**
            * Changement de photo de profil
            */
            $profile_pic = $('#profile_image');

            $('#image_file').on('change input', function(e){
                var file = $(this)[0].files[0];
                if(file == null){
                    $profile_pic.css('background-image', 'url('+$profile_pic.attr('data-default-url')+')');
                    return false;
                }

                var reader = new FileReader();
                reader.onload = function(e){
                    $profile_pic.css('background-image', 'url('+e.target.result)+')';
                }
                reader.readAsDataURL(file);
            });

            $('.custom-file-input input[type=file]').on('change input', function(e){
                var $parent = $(this).parent();
                var $label = $parent.find('label');
                var filename = ($(this)[0].files[0] != null) ? $(this)[0].files[0].name : $label.attr('data-text');

                $label.text(filename);
            });

            $(window).on('load resize', function(){
                $profile_pic.css('height', ($profile_pic.width())+'px');
            });

            /**
            * Gestion des formulaires en AJAX
            */
            $('form').on('submit', function(e){
                e.preventDefault();

                var $form = $(this);
                var ctrl = $form.attr('data-ctrl');
                var task = $form.attr('data-task');
                var action = $form.attr('action');
                var data = new FormData($form[0]);

                $form.prop('disabled', true);

                $.ajax({
                    method : $form.attr('method'),
                    url : action+'/'+ctrl+'/'+task,
                    data : data,
                    cache : false,
                    processData : false,
                    contentType : false,
                    success : function(data){
                        $form.prop('disabled', false);

                        $form.find('.message').css('display', 'none');
                        if(data.success){
                            $form.find('.success-message').fadeIn(200);
                        }
                        else{
                            $form.find('.error-message').html(data.message).fadeIn(200);
                        }

                        var func = callbacks[ctrl][task];
                        if(typeof func === 'function'){
                            func(data);
                        }
                    }
                });
            });

            $('body').on('click', '.exec', exec);

            function exec(e){
                e.preventDefault();

                var $btn = $(this);
                var ctrl = $btn.attr('data-ctrl');
                var task = $btn.attr('data-task');

                var args = $btn.attr('data-args');
                var content = $btn.attr('data-content');
                var data = (content != '' && content != null) ? JSON.parse(content) : [];

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
            }
        });
        </script>
    </body>
</html>
