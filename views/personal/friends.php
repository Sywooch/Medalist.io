<?php
/* @var $this yii\web\View */
use app\models\Goal;
use app\models\Achievement;
use app\models\ScalePointsBalance;
use app\models\Level;

echo $this->render('_panel.php');
?>
<link rel="stylesheet" href="/template/css/goals.css">
<!-- CONTENT -->
<div class="container">
    <div class="wc">
        <div class="container-cols">
            <?= $this->render("_menu.php") ?>
            <!-- container-content -->
            <div class="container-col container-col-2">
                <!-- Списко целей-->
                <div class="output">
                    
                   <div class="output-header">
                        <div class="mygoals-name-div">
                            <h2 class="mdlst-h2t-goals withButton">Вы подписаны</h2>
                      
                            <div class="clear"></div>
                        </div>
                    </div>

                    <div class="friend-list-header">
                        <div class="friend-list-header-block-goals friend-list-header-block">Цели</div>
                        <div class="friend-list-header-block-achievements friend-list-header-block">Достижения</div>
                        <div class="friend-list-header-block-points friend-list-header-block">Очки</div>
                        <div class="friend-list-header-block-level friend-list-header-block">Уровень</div>
                    </div>


                    <div class="friend-list">
                    <?php foreach( $followed as $follower) {  

                        $u = $follower->getUser();

                        $profile = $u->getProfile()->one();
                        $avatarSrc = $profile->getAvatarSrc();

                        $goalsCount = Goal::find()->where(['user_id' => $u->id])->count();
                        $achievementsCount = Achievement::find()->where(['user_id' => $u->id])->count();
                        $points = ScalePointsBalance::getUserPointsSum( $u->id );
                        $level = Level::getUserLevel ( $u->id );

                        ?>
                    <a class="friend-list-block" href="<?=Yii::$app->urlManager->createUrl( ['profile/view','user_id' => $u->id])?>">
                        <div class="friend-list-block-pic">
                            <img class="friend-list-block-pic-img" src="<?=$avatarSrc?>">
                        </div>
                        <div class="friend-list-block-name"><?=$u->getName()?></div>
                        <div class="friend-list-block-goals"><?=$goalsCount?></div>
                        <div class="friend-list-block-achievements"><?=$achievementsCount?></div>
                        <div class="friend-list-block-points"><?=$points?></div>
                        <div class="friend-list-block-level"><?=$level->level?></div>
                    </a>
                    <?}?>
                    </div>


                   <div class="output-header">
                        <div class="mygoals-name-div">
                            <h2 class="mdlst-h2t-goals withButton">Вы можете их знать</h2>
                      
                            <div class="clear"></div>
                        </div>
                    </div>

                    <div class="possible-friends">
                    <?php foreach ($possibleFriends as $user) {
                        $profile = $user->getProfile()->one();
                        $avatarSrc= $profile->getAvatarSrc();
                        ?>

                        <div class="possible-friends-block">
                            <div class="possible-friends-block-pic"><img src="<?=$avatarSrc?>"></div>
                            <div class="possible-friends-block-name">
                                <a href="<?=Yii::$app->urlManager->createUrl( ['profile/view','user_id' => $user->id])?>" class="possible-friends-block-name-url"><?=$user->email?></a>
                            </div>
                            <div class="possible-friends-block-follow js-follow-person mdlst-button mdlst-button-default" data-user_id="<?=$user->id?>">Подписаться</div>
                        </div>
                       
                        

                        <?
                    } ?>
                    </div>

                    
                </div>
                <!--output-->
                <!-- Списко целей-->
            </div>
        </div>
    </div>
</div>

<!-- . CONTENT END -->