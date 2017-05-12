<?php
/* @var $this yii\web\View */
use app\models\Like;
use app\models\Comment;
use app\models\Badge;
use app\models\Scale;
use app\models\Category;
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


							 
 
 
							<div class="simplebox simplebox-padding">

								<div class="output-header">
									<h2 class="mdlst-h2t-goals">Квест <?=$quest->name?></h2>
									<div class="output-header-meta">

									 

									</div>

								</div>

								<div class="questblock-pic" style="background-image: url(<?=$quest->picture?>); width: 100%">
									<div class="questblock-pic-tag tagbgcolor-<?=$category->category_id?>"><?=$category->name?>	</div>
								</div>

								<p><?=$quest->description?></p>


								<div class="questblock-info-info">

											<ul class="questblock-info-info-list">
												<li class="questblock-info-info-list-li">Участвует: <b>любой</b></li>
												<li class="questblock-info-info-list-li">Дедлайн: <b><?=Yii::$app->decor->translateDateString($quest->deadline_period)?></b></li>
												<li class="questblock-info-info-list-li">Даты старта: <b>нет</b></li>
											</ul>

											<ul class="questblock-info-info-list-2">
												<?php if( $badge !== false ) { ?><li class="questblock-info-info-list-li"><img src="/template/img/_reward-small.png" style="max-width: 30px;position: relative;margin-left: -35px; margin-right: 3px; top: 6px;"><a class="mdlst-accent" href="<?=Yii::$app->urlManager->createUrl(['personal/reward-detail', 'badge_id' => $badge->badge_id])?>"><?=$badge->name?></a></li><? } ?>
												<li class="questblock-info-info-list-li"><span class="mdlst-accent">Выполнили: <?=$quest->getAchievementsCount();?></span></li>
												<li class="questblock-info-info-list-li">Провалили: <?=$quest->getFailuresCount();?></li>
											</ul>

										</div>



								<div class="questdetail-completeduser-list">
									<h3>Квест выполнили: </h3>
									<?php if(!empty($achievements)) { 

										foreach ($achievements as $achievement) {

											$user = User::findOne( $achievement->user_id );
											?>
											<a class="questdetail-completeduser" href="<?=Yii::$app->urlManager->createUrl( ['personal/viewprofile','user_id' => $achievement->user_id])?>">
												<div class="questdetail-completeduser-img"><img src="<?=$user->getProfile()->one()->getAvatarSrc();?>"></div>
												<div class="questdetail-completeduser-text"> <?=$user->getName();?> </div>
											</a>
											<? 
																					# code...
										}



										}else{
										?>
										<p> Этот квест пока никто не выполнил. Станьте первым!</p>
										<?
										} ?>

									
								</div>

	 							<?=Yii::$app->like->renderWidget($quest);?>

 							</div>

							<div class="questblock-comments questblock-comments-quest-<?=$quest->quest_id?> comments-widget" data-obj="Quest" data-id="<?=$quest->quest_id?>" >
								<div class="questblock-comments-form"><?=Yii::$app->comment->renderResponseForm( $quest  );?></div>
								<div class="questblock-comments-form-wrapper"><?=Yii::$app->comment->renderCommentFeed( $quest, 0, 10 );?></div>
							</div>
						 

						</div>

					</div>


				</div>
			</div>
		</div>
		<!-- . CONTENT END -->