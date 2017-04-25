<?php
/* @var $this yii\web\View */

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
								<h2 class="mdlst-h2t">Мои награды</h2>
								<div class="output-header-meta">

									 

								</div>

							</div> 

							<div class="output-content">
								
								<p>Награды подтверждают выдающиеся достижения. У нас есть обширный каталог наград, а есть и секретные, о которых никто не знает.</p>

								<div class="myrewards-list">
									<?php foreach($badges as $badge) { ?> 
									<a class="myrewards-block" href="<?=Yii::$app->urlManager->createUrl(['personal/reward-detail', 'badge_id' => $badge->badge_id])?>">
										<div class="myrewards-block-pic"><img src="/template/img/_reward.png" alt=""></div>
										<div class="myrewards-block-text"><?=$badge->getBadge()->name;?></div>
										<div class="myrewards-block-points"><span class="c-analytics">+<?=$badge->getScalePoints()->points;?> к <?=$badge->getScalePoints()->getScale()->name;?></span></div>
									</a>
									<? }  ?> 
								</div>

								<div class="mdlst-hr mdlst-hr-w"></div>
									<p>Все награды делятся на категории, однако, есть и универсальные, не принадлежащие ни к одной категории. Сортируются награды в зависимости от своей редкости. Путешествия разделены по странам. Промо награды – награды, которые учреждают наши партнеры.</p>
									<p>Cуществует 50 секретных наград. Находите их в профилях других участников и добавляйте в свою коллекцию секретных наград.</p>
									
								<div class="rewards-catalog">
									<div class="rewards-catalog-header">
										<div class="rewards-catalog-header-text">
											Работа
										</div>
										<div class="rewards-catalog-header-meta">
													


											<div class="dropdown-select">
												<div class="dropdown-select-block">
													<div class="dropdown-select-block-text"><?=$badgeGroups[0]->name?></div>
													<div class="dropdown-select-block-arrow"></div>
												</div>

												<select name="" id="" class="dropdown-select-real">
												<?php foreach( $badgeGroups as $bg ) { ?>
													<option value="<?=$bg->badge_group_id?>"><?=$bg->name?></option>
												<?php } ?> 
												</select>
											</div>



										</div>
									</div>

									<div class="rewards-catalog-list">


									<?php foreach( $badgeTotal as $badge ) {
											$scale = $badge->getBadgeScalePoints();
										 ?>
										<!-- reward catalog block -->
										<div class="rewards-catalog-block">
											<div class="rewards-catalog-block-extra" title="<?=$scale['scale']->name?>">+<?=$scale['points']?></div>
											<div class="rewards-catalog-block-pic"><img src="<?=$badge->picture?>" alt="" style="max-width: 100%"></div>
											<div class="rewards-catalog-block-text"><?=$badge->name?></div>
											<div class="rewards-catalog-block-people"><span></span> <?=$badge->getAchievedUserCount();?></div>
										</div>
										<!-- . reward catalog block -->
									<? } ?>
										 
									</div>

								</div>
							</div>

						</div>

					</div>


				</div>
			</div>
		</div>
		<!-- . CONTENT END -->