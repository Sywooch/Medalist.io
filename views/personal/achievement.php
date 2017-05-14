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
									<h2 class="mdlst-h2t-goals" style="white-space: normal; line-height: 1.1em;">Достижение <?=$achievement->name?></h2>
									<div class="output-header-meta">

									 

									</div>

								</div>

								

								<p><?=$achievement->description?></p>


								<?php if(!empty($quest) || !empty($goal)) { 

									?>
									<div class="mdlst-hr"></div>

									<?

									if( !empty($quest) ){
										?>
										<p>Связанный квест: <a href="<?=Yii::$app->urlManager->createUrl(['personal/quest','quest_id' => $quest->quest_id])?>"><?=$quest->name;?></a></p>
										<?
									}
								}?>
 

 

	 							<?=Yii::$app->like->renderWidget($achievement);?>

 							</div>

							<div class="questblock-comments questblock-comments-quest-<?=$achievement->achievement_id?> comments-widget" data-obj="Achievement" data-id="<?=$achievement->achievement_id?>" >
								<div class="questblock-comments-form"><?=Yii::$app->comment->renderResponseForm( $achievement  );?></div>
								<div class="questblock-comments-form-wrapper"><?=Yii::$app->comment->renderCommentFeed( $achievement, 0, 10 );?></div>
							</div>
						 

						</div>

					</div>


				</div>
			</div>
		</div>
		<!-- . CONTENT END -->