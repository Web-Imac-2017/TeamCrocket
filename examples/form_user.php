<?php
/**
* Exemple sans angularJS
*/
session_start();

// pour créer un nouvel utilisateur modifier la valeur en 0
$user = User::getUniqueById((int)$_GET['id'] ?? 0);

if(isset($_POST['user'])){
    $user->hydrate($_POST['user']);
    try{
        $user->save();
    }
    catch(BucketSaveException $e){
        // la sauvegarde a echoué
        echo '<pre>';
        $user->showErrors();
        echo '</pre>';
    }
}
?>
<!DOCTYPE html>
<html style="font-size:14px;">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Jquery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    </head>
    <body>
        <form style="width:90%;margin:0 auto;padding:20px 0;" action="index.php" method="POST">
            <h3><?php echo ($user->getId() == 0) ? "Créer un nouvel utilisateur" : "Modifier l'utilisateur {$user->getId()}"; ?></h3>
            <hr>
            <fieldset>
                <legend>Profil</legend>
                <input type="hidden" class="form-control" name="user[id]" value="<?php echo $user->getId(); ?>">
                <div class="form-group row">
                    <label for="user-nickname" class="col-3 col-form-label">Pseudonyme</label>
                    <div class="col-9">
                        <input id="user-nickname" type="text" class="form-control" name="user[nickname]" placeholder="Pseudonyme" required value="<?php echo $user->getNickname(); ?>">
                    </div>
                </div>
                <?php if($user->getId() == 0): ?>
                    <div class="form-group row">
                        <label for="user-password" class="col-3 col-form-label">Mot de passe</label>
                        <div class="col-9">
                            <input id="user-password" type="password" class="form-control" name="user[password]" placeholder="Password" required value="">
                        </div>
                    </div>
                <?php endif; ?>
                <div class="form-group row">
                    <label for="user-firstname" class="col-3 col-form-label">Prénom</label>
                    <div class="col-9">
                        <input id="user-firstname" type="text" class="form-control" name="user[firstname]" placeholder="Prénom" value="<?php echo $user->getFirstname(); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="user-lastname" class="col-3 col-form-label">Nom</label>
                    <div class="col-9">
                        <input id="user-lastname" type="text" class="form-control" name="user[lastname]" placeholder="Nom" value="<?php echo $user->getLastname(); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="user-email" class="col-3 col-form-label">Email</label>
                    <div class="col-9">
                        <input id="user-email" type="email" class="form-control" name="user[email]" placeholder="Email" required value="<?php echo $user->getEmail(); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="user-sex" class="col-3 col-form-label">Sex</label>
                    <div class="col-9">
                        <select id="user-sex" name="user[sex]" class="form-control">
                            <option value="h" <?php if($user->getSex() == User::SEX_MALE) echo "selected"; ?>>Homme</option>
                            <option value="h" <?php if($user->getSex() == User::SEX_FEMALE) echo "selected"; ?>>Femme</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="user-description" class="col-3 col-form-label">Description</label>
                    <div class="col-9">
                        <textarea rows="8" id="user-description" name="user[description]" class="form-control" placeholder="Description"><?php echo $user->getDescription(); ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="user-city" class="col-3 col-form-label">Ville</label>
                    <div class="col-9">
                        <input id="user-city" type="text" class="form-control" name="user[city]" placeholder="Ville" value="<?php echo $user->getCity(); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="user-country" class="col-3 col-form-label">Pays</label>
                    <div class="col-9">
                        <select id="user-country" name="user[country]" class="form-control">
                            <option value="FRA" <?php if($user->getCountry() == 'FRA') echo "selected"; ?>>France</option>
                            <option value="BEL" <?php if($user->getCountry() == 'BEL') echo "selected"; ?>>Belgique</option>
                            <option value="CHE" <?php if($user->getCountry() == 'CHE') echo "selected"; ?>>Suisse</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="user-date_birth" class="col-3 col-form-label">Date de naissance</label>
                    <div class="col-9">
                        <input type="date" class="form-control" name="user[date_birth]" placeholder="Date de naissance" value="<?php echo $user->getDate_birth(); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="user-image" class="col-3 col-form-label">Image de profil</label>
                    <div class="col-9">
                        <input type="url" class="form-control" name="user[image]" placeholder="URL photo de profil" value="<?php echo $user->getImage(); ?>">
                    </div>
                </div>
            </fieldset>
            <?php if($user->getId() > 0): ?>
            <fieldset class="mt-4">
                <legend>Securité</legend>
                <div class="form-group row">
                    <label for="user-old_password" class="col-3 col-form-label">Mot de passe</label>
                    <div class="col-9">
                        <input id="user-old_password" type="password" class="form-control" name="user[old_password]" placeholder="Ancien mot de passe" value="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="user-new_password" class="col-3 col-form-label"></label>
                    <div class="col-9">
                        <input id="user-new_password" type="password" class="form-control" name="user[new_password]" placeholder="Nouveau mot de passe" value="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="user-confirm_password" class="col-3 col-form-label"></label>
                    <div class="col-9">
                        <input id="user-confirm_password" type="password" class="form-control" name="user[confirm_password]" placeholder="Confirmer mot de passe" value="">
                    </div>
                </div>
            </fieldset>
            <?php endif; ?>
            <input type="submit" class="btn btn-primary float-right mt-4" name="profile" value="Soumettre">
            <div class="clearfix"></div>
        </form>
    </body>
</html>
