<?php
/* @var $this yii\web\View */
//Temp
//TODO Levels Model
use app\models\BadgeBalance;
use app\models\BadgeCategory;
use app\models\ScalePointsBalance;
use app\models\Badge;
use Yii;

$nextLevelPoints = 100;
$currentLevelPoints = ScalePointsBalance::getUserPointsSum( Yii::$app->user->identity->id);

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
	 					<div class="userpanel-info-level-point">1</div>
	 				</div>
	 				<div class="userpanel-info-scale">
	 					<div class="interests-selector-scale-viewport userpanel-info-scale-scale">
					 		<div class="interests-selector-scale-track" style="margin-left: -<?=(($nextLevelPoints-$currentLevelPoints)/$nextLevelPoints)*100?>%;"></div>
					 	</div>
					 	<p>Ваш уровень, до следующего уровня осталось <?=(100-ScalePointsBalance::getUserPointsSum( Yii::$app->user->identity->id))?> очка. <i class="js-tooltip" data-content="Совершайте достижения, чтобы заработать баллы"></i></p>
	 				</div>
	 			</div>
	 		</div>
	 	</div>
		<!-- .USERPANEL END-->