<?php
/* @var $this yii\web\View */
//Temp
//TODO Levels Model

use app\models\Achievement;
use app\models\Comment;
use app\models\Goal;
use app\models\Badge;
use app\models\BadgeCategory;
use app\models\ScalePointsBalance;
use app\models\Level;
use app\models\Alarm;
use amnah\yii2\user\models\User;
use Yii;


$alarms = Alarm::find()->where(['to_user_id' => Yii::$app->user->identity->id])->limit(2)->orderBy(['date_created' => SORT_DESC])->all();
?>
	<!-- notifications -->
	 	<div id="notifications" class="notifications" style="display: none;">
	 		<div class="notifications-close"></div>
	 		 <div class="notifications-blocks">
				
				<?php foreach($alarms as $alarm){ 

					$fromUser = User::findOne($alarm->from_user_id);
					?>
	 		 	<div class="notifications-block <? if($alarm->status == 0 ) { ?>notifications-block__new <? } ?> h-alarm-block" data-alarm_id="<?=$alarm->alarm_id?>">
	 		 		<div class="notifications-block-user">
	 		 			<div class="notifications-block-user-pic" style="background-image: url(<?=$fromUser->getProfile()->one()->getAvatarSrc()?>)"></div>
	 		 			
	 		 		</div>
	 		 		<div class="notifications-block-text">

	 		 			<a href="<?=Yii::$app->urlManager->createUrl(['personal/viewprofile', 'user_id' => $fromUser->id]);?>"><?=$fromUser->getName();?></a> 


						<?php switch($alarm->alarm_type) {
								case 1:
								?>
										оценил 
										<? switch( $alarm->entity_class) {

											case "Achievement":
												$obj = Achievement::findOne( $alarm->entity_id);
												?>
													ваше достижение <a href="<?=Yii::$app->urlManager->createUrl(['personal/achievement', 'achievement_id' => $alarm->entity_id]);?>"><?=$obj->name?></a>
												<?
											break;
											case "Goal":
												$obj = Goal::findOne( $alarm->entity_id);
												?>
													вашу цель <a href="<?=Yii::$app->urlManager->createUrl(['personal/goal', 'goal_id' => $alarm->entity_id]);?>"><?=$obj->name?></a>
												<?
											break;


											} ?>
								<?
								break;
								case 2:
								?>
										прокомментировал 
										<? switch( $alarm->entity_class) {

											case "Achievement":
												$obj = Achievement::findOne( $alarm->entity_id);
												?>
													ваше достижение <a href="<?=Yii::$app->urlManager->createUrl(['personal/achievement', 'achievement_id' => $alarm->entity_id]);?>"><?=$obj->name?></a>
												<?
											break;
											case "Goal":
												$obj = Goal::findOne( $alarm->entity_id);
												?>
													вашу цель <a href="<?=Yii::$app->urlManager->createUrl(['personal/goal', 'goal_id' => $alarm->entity_id]);?>"><?=$obj->name?></a>
												<?
											break;


											} ?>
								<?
								break;
								case 4:
								?>
										подписался на ваши обновления 
										 
								<?
								break;

							}?>

	 		 		
	 		 		</div>
	 		 	</div> 
	 		 	<? } ?>


	 		 </div>
	 		 <div class="notifications-showall"><a href="#">Смотреть все оповещения</a></div>
	 	</div>
		<!-- .notifications END-->

 