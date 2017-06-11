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



								<!-- user info -->
								<?php 
								$user = $achievement->getUser();
								$userProfile = $user->getProfile()->one();
								?>
								<div class="achievement-block-user">
									<a class="achievement-block-user-link"  href="<?=Yii::$app->urlManager->createUrl(['personal/viewprofile','user_id' => $user->id])?>">
										<div class="achievement-block-user-pic" style="background-image:  url(<?=$userProfile->getAvatarSrc();?>);"></div>
										<div class="achievement-block-user-name"><?=$user->getName();?></div>
									</a>
									<a class="achievement-block-user-allachievements" href="<?=Yii::$app->urlManager->createUrl(['personal/achievements','user_id' => $user->id])?>">
										&raquo; Смотреть все достижения
									</a>
								</div>
								<!-- user info end -->

								<div class="mdlst-hr"></div>


								<div class="output-header">
									<h2 class="mdlst-h2t-goals" style="white-space: normal; line-height: 1.1em; float:left;">Достижение</h2>
				 					<div class="achievement-block-content-info" style="margin-top:36px; float:left; margin-left:60px;">
				 						<div class="achievement-block-content-info-date"><?=date("d.m.Y H:i", strtotime($achievement->date_achieved))?></div>
										<?if($achievement->status == 0){?>
				 						<div class="achievement-block-content-info-status mdlst-status mdlst-status__pending"><span class="mdlst-status-icon"></span> Подтверждается</div>
										<?}?>
										<?if($achievement->status == 1){?>
				 						<div class="achievement-block-content-info-status mdlst-status mdlst-status__pending"><span class="mdlst-status-icon"></span> Подтверждено</div>
										<?}?>
				 					</div>

									<div class="clear"></div>
									<h3> <?=$achievement->name?></h3>


<!--
									<div class="output-header-meta">
									Подтверждается
									</div>
-->
								</div>
						<?php 
                       	$photos = $achievement->getPhotos();
                        if(!empty($photos) ) { 
							$thumbs = Yii::$app->decor->getThumbnails($photos);
                        	?>
                        <div class="goals-pictures">
                            <a class="goals-picture-big" href="<?=$photos[0]->filename?>" <?php if(!empty($thumbs[0])) { ?> style = "background-image: url(<?=$thumbs[0]?>);"<? } ?>  data-fancybox="group" ></a>

                            <div class="goals-pictures-small">

                                <? 
                                for ($n = 1; $n < count($photos); $n++) {?>
	                            <a class="goals-picture-small" href="<?=$photos[$n]->filename?>" style = "background-image: url(<?=$thumbs[$n]?>);"  data-fancybox="group" ></a>
                                <? }
                                ?>

                            </div>
                        </div>
                        <? } ?>

                        <div class="clear"></div>



													<div class="achievement-block-content-description"><?=$achievement->description;?></div>





								 					<div class="achievement-block-content-bar">
								 						<!-- todo universa;-bar-->	
								 						<?php 
								 						$likesCount = Like::getLikesOfObjectCount ($achievement);
								 						$dislikesCount = Like::getDislikesOfObjectCount ($achievement);
								 						$totalLikes = $likesCount + $dislikesCount;
								 						if( $totalLikes > 0  ){
								 							$percent = $likesCount / $totalLikes;
								 						}else{
								 							$percent = 0;
								 						}
								 						?>
														<div class="mdlst-progress mdlst-progress__smaller mdlst-progress__agressive">
														 	<div class="mdlst-progress-viewport">
														 		<div class="mdlst-progress-track" style="margin-left: -<?=(1-$percent)*100?>%"></div>
														 	</div>
														 </div>

								 					</div>


													<div class="questblock-info-controlls">
														<div class="questblock-info-controlls-likes">
	 														<?=Yii::$app->like->renderWidget($achievement);?>
	        											</div>

														<div class="questblock-info-controlls-comments">
																<?=Yii::$app->comment->renderCommentCount( count(Comment::getCommentsOfObject($achievement)->all() ) , false, true );?>
        												</div>
													</div>

								 		<!-- extra info --> 
								 		<div class="achievement-block-info">Подождите, пока сообщество подтвердит ваше достижение. Чем больше лайков, тем больше шанс!</div>

													 <?php if( $other === false ) { ?>
														<div style="margin-top: 30px;">


													<? Yii::$app->decor->button(
        													'Редактировать', 
        													Yii::$app->urlManager->createUrl(['personal/achievement-edit','achievement_id' => $achievement->achievement_id]) 
        												) ?>

        												 <? Yii::$app->decor->button( 'Удалить достижение',  '', 'mdlst-button-accent   js-delete-achievement', ['delete_url' => Yii::$app->urlManager->createUrl(['achievement/delete-achievement', 'achievement_id' => $achievement->achievement_id])] );?>
        												</div>

        												<? } ?>

								 		<div class="achievement-share"><? Yii::$app->decor->shareWidget(); ?></div>

								<?php if(!empty($quest) || !empty($goal)) { 

									?>
									<div class="mdlst-hr"></div>

									<?
									//ATTACHED QUEST
									if( !empty($quest) ){

										$questRewards = $quest->getRewards()->all();

										?>
										<p>Связанный квест:</p>
										<div  style="background-image: url(<?=$quest->picture?>)" class="achievement-attachedquest-block">										
											<div class="achievement-attachedquest-block-curtain"></div>
											<div  class="  achievement-attachedquest-info">
												<h3><a href="<?=Yii::$app->urlManager->createUrl(['personal/quest','quest_id' => $quest->quest_id])?>" class="achievement-attachedquest-info-link"><?=$quest->name;?></a></h3>
												<?=$quest->description?>
												
											</div>
											<div class="achievement-attachedquest-rewards">
												<? 
												if( !empty($questRewards) ){ 

													?>
													<p>Награды за квест:</p>
													<ul class="achievement-attachedquest-rewards-list">
														<?
														foreach ($questRewards as $questReward ) {
														 
															$badge = $questReward->getBadge()->one();
															if( !empty($badge) ){
																?>
																<li class="achievement-attachedquest-rewards-list-el"><a href="<?=Yii::$app->urlManager->createUrl(['personal/reward-detail', 'badge_id' => $badge->badge_id])?>" class="achievement-attachedquest-rewards-list-link">Награда &laquo;<?=$badge->name?>&raquo;</a></li>
																<?
															}

															if( !empty($questReward->scale_id) && !empty($questReward->points) ){
																$scale = $questReward->getScale()->one();
																?>
																	<li class="achievement-attachedquest-rewards-list-el">+<?=$questReward->points?> <?=$scale->name;?></li>
																<?
															}
														}
														?>
													</ul>
													<?

												}
												?>
											</div>
										</div>
										<?
									
									//ATTACHED QUEST END
									}


									//ATTACHED GOAL
									if( !empty($goal) ){

									 

										?>
										<p>Связанная цель:</p>
										<div    class="achievement-attachedquest-block" style="background-image: url(/template/img/_goal_achieved.jpg);  ">										
											<div class="achievement-attachedquest-block-curtain"></div>
											<div  class="  achievement-attachedquest-info">
												<h3><a href="<?=Yii::$app->urlManager->createUrl(['personal/goal','goal_id' => $goal->goal_id])?>" class="achievement-attachedquest-info-link"><?=$goal->name;?></a></h3>
												<?=$goal->description?>
												
											</div>
											<div class="achievement-attachedquest-rewards">
												<? 
												if( !empty($questRewards) ){ 

													?>
													<p>Награды за квест:</p>
													<ul class="achievement-attachedquest-rewards-list">
														 
													</ul>
													<?

												}
												?>
											</div>
										</div>
										<?
									
									//ATTACHED GOAL END
									}






								}?>
 

 



							<div class="questblock-comments questblock-comments-quest-<?=$achievement->achievement_id?> comments-widget" data-obj="Achievement" data-id="<?=$achievement->achievement_id?>" >
								<div class="questblock-comments-form"><?=Yii::$app->comment->renderResponseForm( $achievement  );?></div>
								<div class="questblock-comments-form-wrapper"><?=Yii::$app->comment->renderCommentFeed( $achievement, 0, 10 );?></div>
							</div>
						 

						</div>

					</div>

				</div>

				</div>
			</div>
		</div>
		<!-- . CONTENT END -->