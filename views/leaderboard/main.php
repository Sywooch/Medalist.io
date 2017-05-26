<?php
/* @var $this yii\web\View */
use app\models\Goal;
use app\models\Achievement;
use app\models\ScalePointsBalance;
use app\models\Level;
use app\models\Notification;
use amnah\yii2\user\models\User;
echo $this->render('//personal/_panel.php');


 

?>
<!-- CONTENT -->
<div class="container">
    <div class="wc">
        <div class="container-cols">
            <?=$this->render("//personal/_menu.php") ?>
            <!-- container-content -->
            <div class="container-col container-col-2">
                <!-- Списко целей-->
                <div class="output">
        
         
                       <div class="output-header">
                            <div class="mygoals-name-div">
                                <h2 class="mdlst-h2t-goals withButton">Зал славы</h2>
                         
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
                    <?php foreach( $rows as $row) {  

                        $u = User::findOne( $row['user_id'] );

                        if (!$u) { continue; }

                        $profile = $u->getProfile()->one();
                        $avatarSrc = $profile->getAvatarSrc();

                        $goalsCount = Goal::find()->where(['user_id' => $u->id])->count();
                        $achievementsCount = Achievement::find()->where(['user_id' => $u->id])->count();
                        $points = ScalePointsBalance::getUserPointsSum( $u->id );
                        $level = Level::getUserLevel ( $u->id );

                        if ( Yii::$app->user->isGuest ){
                            $you = false;
                        }else{
                            $you = Yii::$app->user->identity->id == $u->id;
                        }

                        ?>
                    <a class="friend-list-block" href="<?=Yii::$app->urlManager->createUrl( ['personal/viewprofile','user_id' => $u->id])?>" <? if( $you ) { ?> style="background-color: #00fff6;" <? }?>>
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



  
                    
                </div>
                <!--output-->
                <!-- Списко целей-->
            </div>
        </div>
    </div>
</div>

<!-- . CONTENT END -->