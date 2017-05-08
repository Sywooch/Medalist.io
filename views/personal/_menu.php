<?php
use yii\helpers\Url;

$currentUrl = Url::current();
 ?>
<!-- menu -->
					<div class="container-col container-col-1">
						<div class="container-menu">
							<div class="container-menu-mobile"></div>
							<div class="container-menu-wrapper">
								<ul class="container-menu-list">
									<li class="container-menu-list-li">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl('personal/dashboard')?>">Дэшборд</a>
										<div class="container-menu-list-meta"></div>
									</li>
									<li class="container-menu-list-li">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl('personal/news')?>">Новости</a>
										<div class="container-menu-list-meta">
											<div class="container-menu-list-meta-counter"></div>
										</div>
									</li>
									<li class="container-menu-list-li">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl('personal/profile')?>">Моя страница</a>
										<div class="container-menu-list-meta">
										
										</div>
									</li>
									<li class="container-menu-list-li">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl('personal/achievements')?>">Достижения</a>
										<div class="container-menu-list-meta">
											<a class="container-menu-list-meta-add" href="<?=Yii::$app->urlManager->createUrl('personal/achievement-add')?>">
												<span class="container-menu-list-meta-add-plus">+</span>
											</a>
										</div>
									</li>
									<li class="container-menu-list-li">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl('personal/goals')?>">Цели</a>
										<div class="container-menu-list-meta">
											<a class="container-menu-list-meta-add" href="<?=Yii::$app->urlManager->createUrl('personal/goal-add')?>">
												<span class="container-menu-list-meta-add-plus">+</span>
											</a>
										</div>
									</li>
									<li class="container-menu-list-li">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl('personal/friends')?>">Мои друзья</a>
										<div class="container-menu-list-meta"></div>
									</li>
									<li class="container-menu-list-li <?php if($currentUrl == Yii::$app->urlManager->createUrl('personal/quests') ) {  ?> container-menu-list-li-active <? } ?>">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl('personal/quests')?>">Квесты</a>
										<div class="container-menu-list-meta"></div>
									</li>
									<li class="container-menu-list-li  <?php if($currentUrl == Yii::$app->urlManager->createUrl('personal/rewards') ) {  ?> container-menu-list-li-active <? } ?>">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl('personal/rewards')?>">Награды</a>
										<div class="container-menu-list-meta"></div>
									</li>
									<li class="container-menu-list-li">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl('personal/development')?>">Моё развитие</a>
										<div class="container-menu-list-meta"></div>
									</li>
								</ul>
							</div>
						</div>
					</div>