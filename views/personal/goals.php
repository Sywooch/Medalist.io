<?php
/* @var $this yii\web\View */
use app\models\Goal;
use app\models\Like;
use app\models\Comment;
use amnah\yii2\user\models\User;
echo $this->render('_panel.php');
?>
<!-- CONTENT -->
<div class="container">
    <div class="wc">
        <div class="container-cols">
            <?= $this->render("_menu.php") ?>
            <!-- container-content -->
            <div class="container-col container-col-2">
                <!-- Списко целей-->
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
                        <div class="mygoals-name-div">
                            <h2 class="mdlst-h2t-goals withButton">Цели (<?= count($goals) ?>)</h2>
							 <?php if( $other === false ) { ?>
                            <a class="goal-done-button mdlst-button withHeader" href="<?= Yii::$app->urlManager->createUrl('personal/goal-add') ?>">+ Добавить новую цель</a>
								<? } ?>

                            <div class="clear"></div>
                        </div>
                    </div>







								 <div class="achievement-list">
								 	
								 	<?php foreach($goals as $a) { 

								 			$tags = $a->getTags();

								 		?>

								 	<!-- ACHIEVEMENT BLOCK -->
								 	<div class="achievement-block achievement-block--big">
								 		<!-- meta --> 
								 		<div class="achievement-block-meta">
								 			<div class="achievement-block-tags">
								 			<?php foreach($tags as $tag)  { ?>
								 				<a href="<?=Yii::$app->urlManager->createUrl(['search/tags', 'tag' => $tag->name ])?>" class="achievement-block-tags-tag">#<?=$tag->name?></a>
								 			<?php } ?> 
								 			</div>

								 		</div>

								 		<!-- content --> 
								 		<div class="achievement-block-content">
								 			<div class="achievement-block-content-cols">

											<div class="achievement-block-content-cols">

								 				<div class="achievement-block-content-header-col achievement-block-content-header-col-1">


                                        <? if ($a->getProgressPercent() < 100) { ?>

<div class="status-icon  hint--bottom-left  hint--success" style="background:url(/template/img/goals/checkbox.png) no-repeat scroll 0 0; float:left; margin-right:10px; top:5px; width:26px; height:25px;" aria-label="Цель в процессе"></div>
                                       <? }
										else{?>
<div class="status-icon  hint--bottom-left  hint--success" style="background:url(/template/img/goals/checkbox.png) no-repeat scroll 0 -25px; float:left; margin-right:10px; top:5px; width:26px; height:25px;" aria-label="Цель достигнута"></div>
										<?} ?>

								 					<div class="achievement-block-content-title"><a href="<?=Yii::$app->urlManager->createUrl(['personal/goal','goal_id' => $a->goal_id])?>"><?=$a->name?></a></div>
												</div>
							 				

											 <?php if( $other === false ) { ?>
											<div class="achievement-block-content-col achievement-block-content-header-col-2">
												<div class="achievement-block-content-nav-serv">
													<ul id="nav-serv">
													  <li><a href="#"></a>
													    <ul>
													      <li><a href="<?=Yii::$app->urlManager->createUrl(['personal/goal-update','goal_id' => $a->goal_id]) ?>">Редактировать</a></li>
													      <li><a class="js-delete-goal" href="<?=Yii::$app->urlManager->createUrl(['goal/delete-goal', 'goal_id' => $a->goal_id]) ?>">Удалить</a></li>
													    </ul>
													  </li>
													</ul>
												</div>
											</div>
											<? } ?>

											</div>

								 				<div class="achievement-block-content-col achievement-block-content-col-1">
								 					<div class="achievement-block-content-info">



                                <div class="mygoals-stats-div withNoButton">
                                    <div class="mygoals-left-wrapper">
                                        <span class="mygoals-diff">Сложность</span>

                                        <div class="mygoals-stars">
                                            <?
                                            $difficulty = round( ($a->difficulty / 100) * 3 );
                                            for ($n = 1; $n <= $difficulty; $n++) {
                                                echo '<div class="mygoals-star star-yellow"></div>';
                                            }
                                            for ($n = $difficulty; $n < 3; $n++) {
                                                echo '<div class="mygoals-star star-grey"></div>';
                                            }

                                            ?>
                                        </div>
                                        <span class="mygoals-dead">Дедлайн</span>
                                        <span
                                            class="mygoals-dead color-red"><? echo date("d.m.Y", strtotime($a->deadline)) ?></span>
                                        <?
                                        if ($a->private) {
                                            echo '
                                 		<div class="mygoals-lock"><img src="/template/img/goals/lock.png" alt=""/></div>
                                 		 <span class="mygoals-privat">Приватная</span>';
                                        } ?>
                                        <div class="mygoals-progress withProcess">
                                            <div class="interests-selector-scale-viewport userpanel-info-scale-scale">
                                                <div class="interests-selector-scale-track"
                                                     style="margin-left: -<?= 100 - $a->getProgressPercent() ?>%;"></div>
                                            </div>
                                        </div>
                                        <? if (!$a->completed) { ?>
			                                 <div class="processWprogress">
            			                     <div class="mygoals-clock"><img src="/template/img/goals/clock.png" alt=""></div>
                        			          <span class="mygoals-process">В процессе</span>
			                                 </div>
                                       <? }
										else{?>
			                                 <div class="processWprogress">
            			                     <div class="mygoals-clock"><img src="/template/img/goals/clock.png" alt=""></div>
                        			          <span class="mygoals-completed">Выполнена!</span>
			                                 </div>
										<?} ?>
                                    </div>
                                </div>
                            <div class="clear"></div>



								 					</div>

														
													<div class="achievement-block-content-description"><?=$a->description;?></div>
													<div class="questblock-info-controlls">

														<div class="questblock-info-controlls-likes">
								 							<?=Yii::$app->like->renderWidget($a);?>
	        											</div>

														<div class="questblock-info-controlls-comments">
																<?=Yii::$app->comment->renderCommentCount( count(Comment::getCommentsOfObject($a)->all() ) , false, true );?>
        												</div>


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
					
												 	<?php
			                					       	$photos = $a->getPhotos();
						            	        	    if(!empty($photos) ) { 
														$thumbs = Yii::$app->decor->getThumbnails($photos);
    	                					    	?>

										 			<div class="achievement-block-images">
										                    <div class="goals-picture-mid" <?php if(!empty($photos[0]) ) { ?> style = "background-image: url(<?=$thumbs[0]?>);"<? } ?>></div>
										 			</div>
						                    	    <? } ?>

								 				</div>
								 			</div>
								 		</div>

								 		<!-- extra info --> 

								 	</div>

								 	<!-- .ACHIEVEMENT BLOCK END -->



					 			<? } ?>



								 </div>






                    <?php if(empty($goals)) { 
						if(!$other){
	                        Yii::$app->decor->infoPanel('Вы пока не добавили целей. Добавьте с помощью кнопки выше!', 'info'); 	
						}else{
						    Yii::$app->decor->infoPanel('Пользователь пока не добавил ни одной цели.', 'info'); 	
							}
 
                     } ?>

                    <!--goal-content-->
                </div>
                </div>
                <!--output-->
                <!-- Списко целей-->
            </div>
        </div>
    </div>
</div>

<!-- . CONTENT END -->