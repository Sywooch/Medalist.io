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


$alarms = Alarm::find()->where(['to_user_id' => Yii::$app->user->identity->id])->limit(2)->orderBy(['status' => SORT_ASC, 'date_created' => SORT_DESC])->all();
?>
	<!-- notifications -->
	 	<div id="notifications" class="notifications" style="display: none;">
	 		<div class="notifications-close"></div>
	 		 <div class="notifications-blocks">
				
				<?php foreach($alarms as $alarm){ 

						Alarm::renderAlarmBlockHTML($alarm);
  					 } ?>


	 		 </div>
	 		 <div class="notifications-showall"><a href="<?=Yii::$app->urlManager->createUrl(['personal/alarms']);?>">Смотреть все оповещения</a></div>
	 	</div>
		<!-- .notifications END-->

 