<?php
use yii\helpers\Url;

$currentUrl = Url::current();
 ?>
<!-- menu -->
					<div class="container-col container-col-1">
						<div class="container-menu"   style="margin-bottom: 20px">
							<div class="container-menu-mobile mobile_only">
								<ul class="container-menu-list">
									 
								 
									<li class="container-menu-list-li js-toggle-mobilemenu" >
										<div class="container-menu-list-link"  >Меню</div>
										<div class="container-menu-list-meta"><img src="/template/img/1497314682_menu-24.png" style="padding-right: 17px;padding-top: 11px;"></div>
									</li>
								</ul>
							</div>
							<div class="container-menu-wrapper mobile_menu_toggle">
								<ul class="container-menu-list">
									<!--<li class="container-menu-list-li">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl('personal/dashboard')?>">Дэшборд</a>
										<div class="container-menu-list-meta"></div>
									</li>-->
									<?php   

										if( !Yii::$app->user->isGuest ) {
									 ?> 
									<li class="container-menu-list-li <?php if($currentUrl == Yii::$app->urlManager->createUrl('leaderboard/main') ) {  ?> container-menu-list-li-active <? } ?>">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl('leaderboard/main')?>">Зал славы</a>
										<div class="container-menu-list-meta">
											<div class="container-menu-list-meta-counter"></div>
										</div>
									</li>
									<li class="container-menu-list-li <?php if($currentUrl == Yii::$app->urlManager->createUrl('personal/news') ) {  ?> container-menu-list-li-active <? } ?>">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl('personal/news')?>">Новости</a>
										<div class="container-menu-list-meta">
											<div class="container-menu-list-meta-counter"></div>
										</div>
									</li>
									<li class="container-menu-list-li <?php if($currentUrl == Yii::$app->urlManager->createUrl(['personal/viewprofile', 'user_id' => Yii::$app->user->identity->id]) ) {  ?> container-menu-list-li-active <? } ?>">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl(['personal/viewprofile', 'user_id' => Yii::$app->user->identity->id])?>">Моя страница</a>
										<div class="container-menu-list-meta">
										
										</div>
									</li>
									<li class="container-menu-list-li <?php if($currentUrl == Yii::$app->urlManager->createUrl('personal/achievements') ) {  ?> container-menu-list-li-active <? } ?>">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl('personal/achievements')?>">Достижения</a>
										<div class="container-menu-list-meta">
											<a class="container-menu-list-meta-add" href="<?=Yii::$app->urlManager->createUrl('personal/achievement-add')?>">
												<span class="container-menu-list-meta-add-plus">+</span>
											</a>
										</div>
									</li>
									<li class="container-menu-list-li <?php if($currentUrl == Yii::$app->urlManager->createUrl('personal/goals') ) {  ?> container-menu-list-li-active <? } ?>">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl('personal/goals')?>">Цели</a>
										<div class="container-menu-list-meta">
											<a class="container-menu-list-meta-add" href="<?=Yii::$app->urlManager->createUrl('personal/goal-add')?>">
												<span class="container-menu-list-meta-add-plus">+</span>
											</a>
										</div>
									</li>
									<li class="container-menu-list-li <?php if($currentUrl == Yii::$app->urlManager->createUrl('personal/friends') ) {  ?> container-menu-list-li-active <? } ?>">
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

									<? }else{
										?>
									<li class="container-menu-list-li  <?php if($currentUrl == Yii::$app->urlManager->createUrl('user/login') ) {  ?> container-menu-list-li-active <? } ?>">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl('user/login')?>">Регистрация/авторизация</a>
										<div class="container-menu-list-meta"></div>
									</li>
										<?

									 }?>
									<!--<li class="container-menu-list-li">
										<a class="container-menu-list-link" href="<?=Yii::$app->urlManager->createUrl('personal/development')?>">Моё развитие</a>
										<div class="container-menu-list-meta"></div>
									</li>-->
								</ul>
							</div>
						</div>
					</div>