<?php
/* @var $this yii\web\View */
use app\models\Like;
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

							 


							<div class="output-header">
								<h2 class="mdlst-h2t-goals">Квесты</h2>
								<div class="output-header-meta">

									<div class="dropdown-select">
										<div class="dropdown-select-block">
											<div class="dropdown-select-block-text">Политика</div>
											<div class="dropdown-select-block-arrow"></div>
										</div>
										<select name="" id="" class="dropdown-select-real">
											<option value="">Политика</option>
											<option value="">Спорт</option>
											<option value="">Природа</option>
										</select>
									</div>

								</div>

							</div>
							<div class="output-controlls">
								<div class="output-controlls-searchbox"><div class="searchbox"><input type="text" class="searchbox-inp"><div class="searchbox-icon"></div></div></div>
								<div class="output-controlls-checkbox">
									<div class="chk-w">
										<div class="chk-img"></div>
										<div class="chk-t">Подходящие по духу</div>
										<input type="checkbox" class="chk-chk">
									</div>
									
								</div>
								
							</div>
							<div class="quests-list">
								<?php foreach( $quests as $q ) { 
									$rewards = $q->getRewards()->all();

								 

									?>
								<!-- QUEST -->
								<div class="questblock">
									<div class="questblock-pic" style="background-image: url(<?=$q->picture?>)">
										<div class="questblock-pic-tag">музыка</div>
									</div>
									<div class="questblock-info">
										<div class="questblock-info-meta">
											<?php if(!empty($rewards[0]) ) { ?><div class="questblock-info-meta-points">+<?=$rewards[0]->points?> к музыкальности</div> <? } ?>
											<div class="questblock-info-meta-lurms">+2</div>
										</div>
										<div class="questblock-info-title"><?=$q->name?></div>
										<div class="questblock-info-info">
											<ul class="questblock-info-info-list">
												<li class="questblock-info-info-list-li">Участвует: <b>любой</b></li>
												<li class="questblock-info-info-list-li">Дедлайн: <b><?=$q->deadline_period?></b></li>
												<li class="questblock-info-info-list-li">Даты старта: <b>нет</b></li>
											</ul>
											<ul class="questblock-info-info-list-2">
												<li class="questblock-info-info-list-li"><span class="mdlst-accent">Награда: Ночной житель</span></li>
												<li class="questblock-info-info-list-li"><span class="mdlst-accent">Выполнили: 13 466</span></li>
												<li class="questblock-info-info-list-li">Провалили: 241</li>
											</ul>
										</div>
										<div class="questblock-info-controlls">
											<div class="questblock-info-controlls-likes">
												 <?=Yii::$app->like->renderWidget($q);?>
											</div>
											<div class="questblock-info-controlls-comments">
												 <?=Yii::$app->comment->renderCommentCount( count(Comment::getCommentsOfObject($q) ) );?>
											</div>
											<div class="questblock-info-controlls-button">
												<a href="#" class="mdlst-button mdlst-button-default js-quest-takequest" data-id="<?=$q->quest_id?>">Взять квест</a>
											</div>
										</div>
									</div>
									<div class="questblock-comments">
										<?=Yii::$app->comment->renderCommentFeed( $q, 0, 2 );?>
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