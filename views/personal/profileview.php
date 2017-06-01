<?php
/* @var $this yii\web\View */
use app\models\Goal;
use app\models\Achievement;
use app\models\ScalePointsBalance;
use app\models\Level;
use app\models\Notification;

echo $this->render('_panel.php');




$currentUser = $user->id == Yii::$app->user->identity->id ;

?>
<!-- CONTENT -->
<div class="container">
    <div class="wc">
        <div class="container-cols">
            <?= $this->render("_menu.php") ?>
            <!-- container-content -->
            <div class="container-col container-col-2">
                <!-- Списко целей-->
                <div class="output">
        
                 


                    <div class="profileview">

                        <div class="profileview-aside">
                            <div class="profileview-aside-img">
                                <img src="<?=$user->getProfile()->one()->getAvatarSrc();?>">
                            </div>

                            <div class="profileview-aside-follower">
                                <?php 
                                if( $currentUser ) {  

                                        Yii::$app->decor->button('Это ваша страница!', '', 'mdlst-button-disabled mdlst-button-smaller');
                                        Yii::$app->decor->button('Изменить профиль', '', 'mdlst-button-default mdlst-button-smaller js-update-profile-show withNoButton');

                                     }else{ 

                                        if ( !$isFollowed  ){
                                            Yii::$app->decor->button('Подписаться', '', 'js-follow-person', ['user_id' => $user->id]);  
                                        }else{

                                            Yii::$app->decor->button('Уже подписаны', '', 'mdlst-button-disabled mdlst-button-smaller withNoButton'); 

                                        }
                                }?>
                            </div>
                        </div>


                        <div class="profileview-content">
                            <div  class="profileview-content-view">


				<?$level = Level::getUserLevel( $user->id )->level;?>

                                <div class="profileview-content-level">
                                         <div class="userpanel-info-level userpanel-info-l<?=$level?>">
                                       	    <div class="userpanel-info-level-point userpanel-info-level-p<?=$level;?>" style="padding-top: 19px;"><?=$level;?></div>
                               	        </div>
                	        </div>
                             
                        
                               <div class="output-header">
                                    <div class="mygoals-name-div">
                                        <h2 class="mdlst-h2t-goals withButton"><?=$user->getName()?></h2>
                                 
                                        <div class="clear"></div>
                                    </div>
                                </div>

                                <div>
                                    <? foreach( $interests as $interest) {
                                        Yii::$app->decor->button($interest->name, '', 'mdlst-button-smaller mdlst-button-interest');

                                        } ?>

                                </div>

                                <div class="profileview-scales">
                                    <?php foreach( $scaleBalance as $si => $sb ) {

                                        ?>
                                            <p><?=$scales[$si]->name?> (<?=$sb?>) </p>
                                            <? Yii::$app->decor->scale($sb / $totalBalance) ;?>
                                        <?  
                                        }?>
                                </div>

								<!-- user info -->
								<a class="profileview-allachievements" href="<?=Yii::$app->urlManager->createUrl(['personal/achievements','user_id' => $user->id])?>">
									&raquo; Смотреть все достижения
								</a>
								<!-- user info end -->

                            </div>
                            <?php if( $currentUser ){  ?>
                            <div class="profileview-edit" style="display: none;">
                                <?=$this->render("_edit_profile.php", ['user'=>$user]) ?>

                            </div>
                            <? } ?>


                        </div>



                       
                    </div>
                    <?

        if ($user->id == Yii::$app->user->identity->id ){
            echo "<br>";
            Yii::$app->decor->infoPanel('Поделиться в соцсетях: <b>'.Yii::$app->getRequest()->serverName.Yii::$app->urlManager->createUrl( ['personal/viewprofile','user_id' => Yii::$app->user->identity->id]) .' </b>'); 
        }


                             ?>

                    <br>
                    <br>
                    <?php 
                        foreach($news as $new){

                            //var_dump( $new );
                            Notification::renderNotificationHTML( $new );
                        }
                    ?>


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
				<a href="<?=Yii::$app->urlManager->createUrl( ['personal/viewprofile','user_id' => $user->id])?>" class="possible-friends-block-pic-name"><?=$user->getName()?></a>
				<a href="<?=Yii::$app->urlManager->createUrl( ['personal/viewprofile','user_id' => $user->id])?>" class="possible-friends-block-pic-userlink" style="background-image: url(<?=$avatarSrc;?>);"></a>
	                        <div class="possible-friends-block-follow js-follow-person mdlst-button mdlst-button-default" data-user_id="<?=$user->id?>">Подписаться</div>
			</div>


<!--
                        <div class="possible-friends-block">
                            <div class="possible-friends-block-pic"><img src="<?=$avatarSrc?>"></div>
                            <div class="possible-friends-block-name">
                                <a href="<?=Yii::$app->urlManager->createUrl( ['personal/viewprofile','user_id' => $user->id])?>" class="possible-friends-block-name-url"><?=$user->getName();?></a>
                            </div>
                            <div class="possible-friends-block-follow js-follow-person mdlst-button mdlst-button-default" data-user_id="<?=$user->id?>">Подписаться</div>
                        </div>
-->                       
                        

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