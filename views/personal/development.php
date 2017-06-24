<?php
/* @var $this yii\web\View */
use app\models\Achievement;
use app\models\Badge;
use app\models\Goal;
use app\models\Quest;
use app\models\Like;
use app\models\Comment;
use app\models\Scale;
use amnah\yii2\user\models\User;
echo $this->render('_panel.php');
?>

		<!-- CONTENT -->
		<div class="container">
			<div class="wc">
				<div class="container-cols">
					<?=$this->render("_menu.php")?>


				 
					<!-- container-content -->
					<div class="container-col container-col-2">
						<div class="output">


 



							<div class="output-header">
								<h2 class="mdlst-h2t">Моё развитие</h2>
							 

							</div>



							<div class="output-content">
								 <?php if( !empty( $scalePointsBalance) ) { ?>

								<table class="simplebox simplebox-padding" cellpadding="5" style="width: 100%">
									<tr>
										<td>Дата</td>
										<td>Баллы</td>
										<td>За что</td>
									</tr>
									<?php foreach($scalePointsBalance as $spb) { 

										$scale = $spb->getScale();
										$forHTML = '';
										$translate;

										if( !empty($spb->attached_entity_class) && !empty($spb->attached_entity_id) ){
											$className = "app\\models\\".$spb->attached_entity_class;
											$obj = $className::findOne($spb->attached_entity_id);


											$url = '#';

											switch ($spb->attached_entity_class) {
												case 'Badge':
													$url = Yii::$app->urlManager->createUrl(['personal/reward-detail', 'badge_id' => $spb->attached_entity_id]);
													break;
												case 'Achievement':
													$url = Yii::$app->urlManager->createUrl(['personal/achievement', 'achievement_id' => $spb->attached_entity_id]);
													break;
												case 'Goal':
													$url = Yii::$app->urlManager->createUrl(['personal/goal-detail', 'goal_id' => $spb->attached_entity_id]);
													break;
												case 'Quest':
													$url = Yii::$app->urlManager->createUrl(['personal/quest', 'quest_id' => $spb->attached_entity_id]);
													break;
												
												default:
													# code...
													break;
											}


											$forHTML = Yii::$app->decor->classnameToName($spb->attached_entity_class).' <a href="'.$url.'">'.$obj->name.'</a>';


											if( $spb->type == 'repost'){
												$forHTML = 'Репост в соцсети: '.$forHTML;
											}

										}
										?>
									<tr>
										<td><?=date("d.m.Y H:i", strtotime($spb->date_created))?></td>
										<td>+<?=$spb->points?> <?=$scale->name?></td>
										<td><?=$forHTML?></td>
									</tr>
									<?php } ?>
								</table>

								<?}?>
								 
								 <?php if( empty( $scalePointsBalance) ) { ?>
								 <? Yii::$app->decor->infoPanel('У вас пока нет баллов. Попробуйте взять квест или чего-то достичь.', 'info'); ?>
								 <?}?>

							 </div>							
						 

						</div>

					</div>


				</div>
			</div>
		</div>
		<!-- . CONTENT END -->