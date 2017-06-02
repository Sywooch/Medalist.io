<?php
/* @var $this yii\web\View */
use app\models\Achievement;
use app\models\Like;
use app\models\Comment;
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



								<!-- user info -->
								<?php 

								if( $other !== false ){
									
								$user = User::findOne( $other );
								$userProfile = $user->getProfile()->one();
								?>
								<div class="achievement-block-user">
									<a class="achievement-block-user-link"  href="<?=Yii::$app->urlManager->createUrl(['personal/viewprofile','user_id' => $user->id])?>">
										<div class="achievement-block-user-pic" style="background-image:  url(<?=$userProfile->getAvatarSrc();?>);"></div>
										<div class="achievement-block-user-name"><?=$user->getName();?></div>
									</a>
									 
								</div>
								<? } ?>
								<!-- user info end -->




							<div class="output-header">
								<h2 class="mdlst-h2t">Достижения (<?= count($achievements)?>)</h2>
								<div class="output-header-meta">

									 
									 <?php if( $other !== false ) { ?><a class="goal-done-button mdlst-button " href="<?=Yii::$app->urlManager->createUrl(['personal/achievement-add' ])?>">+ Добавить новое!</a><? } ?>

								</div>

							</div>



							<div class="output-content">
								 <!-- achievement list -->

								 <div class="achievement-list">
								 	
								 	<?php foreach($achievements as $a) { 

								 		if( $a->difficult == 1 ){
								 			$tags = $a->getTags();
								 			$category = $a->getCategory();

								 		?>

								 	<!-- ACHIEVEMENT BLOCK -->
								 	<div class="achievement-block achievement-block--big">
								 		<!-- meta --> 
								 		<div class="achievement-block-meta">
								 		<?php if( !empty($category) ) { ?>
								 			<div class="achievement-block-category">
								 				<div class="mdlst-cattag mdlst-cattag-1"><?=$category->name?></div>
								 			</div>
								 		<?php } ?>
								 			<div class="achievement-block-tags">
								 			<?php foreach($tags as $tag)  { ?>
								 				<a href="<?=Yii::$app->urlManager->createUrl(['search/tags', 'tag' => $tag->name ])?>" class="achievement-block-tags-tag">#<?=$tag->name?></a>
								 			<?php } ?> 
								 			</div>

								 		</div>

								 		<!-- content --> 
								 		<div class="achievement-block-content">
								 			<div class="achievement-block-content-cols">
							 					<div class="achievement-block-content-title"><a href="<?=Yii::$app->urlManager->createUrl(['personal/achievement','achievement_id' => $a->achievement_id])?>"><?=$a->name?></a></div>
								 				<div class="achievement-block-content-col achievement-block-content-col-1">
								 					<div class="achievement-block-content-info">
								 						<div class="achievement-block-content-info-date"><?=date("d.m.Y H:i", strtotime($a->date_achieved))?></div>
														<?if($a->status == 0){?>
									 						<div class="achievement-block-content-info-status mdlst-status mdlst-status__pending"><span class="mdlst-status-icon"></span> Подтверждается</div>
														<?}?>
														<?if($a->status == 1){?>
									 						<div class="achievement-block-content-info-status mdlst-status mdlst-status__pending"><span class="mdlst-status-icon"></span> Подтверждено</div>
														<?}?>
								 					</div>
														
													<div class="achievement-block-content-description"><?=$a->description;?></div>

								 					<div class="achievement-block-content-bar">
								 						<!-- todo universa;-bar-->	
								 						<?php 
								 						$likesCount = Like::getLikesOfObjectCount ($a);
								 						$dislikesCount = Like::getDislikesOfObjectCount ($a);
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
								 							<?=Yii::$app->like->renderWidget($a);?>
	        											</div>

														<div class="questblock-info-controlls-comments">
																<?=Yii::$app->comment->renderCommentCount( count(Comment::getCommentsOfObject($a)->all() ) , false, true );?>
        												</div>


													</div>
														<div style="margin-top: 30px;">
													<? Yii::$app->decor->button(
        													'Редактировать', 
        													Yii::$app->urlManager->createUrl(['personal/achievement-edit','achievement_id' => $a->achievement_id]) 
        												) ?>
        												</div>


								 				</div>
								 				<div class="achievement-block-content-col achievement-block-content-col-2">
								 					
										 			<div class="achievement-block-rewards">
										 				<div class="achievement-block-rewards-reward">
										 					 
										 				</div>
										 				<div class="achievement-block-rewards-reward">
										 					 
										 				</div>
										 				<!--<div class="achievement-block-rewards-reward">
										 					<div class="mdlst-lurm"><i></i> <b>+2</b></div>
										 				</div>-->
										 			</div>

										 			<div class="achievement-block-images">
										                            <div class="goals-picture-mid" <?php if(!empty($a->getPhotos()[0]) ) { ?> style = "background-image: url(<?=$a->getPhotos()[0]->filename?>);"<? } ?>></div>
										 			</div>

								 				</div>
								 			</div>
								 		</div>

								 		<!-- extra info --> 
								 		<div class="achievement-block-info">Подождите, пока сообщество подтвердит ваше достижение. Чем больше лайков, тем больше шанс!</div>
								 	</div>

								 	<!-- .ACHIEVEMENT BLOCK END -->


								 	<?php

								 		}else{
								 			//Todo partial render


								 			$tags = $a->getTags();
								 			$category = $a->getCategory();



								 			?>


								 	<!-- ACHIEVEMENT BLOCK SMALL-->
								 	<div class="achievement-block achievement-block--small">
								 		<!-- meta --> 
								 		<?php if(!empty($category)) { ?>
								 		<div class="achievement-block-meta">
								 			<div class="achievement-block-category">
								 				<div class="mdlst-cattag mdlst-cattag-2"><?=$category->name;?></div>
								 			</div> 

								 		</div>
								 		<?php } ?>

								 		<!-- content --> 
								 		<div class="achievement-block-content">
								 			<div class="achievement-block-content-cols">
								 				<div class="achievement-block-content-col achievement-block-content-col-1">
								 					<div class="achievement-block-content-title"><?=$a->name?></div>
								 					<div class="achievement-block-content-info">
								 						<div class="achievement-block-content-info-date"><?=date( 'd.m.Y' ,  strtotime($a->date_achieved))?></div>
								 					
								 					</div>
														
													<div class="achievement-block-content-description"><?=$a->description?></div>
  


								 				</div>
								 				<div class="achievement-block-content-col achievement-block-content-col-2">

										 			<div class="achievement-block-images">
										                            <div class="achievement-block-images-picture-small" <?php if(!empty($a->getPhotos()[0]) ) { ?> style = "background-image: url(<?=$a->getPhotos()[0]->filename?>);"<? } ?>></div>
										 			</div>
								 					 
									 			
								 				</div>
								 			</div>
								 		</div>

								 		<!-- extra info --> 
								 		
								 	</div>

								 	<!-- .ACHIEVEMENT BLOCK END -->
								 			<?
								 		}


								 	 } ?>



 

								 </div>
								 <!-- . achievement list end -->
								 <?php if( empty( $achievements) ) { ?>
								 <? Yii::$app->decor->infoPanel('У вас пока нет ни одного достижения Добавьте новое, или выберите какой-нибудь квест, чтобы было, чего достичь.', 'info'); ?>
								 <?}?>

							 </div>							
						 

						</div>

					</div>


				</div>
			</div>
		</div>
		<!-- . CONTENT END -->