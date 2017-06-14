<?php
/* @var $this yii\web\View */
use amnah\yii2\user\models\User;
use app\models\Quest;
use app\models\QuestReward;
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
								<h2 class="mdlst-h2t">Награда <?=$badge->name?></h2>
								<div class="output-header-meta">

									 

								</div>

							</div> 

							<div class="output-content">
								<div style="background-color: white; margin-top: 10px; margin-bottom: 10px; padding: 25px; box-sizing:  border-box; text-align: center;	">
									<img src="<?=$badge->picture?>">
									<p><?=$badge->description?></p>
									<br>
									<br>
									<p><b>
										<?php
										$scale = $badge->getBadgeScalePoints();
										echo "+".$scale['points']." ".$scale['scale']->name;
										 ?></b>
									</p>

									<?php
									if( !empty($badgeBalance) ){
										$user = User::findOne( $badgeBalance->user_id ); 
										?>
										<a class="questdetail-completeduser" href="<?=Yii::$app->urlManager->createUrl( ['personal/viewprofile','user_id' =>  $user->id ])?>">
												<div class="questdetail-completeduser-img"><img src="<?=$user->getProfile()->one()->getAvatarSrc();?>"></div>
												<div class="questdetail-completeduser-text"> <?=$user->getName();?> </div>
											</a>

											<?php if( !empty($badgeBalance->entity_class) && !empty($badgeBalance->entity_id)){
												?>
												<p>Награда получена за <?
												switch ($badgeBalance->entity_class) {
													case 'Quest':
														$obj = Quest::findOne( $badgeBalance->entity_id );
														?> квест <a href="<?=Yii::$app->urlManager->createUrl( ['personal/quest','quest_id' =>  $badgeBalance->entity_id  ])?>"><?=$obj->name ?></a><?
														break;
													
													default:
														# code...
														break;
												}
												?> 

												</p>
												<?
												} ?>
											<div class="mdlst-hr"></div>
										<?
									}
									?>


								<?php 
								$questIds = [];
								$questRewards = QuestReward::find()->where(['badge_id' => $badge->badge_id])->all();
								foreach ($questRewards as $questReward) {
									$questIds[]= $questReward->quest_id;
								}
								$quests = Quest::find()->where(['quest_id' => $questIds])->all();
								if(!empty($quests)) { 
								?>

								<div class="questdetail-completeduser-list">
									<h3>За что можно получить (<?=count($quests)?>): </h3>
									<?php 

										foreach ($quests as $quest) {

											
											?>
											<a class="questdetail-completeduser" href="<?=Yii::$app->urlManager->createUrl( ['personal/quest','quest_id' =>  $quest->quest_id ])?>">
												<div class="questdetail-completeduser-img"><img src="<?=$quest->picture;?>"></div>
												<div class="questdetail-completeduser-text"> <?=$quest->name;?> </div>
											</a>
											<? 
																					# code...
										}


										?>

									
								</div>
								<? 
										}  ?>


								<?php 
								$users = $badge->getAchievedUsers();
								?>

								<div class="questdetail-completeduser-list">
									<h3>Награду получили (<?=count($users)?>): </h3>
									<?php if(!empty($users)) { 

										foreach ($users as $user_id) {

											$user = User::findOne(  $user_id['user_id'] );
											?>
											<a class="questdetail-completeduser" href="<?=Yii::$app->urlManager->createUrl( ['personal/viewprofile','user_id' =>  $user_id['user_id'] ])?>">
												<div class="questdetail-completeduser-img"><img src="<?=$user->getProfile()->one()->getAvatarSrc();?>"></div>
												<div class="questdetail-completeduser-text"> <?=$user->getName();?> </div>
											</a>
											<? 
																					# code...
										}



										}else{
										?>
										<p> Эту награду пока никто не получил. Станьте первым!</p>
										<?
										} ?>

									
								</div>




								</div>

								 
								<div class="mdlst-hr mdlst-hr-w"></div>
									<p>Все награды делятся на категории, однако, есть и универсальные, не принадлежащие ни к одной категории. Сортируются награды в зависимости от своей редкости. Путешествия разделены по странам. Промо награды – награды, которые учреждают наши партнеры.</p>
									<p>Cуществует 50 секретных наград. Находите их в профилях других участников и добавляйте в свою коллекцию секретных наград.</p>
								 
							</div>

						</div>

					</div>


				</div>
			</div>
		</div>
		<!-- . CONTENT END -->