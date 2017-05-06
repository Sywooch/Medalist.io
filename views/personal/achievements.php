<?php
/* @var $this yii\web\View */
use app\models\Achievement;
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
								<h2 class="mdlst-h2t">Достижеия </h2>
								<div class="output-header-meta">

									 
									 <a class="goal-done-button mdlst-button " href="<?=Yii::$app->urlManager->createUrl(['personal/achievement-add' ])?>">+ Добавить новое!</a>

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
								 				<div class="achievement-block-content-col achievement-block-content-col-1">
								 					<div class="achievement-block-content-title"><?=$a->name?></div>
								 					<div class="achievement-block-content-info">
								 						<div class="achievement-block-content-info-date">27.11.2010</div>
								 						<div class="achievement-block-content-info-status mdlst-status mdlst-status__pending"><span class="mdlst-status-icon"></span> Подтверждается</div>
								 					</div>
														
													<div class="achievement-block-content-description"><?=$a->description;?></div>

								 					<div class="achievement-block-content-bar">
								 						<!-- todo universa;-bar-->	
														<div class="mdlst-progress mdlst-progress__smaller mdlst-progress__agressive">
														 	<div class="mdlst-progress-viewport">
														 		<div class="mdlst-progress-track" style="margin-left: -80%"></div>
														 	</div>
														 </div>

								 					</div>
								 					<div class="achievement-block-content-likes">
								 						<?=Yii::$app->like->renderWidget($a);?>
							 							
								 					</div>


								 				</div>
								 				<div class="achievement-block-content-col achievement-block-content-col-2">
								 					
										 			<div class="achievement-block-rewards">
										 				<div class="achievement-block-rewards-reward">
										 					<div class="mdlst-rewardbadge mdlst-rewardbadge-small"><img src="img/_reward-small.png" alt=""></div>
										 				</div>
										 				<div class="achievement-block-rewards-reward">
										 					<div class="mdlst-rewardbadge mdlst-rewardbadge-small"><img src="img/_reward-small.png" alt=""></div>
										 				</div>
										 				<div class="achievement-block-rewards-reward">
										 					<div class="mdlst-lurm"><i></i> <b>+2</b></div>
										 				</div>
										 			</div>

										 			<div class="achievement-block-images">
										 				<div class="achievement-block-images-image"><img src="img/_achievement_01.jpg" alt=""></div>
										 				<div class="achievement-block-images-image"><img src="img/_achievement_02.jpg" alt=""></div>
										 				<div class="achievement-block-images-image"></div>
										 			</div>
										 			<div class="achievement-block-comments">
									 					<div class="comment-controll"><span></span>94 комментария</div>
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
								 			?>


								 	<!-- ACHIEVEMENT BLOCK SMALL-->
								 	<div class="achievement-block achievement-block--small">
								 		<!-- meta --> 
								 		<div class="achievement-block-meta">
								 			<div class="achievement-block-category">
								 				<div class="mdlst-cattag mdlst-cattag-2">Спорт</div>
								 			</div> 

								 		</div>

								 		<!-- content --> 
								 		<div class="achievement-block-content">
								 			<div class="achievement-block-content-cols">
								 				<div class="achievement-block-content-col achievement-block-content-col-1">
								 					<div class="achievement-block-content-title"><?=$a->name?></div>
								 					<div class="achievement-block-content-info">
								 						<div class="achievement-block-content-info-date">27.11.2010</div>
								 					
								 					</div>
														
													<div class="achievement-block-content-description"><?=$a->description?></div>
  


								 				</div>
								 				<div class="achievement-block-content-col achievement-block-content-col-2">
								 					 

										 			<div class="achievement-block-images">
										 				<div class="achievement-block-images-image"><img src="img/_achievement_01.jpg" alt=""></div>
										 		 
										 			</div>
										 			<div class="achievement-block-comments">
									 					<div class="comment-controll"><span></span>94 комментария</div>
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