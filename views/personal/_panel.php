<?php
/* @var $this yii\web\View */
//Temp
//TODO Levels Model
use Yii;
use app\models\BadgeBalance;
use app\models\BadgeCategory;
use app\models\ScalePointsBalance;
use app\models\Badge;
use app\models\Level;



$level = Level::getUserLevel ( Yii::$app->user->identity->id );
$levelProgress = Level::getUserCurrentLevelProgress( Yii::$app->user->identity->id  );
$levelPointsLeft = Level::getUserNextLevelPointsLeft( Yii::$app->user->identity->id  );
$points = ScalePointsBalance::getUserPointsSum( Yii::$app->user->identity->id  );

$avatarSrc = Yii::$app->user->identity->getProfile()->one()->getAvatarSrc();
 


?>
	<!-- USERPANEL -->
	 	<div id="userpanel" class="userpanel">
	 		<div class="wc">
	 			<div class="userpanel-user">
	 				<div class="userpanel-user-pic" style="background-image: url(<?=$avatarSrc?>)"></div>
	 				<div class="userpanel-user-info">
	 					<div class="userpanel-user-info-name"><?=Yii::$app->user->identity->email?></div>
	 					<div class="userpanel-user-info-date">2 месяца на сайте</div>
	 				</div>
	 			</div>
	 			<div class="userpanel-info">
	 				<div class="userpanel-info-level">
	 					<div class="userpanel-info-level-point"><?=$level->level?></div>
	 				</div>
	 				<div class="userpanel-info-scale">
	 					<div class="interests-selector-scale-viewport userpanel-info-scale-scale">
					 		<div class="interests-selector-scale-track" style="margin-left: -<?=(1-$levelProgress)*100?>%;"></div>
					 	</div>
					 	<p><?=$points?> очков, до следующего уровня осталось  <?=($levelPointsLeft+1)?> очка. <i class="js-tooltip" data-content="Совершайте достижения, чтобы заработать баллы"></i></p>
	 				</div>
	 			</div>
	 		</div>
	 	</div>
		<!-- .USERPANEL END-->