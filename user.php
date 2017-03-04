<div class="row">
    <div class="col-4">
        <?php if($_USER->getId() == 0): ?>
        <form id="login-form" method="post" action="api" data-ctrl="user" data-task="login">
            <h4>Sign in</h4>
            <div class="form-body">
                <div class="form-group"><input type="email" class="form-element" name="email" placeholder="Email" required value="<?php if(isset($_GET['email'])) echo $_GET['email']; ?>"></div>
                <div class="form-group"><input type="password" class="form-element" name="password" placeholder="Password" required></div>
                <?php if(isset($_GET['task']) && $_GET['task'] == 'verify' && isset($_GET['token'])): ?>
                <input type="hidden" name="token" readonly value="<?php echo $_GET['token']; ?>">
                <div>Please sign in to validate your account</div>
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
        <?php if(isset($_GET['task']) && $_GET['task'] == 'reset'): ?>
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
        <?php endif; ?>
        <form id="login-form" method="post" action="api" data-ctrl="user" data-task="edit" class="mt-3">
            <h4>Subscribe</h4>
            <div class="form-body">
                <input type="hidden" name="id" value="0">
                <div class="form-group"><input type="email" class="form-element" name="email" placeholder="Email" required></div>
                <div class="form-group"><input type="text" class="form-element" name="nickname" placeholder="Nickname" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés"></div>
                <div class="form-group"><input type="password" class="form-element" name="password" placeholder="Password" required pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Min 8 caractères, obligatoirement composé d'au minimum 1 lettre minuscule/majuscule, un chiffre et un caractère spécial"></div>
                <div class="form-group"><input type="date" class="form-element" name="date_birth" placeholder="Birth date" required></div>
                <div class="form-group"><input type="text" class="form-element" name="city" placeholder="City" required></div>

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
                <div id="profile_image" data-default-url="<?php echo ($_USER->getImage() != NULL) ? $_USER->getImage()->getPath() : ""; ?>" style="background-image:url(<?php echo ($_USER->getImage() != NULL) ? $_USER->getImage()->getPath() : ""; ?>);"></div>
                <div class="form-group custom-file-input">
                    <input id="image_file" type="file" class="form-element" name="image_file" accept="image/.png,.jpg,.jpeg,.gif">
                    <label for="image_file" data-text="Change profile picture ...">Change profile picture ...</label>
                </div>
                <input type="hidden" name="id" value="<?php echo $_USER->getId(); ?>">
                <div class="form-group"><input type="email" class="form-element" name="email" placeholder="Email" required value="<?php echo $_USER->getEmail(); ?>"></div>
                <div class="form-group"><input type="text" class="form-element" name="nickname" placeholder="Nickname" required value="<?php echo $_USER->getNickname(); ?>" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés"></div>
                <div class="form-group"><input type="date" class="form-element" name="date_birth" placeholder="Birth date" required value="<?php echo $_USER->getDateBirth(); ?>"></div>
                <div class="form-group row nopadding clearfix">
                    <div class="col-4">
                        <input id="sex-m" class="form-element" type="radio" name="sex" value="m" <?php if($_USER->getSex() == 'm') echo 'checked'; ?>>
                        <label for="sex-m">Male</label>
                    </div>
                    <div class="col-4">
                        <input id="sex-f" class="form-element" type="radio" name="sex" value="f" <?php if($_USER->getSex() == 'f') echo 'checked'; ?>>
                        <label for="sex-f">Female</label>
                    </div>
                </div>
                <div class="form-group"><input type="text" class="form-element" name="city" placeholder="City" required value="<?php echo $_USER->getCity(); ?>"></div>
                <div class="form-group">
                    <select name="country_id" class="form-element">
                        <?php
                        $countries = App\Model\Country::filter();
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
        <h4>Position</h4>
        <div id="map" style="height:400px;"></div>
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
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjXk_CjR3VFOABhIhnZwu6K21V7m_gJw0&callback=initMap"></script>

        <?php endif; ?>
    </div>
    <div class="col-4">
        <?php if($_USER->getId() > 0): ?>
        <?php $animal = App\Model\Animal::getUniqueById($_GET['pid'] ?? 0); ?>
        <h4>Animal profile <?php echo $animal->getName(); ?></h4>

        <?php if($animal->getId() > 0): ?>
        <form id="profile-animal-form2" method="post" action="api" data-ctrl="profile" data-task="upload">
            <input type="hidden" name="id" value="<?php echo $animal->getId(); ?>">
            <div class="form-group custom-file-input">
                <input id="image_file2" type="file" class="form-element" name="image_file" accept="image/.png,.jpg,.jpeg,.gif">
                <label for="image_file2" data-text="Add an image ...">Add an image ...</label>
                <input type="submit" class="btn" value="Upload">
                <div class="message success-message mt-4">Image has been uploaded</div>
                <div class="message error-message mt-4"></div>
            </div>
            <div class="form-group">
                <ul class="list" id="list-animal-gallery">
                <?php
                $images = $animal->getImageList();
                foreach($images as $image){
                    echo '<li data-id="'.$image->getId().'">
                    <a target="_blank" href="'.$image->getPath().'">'.$image->getName().'</a>
                    <a class="btn btn-delete exec float-right" data-method="post" data-ctrl="profile" data-task="delete_image" data-args="'.$image->getId().'"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </li>';
                }
                ?>
                </ul>
            </div>
        </form>
        <?php endif; ?>

        <form id="profile-animal-form" method="post" action="api" data-ctrl="profile" data-task="edit">
            <input type="hidden" name="id" value="<?php echo $animal->getId(); ?>">
            <div class="form-group"><input type="text" class="form-element" name="name" placeholder="Name" required value="<?php echo $animal->getName(); ?>"></div>
            <div class="form-group row nopadding clearfix">
                <div class="form-group row nopadding clearfix">
                    <div class="col-3">
                        <input id="sex-m-2" class="form-element" type="radio" name="sex" value="m" <?php if($animal->getSex() == 'm') echo 'checked'; ?>>
                        <label for="sex-m-2">Male</label>
                    </div>
                    <div class="col-3">
                        <input id="sex-f-2" class="form-element" type="radio" name="sex" value="f" <?php if($animal->getSex() == 'f') echo 'checked'; ?>>
                        <label for="sex-f-2">Female</label>
                    </div>
                    <div class="col-6">
                        <input id="sex-h-2" class="form-element" type="radio" name="sex" value="h" <?php if($animal->getSex() == 'h') echo 'checked'; ?>>
                        <label for="sex-h-2">Hermaphrodite</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <select name="species_id" class="form-element" required>
                    <option></option>
                    <?php
                    $species = App\Model\Species::filter();
                    foreach($species as $s){
                        $selected = ($s->getId() == $animal->getSpeciesId()) ? 'selected' : '';
                        echo "<option {$selected} value=\"{$s->getId()}\">{$s->getName()}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group"><input type="date" autocomplete="off" class="form-element" name="date_birth" placeholder="Birth date" required value="<?php echo $animal->getDateBirth(); ?>"></div>
            <div class="form-group"><textarea class="form-element" name="description" rows="5" placeholder="Description"><?php echo $animal->getDescription(); ?></textarea></div>

            <h5 class="mt-3">Profile image</h5>
            <div class="form-group custom-file-input">
                <input id="profile_file" type="file" class="form-element" name="profile_file" accept="image/.png,.jpg,.jpeg">
                <label for="profile_file" data-text="Change profile picture ...">Select profile picture ...</label>
            </div>

            <?php
            $profile_img = $animal->getProfileImage();
            if($profile_img instanceof App\Model\Image){
                echo '<div class="cover mb-3">';
                    echo '<img src="'.$profile_img->getPath().'" alt="'.$profile_img->getName().'">';
                echo '</div>';
            }
            ?>

            <h5 class="mt-3">Cover image</h5>
            <div class="form-group custom-file-input">
                <input id="cover_file" type="file" class="form-element" name="cover_file" accept="image/.png,.jpg,.jpeg">
                <label for="cover_file" data-text="Change cover picture ...">Select cover picture ...</label>
            </div>

            <?php
            $cover_img = $animal->getCoverImage();
            if($cover_img instanceof App\Model\Image){
                echo '<div class="cover mb-3">';
                    echo '<img src="'.$cover_img->getPath().'" alt="'.$cover_img->getName().'">';
                echo '</div>';
            }
            ?>

            <h5 class="mt-3">Characteristics</h5>
            <label>Like / dislike</label>
            <div class="form-group"><input type="text" class="form-element" name="info_like" placeholder="Like" value="<?php echo $animal->getInfoLike(); ?>"></div>
            <div class="form-group"><input type="text" class="form-element" name="info_dislike" placeholder="Dislike" value="<?php echo $animal->getInfoDislike(); ?>"></div>

            <div class="form_group mb-2">
                <?php
                $species = App\Model\Species::getUniqueById($animal->getSpeciesId());
                $characteristicList = App\Model\Characteristic::getList($animal);

                foreach($characteristicList as $c){
                    $required = ($c->getRequired()) ? 'required' : '';

                    switch($c->getType()){
                        case App\Model\Characteristic::TYPE_INT :
                            $type = 'number';
                            $number_param = 'min="0" max="" step="1"';
                            break;
                        case App\Model\Characteristic::TYPE_FLOAT :
                            $type = 'number';
                            $number_param = 'min="0" max="" step="0.1"';
                            break;
                        default :
                            $type = 'text';
                            $number_param = '';
                    }


                    echo '<label for="c-'.$c->getId().'">'.$c->getName().'</label>';
                    echo '<input id="c-'.$c->getId().'" type="'.$type.'" '.$number_param.' '.$required.' name="characteristic['.$c->getId().']" class="form-element" placeholder="'.$c->getName().'" value="'.$c->getValue().'">';
                }
                ?>
            </div>
            <footer>
                <div class="message success-message">Changes have been saved</div>
                <div class="message error-message"></div>
                <div class="form-group clearfix"><input type="submit" class="btn float-right" value="Save"></div>
            </footer>
        </form>
        <?php if($animal->getId()): ?>
        <?php
        $comments = $animal->getComments();
        ?>
        <h4 class="mt-2">Comments</h4>
        <form id="profile-animal-form3" method="post" action="api" data-ctrl="comment" data-task="edit" class="mb-3">
            <input type="hidden" name="id" value="0">
            <input type="hidden" name="animal_id" value="<?php echo $animal->getId(); ?>">
            <div class="form-group">
                <textarea class="form-element" name="content" placeholder="Commentaire" required></textarea>
            </div>
            <footer>
                <div class="message success-message">Comment added</div>
                <div class="message error-message"></div>
                <div class="form-group clearfix"><input type="submit" class="btn float-right" value="Send"></div>
            </footer>
        </form>
        <div id="comments">
            <?php
            foreach($comments as $comment){
            $author = $comment->getCreator();
            ?>
            <div class="comment" data-id="<?php echo $comment->getId(); ?>">
                <img alt="" src="<?php echo $author->getImage()->getThumbPath(); ?>">
                <div class="comment-inner">
                    <h5><?php echo $author->getNickname(); ?></h5>
                    <p><?php echo $comment->getContent(); ?></p>
                    <?php if($_SESSION['uid'] == $author->getId()): ?>
                    <ul class="comment-options">
                        <li><a class="btn btn-delete exec" data-method="post" data-ctrl="comment" data-task="delete" data-args="<?php echo $comment->getId(); ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                    </ul>
                    <?php endif; ?>
                    <div class="comment-date"><?php echo $author->getCreationDate(); ?></div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
        <?php endif;?>
        <?php endif;?>
    </div>
    <div class="col-4">
        <?php if($_USER->getId()): ?>
        <h4>My animals <a class="float-right btn btn-add" href="index.php?pid=0"><i class="fa fa-plus" aria-hidden="true"></i></a></h4>
        <ul class="list mb-3" id="list-animal">
        <?php
        $profiles = $_USER->getAnimalList();
        foreach($profiles as $profile){
            echo '<li data-id="'.$profile->getId().'" class="clearfix">
            <a href="index.php?pid='.$profile->getId().'">'.$profile->getName().'</a>
            <div class="float-right">
                <a class="btn" style="display:inline-block;margin-right:0.5rem;" href="index.php?page=match&pid='.$profile->getId().'"><i class="fa fa-heart"></i></a>
                <a class="btn btn-delete exec" style="display:inline-block;" data-method="post" data-ctrl="profile" data-task="delete" data-args="'.$profile->getId().'"><i class="fa fa-trash" aria-hidden="true"></i></a>
            </div>
            </li>';
        }
        ?>
        </ul>
        <h4>Find an animal</h4>
        <form id="profile-animal-form4" method="post" action="api" data-ctrl="profile" data-task="list" class="mb-3">
            <div class="form-group">
                <label for="form-maxdistance">Distance maximale <span id="maxdistance-value"></span></label>
                <input id="form-maxdistance" class="form-element" name="maxdistance" type="range" min="0" step="5" value="0" max="1000">
            </div>
            <div class="form-group mb-2">
                <label for="form-city">City</label>
                <input id="form-city" class="form-element" name="city" type="text" value="" placeholder="City">
            </div>
            <div class="row nopadding">
                <div class=col-6 "form-group">
                    <label for="form-age">Age min</label>
                    <input id="form-age" class="form-element" name="age_min" type="number" min="0" step="1" value="0">
                </div>
                <div class="col-6 form-group">
                    <label for="form-age">Age max</label>
                    <input id="form-age" class="form-element" name="age_max" type="number" min="0" step="1" value="0">
                </div>
            </div>
            <div class="form-group">
                <label for="form-animal-name">Animal name</label>
                <input id="form-animal-name" class="form-element" name="name" type="text" value="" placeholder="Animal name">
            </div>
            <div class="form-group">
                <label for="form-species">Species</label>
                <select id="form-species" name="species_id" class="form-element">
                    <option></option>
                    <?php
                    $species = App\Model\Species::filter();
                    foreach($species as $s){
                        echo "<option value=\"{$s->getId()}\">{$s->getName()}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group row nopadding clearfix">
                <div class="col-3">
                    <input id="sex-a-3" class="form-element" checked type="radio" name="sex" value="">
                    <label for="sex-a-3">All</label>
                </div>
                <div class="col-3">
                    <input id="sex-m-3" class="form-element" type="radio" name="sex" value="m">
                    <label for="sex-m-3">Male</label>
                </div>
                <div class="col-3">
                    <input id="sex-f-3" class="form-element" type="radio" name="sex" value="f">
                    <label for="sex-f-3">Female</label>
                </div>
                <div class="col-3">
                    <input id="sex-h-3" class="form-element" type="radio" name="sex" value="h">
                    <label for="sex-h-3">Other</label>
                </div>
            </div>
            <footer>
                <div class="message error-message"></div>
                <div class="form-group clearfix"><input type="submit" class="btn float-right" value="Filter"></div>
            </footer>
        </form>
        <div id="animal_list" class="mb-4">

        </div>


        <h4>Find an animal owner</h4>
        <form id="profile-animal-form5" method="post" action="api" data-ctrl="user" data-task="list" class="mb-3">
            <div class="form-group">
                <label for="form-owner-name">Owner name</label>
                <input id="form-owner-name" class="form-element" name="nickname" type="text" value="" placeholder="Owner name">
            </div>
            <div class="form-group row nopadding clearfix">
                <div class="col-4">
                    <input id="sex-a-4" class="form-element" checked type="radio" name="sex" value="">
                    <label for="sex-a-4">All</label>
                </div>
                <div class="col-4">
                    <input id="sex-m-4" class="form-element" type="radio" name="sex" value="m">
                    <label for="sex-m-4">Male</label>
                </div>
                <div class="col-4">
                    <input id="sex-f-4" class="form-element" type="radio" name="sex" value="f">
                    <label for="sex-f-4">Female</label>
                </div>
            </div>
            <footer>
                <div class="message error-message"></div>
                <div class="form-group clearfix"><input type="submit" class="btn float-right" value="Filter"></div>
            </footer>
        </form>
        <div id="owner_list">

        </div>
        <?php endif; ?>
    </div>
</div>
