<?php
/* @var $this yii\web\View */
//Temp
//TODO Levels Model

use app\models\BadgeBalance;
use app\models\BadgeCategory;
use app\models\ScalePointsBalance;
use app\models\Badge;
use app\models\Level;
use Yii;


if( !Yii::$app->user->isGuest ) {

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
	 					<div class="userpanel-user-info-name"><?=Yii::$app->user->identity->getName();?></div>
	 					<div class="userpanel-user-info-date">на сайте с <?=date("d.m.Y", strtotime(Yii::$app->user->identity->created_at));?></div>
	 				</div>
	 				<div class="userpanel-user-notifications">
						
	 				</div>
	 			</div>

	 			<div class=" userpanel-info">
		 			<div class=" hint hint--bottom-left hint--info" data-hint="Ваш уровень">
		 				<div class="userpanel-info-level userpanel-info-l<?=$level->level?>">
		 					<div class="userpanel-info-level-point userpanel-info-level-p<?=$level->level?>" ><span></span><?=$level->level?></div>
	 					</div>
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

	<? } ?>