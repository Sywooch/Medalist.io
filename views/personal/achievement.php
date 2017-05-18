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
									<h2 class="mdlst-h2t-goals" style="white-space: normal; line-height: 1.1em;">Достижение</h2>
									<h3> <?=$achievement->name?></h3>
									<div class="output-header-meta">

									 

									</div>

								</div>

                        <?php if(!empty($achievement->getPhotos()) ) { ?>
                        <div class="goals-pictures">
                            <div class="goals-picture-big" <?php if(!empty($achievement->getPhotos()[0]) ) { ?> style = "background-image: url(<?=$achievement->getPhotos()[0]->filename?>);"<? } ?>></div>

                            <div class="goals-pictures-small">

                                <? $Photos = $achievement->getPhotos();
                                for ($n = 1; $n < count($Photos); $n++) {?>
	                            <div class="goals-picture-small" style = "background-image: url(<?=$Photos[$n]->filename?>);"></div>
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

								<?php if(!empty($quest) || !empty($goal)) { 

									?>
									<div class="mdlst-hr"></div>

									<?

									if( !empty($quest) ){
										?>
										<p>Связанный квест: <a href="<?=Yii::$app->urlManager->createUrl(['personal/quest','quest_id' => $quest->quest_id])?>"><?=$quest->name;?></a></p>
										<div>										
											<div class="questblock-pic-achievment" style="background-image: url(<?=$quest->picture?>)"></div>
											<div  class="questblock-descr-achievment"><?=$quest->description?></div>
										</div>
										<?
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