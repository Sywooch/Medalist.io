<?php
/* @var $this yii\web\View */
use app\models\Like;
use app\models\Comment;
use app\models\Badge;
use app\models\Scale;
use app\models\Category;
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
								<h2 class="mdlst-h2t-goals h-quest-pendint-tasks-title" <?php if( count($questsPending) == 0) { ?> style="display: none"<?} ?>>Вы участвуете в квестах</h2>
								 
								
							</div>


							<div class="questpending-wrapper">
							<?php foreach($questsPending as $questPending ) {

									$quest = $questPending->getQuest()->one();
							 ?>

							 <div class="questpending">
								 	<div class="questpending-deadline">До <?=$questPending->deadline?></div>
								 	<div class="questpending-title"><?=$quest->name;?></div>
								 	<div class="questpending-description"><?=$quest->description;?></div>
								 	<a href="<?=Yii::$app->urlManager->createUrl(['personal/achievement-add', 'quest_id' => $quest->quest_id])?>" class="questpending-done mdlst-button">Готово!</a>
							</div>

							<?php } ?>
							</div>

							 

							<form method="post" action="">
							<input type="hidden" value="<?=Yii::$app->request->getCsrfToken()?>" placeholder="email" name="_csrf">
							<div class="output-header">
								<h2 class="mdlst-h2t-goals">Квесты</h2>
								<div class="output-header-meta">

									<div class="dropdown-select">
										<div class="dropdown-select-block">
											<div class="dropdown-select-block-text">Политика</div>
											<div class="dropdown-select-block-arrow"></div>
										</div>
										<select name="category_id" id="category_id" class="dropdown-select-real">
											<option value="0">Выберите категорию</option>
											<?php foreach($cats as $cat) {
												?>
												<option value="<?=$cat->category_id?>" <?php if( $category_selected == $cat->category_id) { ?> selected="selected" <? }?>><?=$cat->name?></option>
												<?
											 } ?>
										</select>
									</div>

								</div>

							</div>
							<div class="output-controlls">
								<div class="output-controlls-searchbox"><div class="searchbox"><input type="text" class="searchbox-inp" name="text" value="<?=$predefinedText?>"><div class="searchbox-icon"></div></div></div>
								 
								<? Yii::$app->decor->button('Подобрать')?>
							</div>
							</form>
							<div class="quests-list">
								<?php foreach( $quests as $q ) { 
									$rewards = $q->getRewards()->all();

								 	$badge = false; 
								 	$benefits = [];
									foreach ($rewards as $rew ) {



										if( !empty($rew->badge_id ) ) {
											$badge = Badge::findOne( $rew->badge_id );
										}

										# code...
									}


									//Если есть шкала - юзаем ее, а если только награда - юзаем его
									$scale = false;
									if( !empty($rewards[0]->scale_id )){
								 
										$scale = Scale::findOne( $rewards[0]->scale_id );
									}else{
									 
										if( !empty($rewards[0]->badge_id ) ){
										 
											$badge = Badge::findOne( $rewards[0]->badge_id );
											$badgeScalePoints = $badge->getBadgeScalePoints( );
											if( !empty($badgeScalePoints->scale_id)){
											 
												$scale = Scale::findOne( $badgeScalePoints->scale_id );
											}
										}
									}

									

									if( !empty($q->category_id)){
										$category = Category::findOne( $q->category_id );
									}



									?>
								<!-- QUEST -->
								<div class="questblock">
									<div class="questblock-pic" style="background-image: url(<?=$q->picture?>)">
										<div class="questblock-pic-tag tagbgcolor-<?=$category->category_id?>"><?=$category->name?>	</div>
									</div>
									<div class="questblock-info">
										<div class="questblock-info-meta">
											<?php if(!empty($rewards[0]) && $scale !== false) { ?><div class="questblock-info-meta-points">+<?=$rewards[0]->points?> к <?=$scale->name;?></div> <? } ?>
											 
										</div>
										<div class="questblock-info-title"><a href="<?=Yii::$app->urlManager->createUrl(['personal/quest', 'quest_id' => $q->quest_id])?>"><?=$q->name?></a></div>
										<div class="questblock-info-info">

											<ul class="questblock-info-info-list">
												<li class="questblock-info-info-list-li">Участвует: <b>любой</b></li>
												<li class="questblock-info-info-list-li">Дедлайн: <b><?=Yii::$app->decor->translateDateString($q->deadline_period)?></b></li>
												<li class="questblock-info-info-list-li">Даты старта: <b>нет</b></li>
											</ul>

											<ul class="questblock-info-info-list-2<?php if( $badge !== false ) { ?>-badge<? } ?>">
												<?php if( $badge !== false ) { ?><li class="questblock-info-info-list-li"><img src="/template/img/_reward-small.png" style="max-width: 30px;position: relative;margin-left: -35px; margin-right: 3px; top: 6px;"><a class="mdlst-accent" href="<?=Yii::$app->urlManager->createUrl(['personal/reward-detail', 'badge_id' => $badge->badge_id])?>"><?=$badge->name?></a></li><? } ?>
												<li class="questblock-info-info-list-li"><span class="mdlst-accent">Выполнили: <?=$q->getAchievementsCount();?></span></li>
												<li class="questblock-info-info-list-li">Провалили: <?=$q->getFailuresCount();?></li>
											</ul>

										</div>
										<div class="questblock-info-controlls">
											<div class="questblock-info-controlls-likes">
												 <?=Yii::$app->like->renderWidget($q);?>
											</div>
											<div class="questblock-info-controlls-comments">
												 <?=Yii::$app->comment->renderCommentCount( count(Comment::getCommentsOfObject($q)->all() ), 'questblock-comments-quest-'.$q->quest_id );?>
											</div>
											<div class="questblock-info-controlls-button">
												<a href="#" class="mdlst-button mdlst-button-default js-quest-takequest" data-id="<?=$q->quest_id?>">Взять квест</a>
											</div>
										</div>
									</div>
									
								</div>
								<!-- QUEST END . -->

								<?php  } ?>
								 
							</div>

						</div>

					</div>


				</div>
			</div>
		</div>
		<!-- . CONTENT END -->