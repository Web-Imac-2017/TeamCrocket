<?php if($_USER->getId() > 0): ?>
    <div class="row">
        <div class="col-12">
            <h4>Match</h4>
        </div>
    </div>
    <?php $a = App\Model\Animal::getUniqueById($_GET['pid'] ?? 0); ?>
    <?php if($a->getId() > 0 && $a->getCreatorId() == $_USER->getId()): ?>
    <div class="row">
        <div class="col-4">
            <div class="match-profile a-profile align-right">
                <div class="profile-pic">
                <?php $image = $a->getProfileImage(); if($image != NULL): ?>
                    <img src="<?php echo $image->getPath(); ?>">
                <?php endif; ?>
                </div>
                <h5><?php echo $a->getName() . ', ' . $a->getSpecies()->getName() . ', ' . $a->getAge(); ?> ans</h5>
                <div class="profile-data float-right">
                    <ul class="info-list">
                        <?php if($a->getInfoLike() != ''): ?>
                        <li class="info info-like"><span>Aime :</span> <?php echo $a->getInfoLike(); ?></li>
                        <?php endif; ?>
                        <?php if($a->getInfoDislike() != ''): ?>
                        <li class="info info-dislike"><span>Aime pas :</span> <?php echo $a->getInfoDislike(); ?></li>
                        <?php endif; ?>
                    </ul>
                    <p class="mt-2"><?php echo $a->getDescription(); ?></p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-4">
            <?php $b = App\Model\Match::getSuggestion($a); ?>
            <?php if($b != NULL): ?>
            <div class="match-profile b-profile align-left">
                <div class="profile-pic">
                    <?php $image = $b->getProfileImage(); if($image != NULL): ?>
                        <img src="<?php echo $image->getPath(); ?>">
                    <?php endif; ?>
                    <div class="feedback feedback-yes">
                        <i class="fa fa-heart"></i>
                        <div class="feedback-bg"></div>
                    </div>
                    <div class="feedback feedback-no">
                        <i class="fa fa-times"></i>
                        <div class="feedback-bg"></div>
                    </div>
                </div>
                <h5><?php echo $b->getName() . ', ' . $b->getSpecies()->getName() . ', ' . $b->getAge(); ?> ans</h5>
                <div class="profile-data clearfix">
                    <ul class="info-list">
                        <?php if($b->getInfoLike() != ''): ?>
                        <li class="info info-like"><span>Aime :</span> <?php echo $b->getInfoLike(); ?></li>
                        <?php endif; ?>
                        <?php if($b->getInfoDislike() != ''): ?>
                        <li class="info info-dislike"><span>Aime pas :</span> <?php echo $b->getInfoDislike(); ?></li>
                        <?php endif; ?>
                    </ul>
                    <p class="mt-2"><?php echo $b->getDescription(); ?></p>
                </div>
            </div>
            <?php else: ?>
            <p>Aucun profil disponible...</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <p id="it-is-a-match">It's a match !</p>
        </div>
    </div>
    <div class="row">
        <?php if($b != NULL): ?>
        <div class="col-4">
            <a id="match-no" class="btn btn-delete exec btn-match float-right" data-method="post" data-ctrl="match" data-task="swipe" data-args="<?php echo $a->getId() . '/' . $b->getId() . '/0'; ?>"><i class="fa fa-times"></i></a>
        </div>
        <div class="col-4 align-left">
            <a id="match-yes" class="btn btn-add exec btn-match float-left" data-method="post" data-ctrl="match" data-task="swipe" data-args="<?php echo $a->getId() . '/' . $b->getId() . '/1'; ?>"><i class="fa fa-heart"></i></a>
        </div>
        <?php endif; ?>
    </div>
    <?php else: ?>
        <div class="row">
            <div class="col-12">
                <p>Sélectionnez le profil d'un animal dont vous êtes propriétaire...</p>
            </div>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="row">
        <div class="col-12">
            <p>Vous devez vous connecter...</p>
        </div>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-12 mt-2">
        <a href="index.php">Retour</a>
    </div>
</div>

<script>
var callbacks = callbacks || {};

$(function(){
    var $pp = $('.profile-pic');

    $(window).on('load resize', function(){
        $pp.css('height', ($pp.width())+'px');
    });


    callbacks.match = {
        // tâche "login"
        swipe : function(data){
            if(data.success){
                var delay = 1000;
                var $bProfile = $('.b-profile');

                $('.btn-match').remove();
                $bProfile.find('.feedback').css('display', 'none');

                if(data.output.interested){
                    $bProfile.find('.feedback-yes').css('display', 'block');
                }
                else{
                    $bProfile.find('.feedback-no').css('display', 'block');
                }

                if(data.output.match){
                    $('#it-is-a-match').css('display', 'block');
                    delay = 2000;
                }

                setTimeout(function(){
                    location.reload();
                }, delay);
            }
        }
    }
});
</script>
