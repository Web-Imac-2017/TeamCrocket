<div style="width:80%;margin:0 auto;padding:20px 0;">
    <?php if(isset($_GET['task']) && $_GET['task'] == 'recover'): ?>
    <form action="index.php" method="POST" id="recoverPassword" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo gettext("Change your password"); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="recover-password" class="col-3 col-form-label"><?php echo gettext("New password"); ?></label>
                        <div class="col-9">
                            <input id="recover-password" type="password" class="form-control" name="new_password" placeholder="<?php echo gettext("New password"); ?>" required value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="token" value="<?php echo $_GET['token'] ?? ''; ?>">
                    <input type="hidden" name="email" value="<?php echo $_GET['email'] ?? ''; ?>">
                    <input type="hidden" name="task" value="recover">
                    <button type="submit" class="btn btn-primary">Reset</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </form>
    <script>
    $(document).ready(function(){
        $('#recoverPassword').modal('show');
    });
    </script>
    <?php endif; ?>
    <form action="index.php" method="POST" id="resetPassword" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="reset-email" class="col-3 col-form-label"><?php echo gettext("Email"); ?></label>
                        <div class="col-9">
                            <input id="reset-email" type="email" class="form-control" name="email" placeholder="<?php echo gettext("Email"); ?>" required value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="task" value="reset">
                    <button type="submit" class="btn btn-primary">Send</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </form>
    <form action="index.php" method="POST" id="login" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sign in</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="login-email" class="col-3 col-form-label"><?php echo gettext("Email"); ?></label>
                        <div class="col-9">
                            <input id="login-email" type="email" class="form-control" name="email" placeholder="<?php echo gettext("Email"); ?>" required value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="login-password" class="col-3 col-form-label"><?php echo gettext("Password"); ?></label>
                        <div class="col-9">
                            <input id="login-password" type="password" class="form-control" name="password" placeholder="<?php echo gettext("Password"); ?>" required value="">
                        </div>
                    </div>
                    <!-- Button trigger modal -->
                    <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#resetPassword">Forgotten password ?</a>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="task" value="login">
                    <button type="submit" class="btn btn-success">Login</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </form>

    <form action="index.php" method="POST" id="subscribe" class="modal fade" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Subscribe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="user-nickname" class="col-3 col-form-label"><?php echo gettext("Nickname"); ?> *</label>
                        <div class="col-9">
                            <input id="user-nickname" type="text" class="form-control" name="user[nickname]" placeholder="<?php echo gettext("Nickname"); ?>" required value="" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="user-email" class="col-3 col-form-label"><?php echo gettext("Email"); ?> *</label>
                        <div class="col-9">
                            <input id="user-email" type="email" class="form-control" name="user[email]" placeholder="<?php echo gettext("Email"); ?>" required value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="user-password" class="col-3 col-form-label"><?php echo gettext("Password"); ?> *</label>
                        <div class="col-9">
                            <input id="user-password" type="password" class="form-control" name="user[password]" placeholder="<?php echo gettext("Password"); ?>" required pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="user-date_birth" class="col-3 col-form-label"><?php echo gettext("Birth date"); ?></label>
                        <div class="col-9">
                            <input type="date" class="form-control" name="user[date_birth]" placeholder="<?php echo gettext("Birth date"); ?>" value="<?php echo $_USER->getDate_birth(); ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sub-image" class="col-3 col-form-label"><?php echo gettext("Profile picture"); ?></label>
                        <div class="col-9">
                            <input id="sub-image" type="file" class="form-control" name="image_file" placeholder="<?php echo gettext("File"); ?>" accept="image/*">
                            <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />

                            <?php if(!empty($_USER->getImage())): ?>
                            <figure class="figure mt-3">
                                <img class="figure-img img-fluid rounded" width="250" src="<?php echo $_USER->getImage(); ?>" alt="<?php echo $_USER->getNickname(); ?>">
                                <figcaption class="figure-caption"><?php echo gettext("Current profile picture."); ?></figcaption>
                            </figure>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="g-recaptcha float-right mt-4" data-sitekey="6LcIPBUUAAAAAL7aFlWT0BNXe6nNKbRUTvQNrhXg"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="task" value="subscribe">
                    <button type="submit" class="btn btn-success">Subscribe</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </form>

    <?php if($_USER->getId() > 0): ?>
    <p class="clearfix">
        <?php echo gettext("Logged in as"); ?> <b><?php echo $_USER->getNickname(); ?></b>
        <a href="index.php?task=disconnect" class="btn btn-danger float-right"><?php echo gettext("Disconnect"); ?></a>
    </p>
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <h3><?php echo gettext("My account"); ?></h3>
        <hr>
        <fieldset>
            <legend><?php echo gettext("Profile"); ?></legend>
            <input type="hidden" class="form-control" name="user[id]" value="<?php echo $_USER->getId(); ?>">
            <div class="form-group row">
                <label for="user-nickname" class="col-3 col-form-label"><?php echo gettext("Nickname"); ?></label>
                <div class="col-9">
                    <input id="user-nickname" type="text" class="form-control" name="user[nickname]" placeholder="<?php echo gettext("Nickname"); ?>" required value="<?php echo $_USER->getNickname(); ?>" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$">
                </div>
            </div>

            <div class="form-group row">
                <label for="user-firstname" class="col-3 col-form-label"><?php echo gettext("Firstname"); ?></label>
                <div class="col-9">
                    <input id="user-firstname" type="text" class="form-control" name="user[firstname]" placeholder="<?php echo gettext("Firstname"); ?>" value="<?php echo $_USER->getFirstname(); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="user-lastname" class="col-3 col-form-label"><?php echo gettext("Lastname"); ?></label>
                <div class="col-9">
                    <input id="user-lastname" type="text" class="form-control" name="user[lastname]" placeholder="<?php echo gettext("Lastname"); ?>" value="<?php echo $_USER->getLastname(); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="user-email" class="col-3 col-form-label"><?php echo gettext("Email"); ?></label>
                <div class="col-9">
                    <input id="user-email" type="email" class="form-control" name="user[email]" placeholder="<?php echo gettext("Email"); ?>" required value="<?php echo $_USER->getEmail(); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="user-sex" class="col-3 col-form-label"><?php echo gettext("Sex"); ?></label>
                <div class="col-9">
                    <select id="user-sex" name="user[sex]" class="form-control">
                        <option value="h" <?php if($_USER->getSex() == User::SEX_MALE) echo "selected"; ?>><?php echo gettext("Man"); ?></option>
                        <option value="h" <?php if($_USER->getSex() == User::SEX_FEMALE) echo "selected"; ?>><?php echo gettext("Women"); ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="user-description" class="col-3 col-form-label"><?php echo gettext("Description"); ?></label>
                <div class="col-9">
                    <textarea rows="8" id="user-description" name="user[description]" class="form-control" placeholder="<?php echo gettext("Description"); ?>"><?php echo $_USER->getDescription(); ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="user-city" class="col-3 col-form-label"><?php echo gettext("City"); ?></label>
                <div class="col-9">
                    <input id="user-city" type="text" class="form-control" name="user[city]" placeholder="<?php echo gettext("City"); ?>" value="<?php echo $_USER->getCity(); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="user-country" class="col-3 col-form-label"><?php echo gettext("Country"); ?></label>
                <div class="col-9">
                    <select id="user-country" name="user[country]" class="form-control">
                        <option value="FRA" <?php if($_USER->getCountry() == 'FRA') echo "selected"; ?>><?php echo gettext("France"); ?></option>
                        <option value="BEL" <?php if($_USER->getCountry() == 'BEL') echo "selected"; ?>><?php echo gettext("Belgium"); ?></option>
                        <option value="CHE" <?php if($_USER->getCountry() == 'CHE') echo "selected"; ?>><?php echo gettext("Swiss"); ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="user-date_birth" class="col-3 col-form-label"><?php echo gettext("Birth date"); ?></label>
                <div class="col-9">
                    <input type="date" class="form-control" name="user[date_birth]" placeholder="<?php echo gettext("Birth date"); ?>" value="<?php echo $_USER->getDate_birth(); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="user-image" class="col-3 col-form-label"><?php echo gettext("Profile picture"); ?></label>
                <div class="col-9">
                    <input type="file" class="form-control" name="image_file" placeholder="<?php echo gettext("File"); ?>" accept="image/*">
                    <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />

                    <?php if(!empty($_USER->getImage())): ?>
                    <figure class="figure mt-3">
                        <img class="figure-img img-fluid rounded" width="250" src="<?php echo $_USER->getImage(); ?>" alt="<?php echo $_USER->getNickname(); ?>">
                        <figcaption class="figure-caption"><?php echo gettext("Current profile picture."); ?></figcaption>
                    </figure>
                    <?php endif; ?>
                </div>
            </div>
        </fieldset>

        <fieldset class="mt-4">
            <legend><?php echo gettext("Security"); ?></legend>
            <div class="form-group row">
                <label for="user-old_password" class="col-3 col-form-label"><?php echo gettext("Password"); ?></label>
                <div class="col-9">
                    <input id="user-old_password" type="password" class="form-control" name="user[old_password]" placeholder="<?php echo gettext("Old password"); ?>" value="" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                </div>
            </div>
            <div class="form-group row">
                <label for="user-new_password" class="col-3 col-form-label"></label>
                <div class="col-9">
                    <input id="user-new_password" type="password" class="form-control" name="user[new_password]" placeholder="<?php echo gettext("New password"); ?>" value="" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                </div>
            </div>
            <div class="form-group row">
                <label for="user-confirm_password" class="col-3 col-form-label"></label>
                <div class="col-9">
                    <input id="user-confirm_password" type="password" class="form-control" name="user[confirm_password]" placeholder="<?php echo gettext("Confirm password"); ?>" value="" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <input type="hidden" name="task" value="edit_profile">
                    <input type="submit" class="btn btn-primary float-right" name="profile" value="<?php echo gettext("Submit"); ?>">
                </div>
            </div>
        </fieldset>
    </form>
    <?php else: ?>
        <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#login">Login</a> / <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#subscribe">Subscribe</a>

        <div class="row mt-4">
            <?php foreach(User::getMultiple() as $user): ?>
            <div class="col-3 mb-4">
                <div class="card">
                    <img class="card-img-top" style="display:block;" width="100%" height="auto" src="<?php echo $user->getImage(); ?>" alt="Card image cap">
                    <div class="card-block">
                        <h4 class="card-title"><?php echo $user->getNickname(); ?></h4>
                        <p class="card-text" style="width:100%;height:200px;line-height:20px;overflow: hidden;text-overflow: ellipsis;"><?php echo nl2br($user->getDescription()); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
