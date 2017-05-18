<?php
/* @var $this yii\web\View */
use app\models\Goal;
use app\models\Achievement;
use app\models\ScalePointsBalance;
use app\models\Level;
use app\models\Notification;
use app\models\Comment;

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
                            <h2 class="mdlst-h2t-goals">Вы собираетесь бросить вызов!</h2>
                     
                            <div class="clear"></div>
                        </div>
                    </div>

                    <div class="simplebox simplebox-padding">
                        


<!-- QUEST -->
                                <div class="questblock">
                                    <div class="questblock-pic" style="background-image: url(<?=$quest->picture?>)">
                                        <div class="questblock-pic-tag tagbgcolor-<?=$category->category_id?>"><?=$category->name?> </div>
                                    </div>
                                    <div class="questblock-info">
                                        <div class="questblock-info-meta">
                                            <?php if(!empty($rewards[0]) && $scale !== false) { ?><div class="questblock-info-meta-points">+<?=$rewards[0]->points?> к <?=$scale->name;?></div> <? } ?>
                                             
                                        </div>
                                        <div class="questblock-info-title" style="line-height: 1em;"><a href="<?=Yii::$app->urlManager->createUrl(['personal/quest', 'quest_id' => $quest->quest_id])?>"><?=$quest->name?></a></div>
                                        <div class="questblock-info-info">

                                            <ul class="questblock-info-info-list">
                                             <?php if( $badge !== false ) { ?><li class="questblock-info-info-list-li"><img src="/template/img/_reward-small.png" style="max-width: 30px;position: relative;margin-left: -35px; margin-right: 3px; top: 6px;"><a class="mdlst-accent" href="<?=Yii::$app->urlManager->createUrl(['personal/reward-detail', 'badge_id' => $badge->badge_id])?>"><?=$badge->name?></a></li><? } ?>
                                                <li class="questblock-info-info-list-li">Дедлайн: <b><?=Yii::$app->decor->translateDateString($quest->deadline_period)?></b></li>
                                              
                                                
                                                <li class="questblock-info-info-list-li"><span class="mdlst-accent">Выполнили: <?=$quest->getAchievementsCount();?></span></li>
                                                <li class="questblock-info-info-list-li">Провалили: <?=$quest->getFailuresCount();?></li>
                                            </ul>

 

                                        </div>
                                         
                                    </div>
                                    
                                </div>
                                <!-- QUEST END . -->





                                            <h3>Выберите друга</h3>

                                            <?php foreach( $followed as $follower) {  

                                                $u = $follower->getUser();

                                                $profile = $u->getProfile()->one();
                                                $avatarSrc = $profile->getAvatarSrc();

                                                $goalsCount = Goal::find()->where(['user_id' => $u->id])->count();
                                                $achievementsCount = Achievement::find()->where(['user_id' => $u->id])->count();
                                                $points = ScalePointsBalance::getUserPointsSum( $u->id );
                                                $level = Level::getUserLevel ( $u->id );

                                                ?>
                                            <div class="friend-list-block" href="<?=Yii::$app->urlManager->createUrl( ['personal/viewprofile','user_id' => $u->id])?>">
                                                <div class="friend-list-block-pic">
                                                    <img class="friend-list-block-pic-img" src="<?=$avatarSrc?>">
                                                </div>
                                                <div class="friend-list-block-name"><?=$u->getName()?></div>
                                              
                                                <div class="friend-list-block-level"><?=$level->level?></div>
                                              
                                                <div class="friend-list-block-level">
                                                    <? Yii::$app->decor->button('Бросить вызов', '', 'mdlst-button-smaller js-h-questchallenge-user js-questchallenge-select-user', ['user_id' => $u->id]) ?>
                                                </div>
                                            </div>
                                            <?}?>





                    </div>


                         
                    
                </div>
                <!--output-->
                <!-- Списко целей-->
            </div>
        </div>
    </div>
</div>

<!-- . CONTENT END -->