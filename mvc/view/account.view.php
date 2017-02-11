<div style="width:90%;margin:0 auto;padding:20px 0;">
    <?php if($user->getId() > 0): ?>
    <p class="clearfix">
        <?php echo gettext("Logged in as"); ?> <b><?php echo $user->getNickname(); ?></b>
        <a href="index.php?disconnect" class="btn btn-danger float-right"><?php echo gettext("Disconnect"); ?></a>
    </p>
    <?php else: ?>
    <form action="index.php" method="POST" class="mb-5" style="width:50%;">
        <h3><?php echo gettext("Login"); ?></h3>
        <hr>
        <fieldset>
            <div class="form-group row">
                <label for="user-email" class="col-3 col-form-label"><?php echo gettext("Email"); ?></label>
                <div class="col-9">
                    <input id="user-email" type="email" class="form-control" name="login[email]" placeholder="<?php echo gettext("Email"); ?>" required value="">
                </div>
            </div>
            <div class="form-group row">
                <label for="user-password" class="col-3 col-form-label"><?php echo gettext("Password"); ?></label>
                <div class="col-9">
                    <input id="user-password" type="password" class="form-control" name="login[password]" placeholder="<?php echo gettext("Password"); ?>" required value="">
                </div>
            </div>
            <input type="submit" class="btn btn-primary float-right mt-4" value="<?php echo gettext("Login"); ?>">
            <div class="clearfix"></div>
        </fieldset>
    </form>
    <?php endif; ?>

    <form action="index.php" method="POST" enctype="multipart/form-data">
        <h3><?php echo ($user->getId() == 0) ? gettext("Create a new user") : sprintf(gettext("Modify user %s"), $user->getId()); ?></h3>
        <hr>
        <fieldset>
            <legend><?php echo gettext("Profile"); ?></legend>
            <input type="hidden" class="form-control" name="user[id]" value="<?php echo $user->getId(); ?>">
            <div class="form-group row">
                <label for="user-nickname" class="col-3 col-form-label"><?php echo gettext("Nickname"); ?></label>
                <div class="col-9">
                    <input id="user-nickname" type="text" class="form-control" name="user[nickname]" placeholder="<?php echo gettext("Nickname"); ?>" required value="<?php echo $user->getNickname(); ?>">
                </div>
            </div>
            <?php if($user->getId() == 0): ?>
                <div class="form-group row">
                    <label for="user-password" class="col-3 col-form-label"><?php echo gettext("Password"); ?></label>
                    <div class="col-9">
                        <input id="user-password" type="password" class="form-control" name="user[password]" placeholder="<?php echo gettext("Password"); ?>" required value="">
                    </div>
                </div>
            <?php endif; ?>
            <div class="form-group row">
                <label for="user-firstname" class="col-3 col-form-label"><?php echo gettext("Firstname"); ?></label>
                <div class="col-9">
                    <input id="user-firstname" type="text" class="form-control" name="user[firstname]" placeholder="<?php echo gettext("Firstname"); ?>" value="<?php echo $user->getFirstname(); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="user-lastname" class="col-3 col-form-label"><?php echo gettext("Lastname"); ?></label>
                <div class="col-9">
                    <input id="user-lastname" type="text" class="form-control" name="user[lastname]" placeholder="<?php echo gettext("Lastname"); ?>" value="<?php echo $user->getLastname(); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="user-email" class="col-3 col-form-label"><?php echo gettext("Email"); ?></label>
                <div class="col-9">
                    <input id="user-email" type="email" class="form-control" name="user[email]" placeholder="<?php echo gettext("Email"); ?>" required value="<?php echo $user->getEmail(); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="user-sex" class="col-3 col-form-label"><?php echo gettext("Sex"); ?></label>
                <div class="col-9">
                    <select id="user-sex" name="user[sex]" class="form-control">
                        <option value="h" <?php if($user->getSex() == User::SEX_MALE) echo "selected"; ?>><?php echo gettext("Man"); ?></option>
                        <option value="h" <?php if($user->getSex() == User::SEX_FEMALE) echo "selected"; ?>><?php echo gettext("Women"); ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="user-description" class="col-3 col-form-label"><?php echo gettext("Description"); ?></label>
                <div class="col-9">
                    <textarea rows="8" id="user-description" name="user[description]" class="form-control" placeholder="<?php echo gettext("Description"); ?>"><?php echo $user->getDescription(); ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="user-city" class="col-3 col-form-label"><?php echo gettext("City"); ?></label>
                <div class="col-9">
                    <input id="user-city" type="text" class="form-control" name="user[city]" placeholder="<?php echo gettext("City"); ?>" value="<?php echo $user->getCity(); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="user-country" class="col-3 col-form-label"><?php echo gettext("Country"); ?></label>
                <div class="col-9">
                    <select id="user-country" name="user[country]" class="form-control">
                        <option value="FRA" <?php if($user->getCountry() == 'FRA') echo "selected"; ?>><?php echo gettext("France"); ?></option>
                        <option value="BEL" <?php if($user->getCountry() == 'BEL') echo "selected"; ?>><?php echo gettext("Belgium"); ?></option>
                        <option value="CHE" <?php if($user->getCountry() == 'CHE') echo "selected"; ?>><?php echo gettext("Swiss"); ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="user-date_birth" class="col-3 col-form-label"><?php echo gettext("Birth date"); ?></label>
                <div class="col-9">
                    <input type="date" class="form-control" name="user[date_birth]" placeholder="<?php echo gettext("Birth date"); ?>" value="<?php echo $user->getDate_birth(); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="user-image" class="col-3 col-form-label"><?php echo gettext("Profile picture"); ?></label>
                <div class="col-9">
                    <input type="file" class="form-control" name="image_file" placeholder="<?php echo gettext("File"); ?>" accept="image/*">
                    <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />

                    <?php if(!empty($user->getImage())): ?>
                    <figure class="figure mt-3">
                        <img class="figure-img img-fluid rounded" width="250" src="<?php echo $user->getImage(); ?>" alt="<?php echo $user->getNickname(); ?>">
                        <figcaption class="figure-caption"><?php echo gettext("Current profile picture."); ?></figcaption>
                    </figure>
                    <?php endif; ?>
                </div>
            </div>
        </fieldset>
        <?php if($user->getId() > 0): ?>
        <fieldset class="mt-4">
            <legend><?php echo gettext("Security"); ?></legend>
            <div class="form-group row">
                <label for="user-old_password" class="col-3 col-form-label"><?php echo gettext("Password"); ?></label>
                <div class="col-9">
                    <input id="user-old_password" type="password" class="form-control" name="user[old_password]" placeholder="<?php echo gettext("Old password"); ?>" value="">
                </div>
            </div>
            <div class="form-group row">
                <label for="user-new_password" class="col-3 col-form-label"></label>
                <div class="col-9">
                    <input id="user-new_password" type="password" class="form-control" name="user[new_password]" placeholder="<?php echo gettext("New password"); ?>" value="">
                </div>
            </div>
            <div class="form-group row">
                <label for="user-confirm_password" class="col-3 col-form-label"></label>
                <div class="col-9">
                    <input id="user-confirm_password" type="password" class="form-control" name="user[confirm_password]" placeholder="<?php echo gettext("Confirm password"); ?>" value="">
                </div>
            </div>
        </fieldset>
        <?php endif; ?>
        <input type="submit" class="btn btn-primary float-right mt-4" name="profile" value="<?php echo gettext("Submit"); ?>">
        <div class="clearfix"></div>
    </form>
</div>
