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
							 <?php
/* @var $this yii\web\View */
?>

							<!-- ADDING ACHIEVEMENT -->
							<?=$this->render('_icons.php') ?>
		 					<div class="addach">
		 						<form action="" name="addach" class="addgoal-form">
									<input type="hidden" value="<?=Yii::$app->request->getCsrfToken()?>" placeholder="email" name="_csrf">
									<?php if($difficult ) { ?><input type="hidden" value="1" placeholder="" name="difficult"><?} ?>

			 						<div class="addach-header">
			 							<div class="addach-header-inp-w">
			 								<input type="text" name="name" class="addach-header-inp" placeholder="Какая у вас цель?" value="<?=$predefinedTitle?>">
			 							</div>


			 							<?php Yii::$app->decor->controllSwitch('private', 'Приватная цель', 'addach-header-isdifficult', $difficult);?>
			 						</div>

			 						<div class="addach-description">
			 							<div class="addach-description-text">
			 								<textarea name="description" id="description" data-toggle="trumbowyg" cols="30" rows="10" class="addach-description-text-textarea"><?=$predefinedText?></textarea>
			 							</div>
			 							<div class="addach-description-date">Крайний срок до достижениея: <span class="addach-description-date-icon"></span><input data-toggle="datepicker" class="addach-description-date-date mdlst-input-small" name="deadline"></div>
			 							<div class="addach-description-photos" data-toggle="dropzone">
			 								<a class="container-menu-list-meta-add addach-description-photos-icon" href="#">
												<span class="container-menu-list-meta-add-plus">+</span>
											</a>
											<div class="addach-description-photos-text">Перетащите сюда фотографии (до 3Мб)</div>
			 							</div>
			 						</div>



			 						<div class="addach-tags">
			 							<div class="addach-tags-title">Теги:</div>
			 							<div class="addach-tags-w">
			 								<input type="text" class="addach-tags-inp js-tag-adder">
			 							 
			 								 
			 							</div>
			 						</div>




			 						<div class="addach-extra ">
			 							<div class="addach-extra-range">
			 								<div class="addach-extra-range-text">Насколько это сложно?</div>
			 								<div class="addach-extra-range-range"> <input type="range" data-toggle="rangeslider"  data-rangeslider min="1" max="100" step="1" value="50" name="difficulty"></div>
			 							</div>
			 							 
			 						</div>




										
									<!-- add achievement  CONTROLLS -->
			 						<div class="addach-controlls">
			 							 
			 							<div class="addach-controlls-send">
			 								<button class="mdlst-button  mdlst-button-default js-add-goal">Добавить цель</button>
			 							</div>
			 						</div>
			 						<!-- add achievement CONTROLLS end -->
 




		 						</form>
		 					</div>

		 					<div class="addach-success" style="display: none;">
		 					 	<? Yii::$app->decor->infoPanel('Вы успешно добавили цель! Посмотрите его в <a href="'.Yii::$app->urlManager->createUrl('personal/goals').'">вашем списке целей!', 'success'); ?>
		 						
		 					</div>

		 					<!-- . ADDING ACHIEVEMENT END -->

						</div>

					</div>


				</div>
			</div>
		</div>
		<!-- . CONTENT END -->