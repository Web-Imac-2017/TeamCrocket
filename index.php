<?php
define('ROOT', './'); //dirname(realpath(__FILE__)).
define('ROOT_INC', ROOT.'inc/');

require(ROOT_INC . 'init.php');
require(ROOT_INC . 'api.php');

#$animal = App\Model\Animal::getUniqueById($_GET['pid'] ?? 0);
#var_dump($animal->getImageList());
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Backend</title>
        <link rel="stylesheet/less" type="text/css" href="./less/style.less" />
        <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.7.2/less.min.js"></script>
    </head>
    <body>
        <header id="top" class="row">
            <div class="wrapper">
                <h1 class="col-12">Debug tool : </h1>
            </div>
        </header>
        <div class="wrapper">
            <div class="row">
                <div class="col-4">
                    <?php if($_USER->getId() == 0): ?>
                    <form id="login-form" method="post" action="api" data-ctrl="user" data-task="login">
                        <h4>Sign in</h4>
                        <div class="form-body">
                            <div class="form-group"><input type="email" class="form-element" name="email" placeholder="Email" required value="<?php if(isset($_GET['email'])) echo $_GET['email']; ?>"></div>
                            <div class="form-group"><input type="password" class="form-element" name="password" placeholder="Password" required></div>
                            <?php if(isset($_GET['token'])): ?>
                            <div class="form-group"><input type="text" name="token" readonly value="<?php echo $_GET['token']; ?>" required></div>
                            <?php endif; ?>
                            <div class="message success-message">Connected</div>
                            <div class="message error-message"></div>
                            <div class="form-group clearfix"><input type="submit" class="btn float-right" value="Sign in"></div>
                        </div>
                    </form>
                    <form id="fp-form" method="post" action="api" data-ctrl="user" data-task="forgottenpassword" class="mt-3">
                        <h4>Forgotten password ?</h4>
                        <div class="form-body">
                            <div class="form-group"><input type="email" class="form-element" name="email" placeholder="Email" required></div>
                            <div class="message success-message">Mail sent</div>
                            <div class="message error-message"></div>
                            <div class="form-group clearfix"><input type="submit" class="btn float-right" value="Validate"></div>
                        </div>
                    </form>
                    <form id="fp-form" method="post" action="api" data-ctrl="user" data-task="reset" class="mt-3">
                        <h4>Reset password</h4>
                        <div class="form-body">
                            <input type="hidden" name="token" value="<?php echo $_GET['token'] ?? ''; ?>">
                            <input type="hidden" name="email" value="<?php echo $_GET['email'] ?? ''; ?>">
                            <div class="form-group"><input type="password" class="form-element" name="password1" placeholder="New password" required pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Min 8 caractères, obligatoirement composé d'au minimum 1 lettre minuscule/majuscule, un chiffre et un caractère spécial"></div>
                            <div class="form-group"><input type="password" class="form-element" name="password2" placeholder="Confirm password" required pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Min 8 caractères, obligatoirement composé d'au minimum 1 lettre minuscule/majuscule, un chiffre et un caractère spécial"></div>
                            <div class="message success-message">Password changed</div>
                            <div class="message error-message"></div>
                            <div class="form-group clearfix"><input type="submit" class="btn float-right" value="Validate"></div>
                        </div>
                    </form>
                    <form id="login-form" method="post" action="api" data-ctrl="user" data-task="edit" class="mt-3">
                        <h4>Subscribe</h4>
                        <div class="form-body">
                            <input type="hidden" name="id" value="0">
                            <div class="form-group"><input type="email" class="form-element" name="email" placeholder="Email" required></div>
                            <div class="form-group"><input type="text" class="form-element" name="nickname" placeholder="Nickname" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés"></div>
                            <div class="form-group"><input type="password" class="form-element" name="password" placeholder="Password" required pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Min 8 caractères, obligatoirement composé d'au minimum 1 lettre minuscule/majuscule, un chiffre et un caractère spécial"></div>
                            <div class="form-group"><input type="date" class="form-element" name="date_birth" placeholder="Birth date" required></div>
                            <div class="form-group"><input type="file" class="form-element" name="image_file" accept="image/.png,.jpg,.jpeg,.gif"></div>
                            <div class="g-recaptcha form-group" data-sitekey="6LcIPBUUAAAAAL7aFlWT0BNXe6nNKbRUTvQNrhXg"></div>
                            <div class="message success-message">Subscribed, check your mails to verify your email adress</div>
                            <div class="message error-message"></div>
                            <div class="form-group clearfix"><input type="submit" class="btn float-right" value="Sign up"></div>
                        </div>
                    </form>
                    <?php else: ?>
                    <form id="profile-form" method="post" action="api" data-ctrl="user" data-task="edit">
                        <h4>General information</h4>
                        <div class="form-body">
                            <div id="profile_image" style="background-image:url(<?php echo $_USER->getImage()->getPath(); ?>);"></div>
                            <div class="form-group">
                                <input id="image_file" type="file" class="form-element" name="image_file" accept="image/.png,.jpg,.jpeg,.gif">
                                <label for="image_file">Change profile picture ...</label>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $_USER->getId(); ?>">
                            <div class="form-group"><input type="email" class="form-element" name="email" placeholder="Email" required value="<?php echo $_USER->getEmail(); ?>"></div>
                            <div class="form-group"><input type="text" class="form-element" name="nickname" placeholder="Nickname" required value="<?php echo $_USER->getNickname(); ?>" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés"></div>
                            <div class="form-group"><input type="date" class="form-element" name="date_birth" placeholder="Birth date" required value="<?php echo $_USER->getDateBirth(); ?>"></div>
                            <div class="form-group row nopadding clearfix">
                                <div class="col-6">
                                    <input id="sex-h" class="form-element" type="radio" name="sex" value="h" <?php if($_USER->getSex() != 'f') echo 'checked'; ?>>
                                    <label for="sex-h">Homme</label>
                                </div>
                                <div class="col-6">
                                    <input id="sex-f" class="form-element" type="radio" name="sex" value="f" <?php if($_USER->getSex() == 'f') echo 'checked'; ?>>
                                    <label for="sex-f">Femme</label>
                                </div>
                            </div>
                            <div class="form-group"><input type="text" class="form-element" name="city" placeholder="City" required value="<?php echo $_USER->getCity(); ?>"></div>
                            <div class="form-group">
                                <select name="country_id" class="form-element">
                                    <?php
                                    $countries = App\Model\Country::getMultiple();
                                    foreach($countries as $country){
                                        $selected = ($country->getId() == $_USER->getCountryId()) ? 'selected' : '';
                                        echo "<option {$selected} value=\"{$country->getId()}\">{$country->getNicename()}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group"><textarea class="form-element" name="description" rows="5" placeholder="Description"><?php echo $_USER->getDescription(); ?></textarea></div>
                        </div>
                        <h4 class="mt-2">Security</h4>
                        <div class="form-body">
                            <div class="form-group"><input type="password" class="form-element" name="old_password" placeholder="Old password" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Min 8 caractères, obligatoirement composé d'au minimum 1 lettre minuscule/majuscule, un chiffre et un caractère spécial"></div>
                            <div class="form-group"><input type="password" class="form-element" name="new_password" placeholder="New password" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Min 8 caractères, obligatoirement composé d'au minimum 1 lettre minuscule/majuscule, un chiffre et un caractère spécial"></div>
                            <div class="form-group"><input type="password" class="form-element" name="confirm_password" placeholder="Confirm password" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Min 8 caractères, obligatoirement composé d'au minimum 1 lettre minuscule/majuscule, un chiffre et un caractère spécial"></div>
                        </div>
                        <footer>
                            <div class="message success-message">Changes have been saved</div>
                            <div class="message error-message"></div>
                            <div class="form-group clearfix"><input type="submit" class="btn float-right" value="Save"></div>
                        </footer>
                    </form>
                    <?php endif; ?>
                </div>
                <div class="col-4">
                    <?php if($_USER->getId() > 0):

                    $animal = App\Model\Animal::getUniqueById($_GET['pid'] ?? 0);
                    ?>

                    <form id="profile-animal-form" method="post" action="api" data-ctrl="profile" data-task="edit">
                        <h4>Profil animal</h4>
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?php echo $animal->getId(); ?>">
                            <div class="form-group">
                                <input type="file" class="form-element" name="image_file" accept="image/.png,.jpg,.jpeg,.gif">
                            </div>
                            <div class="form-group">
                                <ul>
                                <?php
                                $images = $animal->getImageList();
                                foreach($images as $image){
                                    echo '<li value="'.$image->getId().'">
                                    <a target="_blank" href="'.$image->getPath().'">'.$image->getName().'</a>
                                    <a class="float-right" href="api/profile/delete_image/'.$image->getId().'"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </li>';
                                }
                                ?>
                                </ul>
                            </div>
                            <div class="form-group"><input type="text" class="form-element" name="name" placeholder="Name" required value="<?php echo $animal->getName(); ?>"></div>
                            <div class="form-group"><input type="date" class="form-element" name="date_birth" placeholder="Birth date" required value="<?php echo $_USER->getDateBirth(); ?>"></div>
                            <div class="form-group"><textarea class="form-element" name="description" rows="5" placeholder="Description"><?php echo $animal->getDescription(); ?></textarea></div>
                        </div>

                        <footer>
                            <div class="message success-message">Changes have been saved</div>
                            <div class="message error-message"></div>
                            <div class="form-group clearfix"><input type="submit" class="btn float-right" value="Save"></div>
                        </footer>
                    </form>
                    <?php endif;?>
                </div>
                <div class="col-8">
                    <?php if($_USER->getId()): ?>
                    <h4>Position</h4>
                    <div id="map" style="height:400px;"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="user-info">
            <?php if($_USER->getId()): ?>
            <form id="disconnect-form" method="post" action="api" data-ctrl="user" data-task="disconnect">
                <div class="form-group clearfix"><input type="submit" class="btn btn-red float-right" value="Disconnect"></div>
            </form>
            <?php endif; ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script src="./script/fontawesome.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjXk_CjR3VFOABhIhnZwu6K21V7m_gJw0&callback=initMap"></script>
        <script>
        function initMap() {
        var position = { lat : <?php echo $_USER->getLatitude(); ?>, lng : <?php echo $_USER->getLongitude(); ?> };
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: position,
          scrollwheel: false
        });
        var marker = new google.maps.Marker({
          position: position,
          map: map
        });
      }

        var $profile_pic;

        // fonctions de callback pour les requêtes Ajax appelée automatiquement
        var callbacks = {};
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
            disconnect : function(data){
                if(!data.success){
                    return;
                }
                location.reload();
            }
        };

        $(function(){
            /**
            * Changement de photo de profil
            */
            $profile_pic = $('#profile_image');

            $('#image_file').on('change input', function(e){
                var file = $(this)[0].files[0];
                if(file == null){
                    return false;
                }

                var reader = new FileReader();
                reader.onload = function(e){
                    $profile_pic.css('background-image', 'url('+e.target.result)+')';
                }
                reader.readAsDataURL(file);
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

                $.ajax({
                    method : $form.attr('method'),
                    url : action+'/'+ctrl+'/'+task,
                    data : data,
                    cache : false,
                    processData : false,
                    contentType : false,
                    success : function(data){
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
        });
        </script>
    </body>
</html>
