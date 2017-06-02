<?php
use yii\helpers\Url;

$currentUrl = Url::current();
 ?>


<!-- menu -->
	<div class="editprofile">
		<form class="editprofile-form" enctype="multipart/form-data" method="post" action="">
			<input type="hidden" value="<?=Yii::$app->request->getCsrfToken()?>" placeholder="email" name="_csrf">

			<div class="editprofile-field">
				<div class="editprofile-field-label">Фотография: </div>
				<div class="editprofile-field-input"><input type="file" name="image"></div>
			</div>
			<div class="editprofile-field">
				<div class="editprofile-field-label">Ваше имя: </div>
				<div class="editprofile-field-input"><input type="text" name="name" value="<?=$user->getName();?>"></div>
			</div>
			<div class="mdlst-hr"></div>
		 
		 
			<div class="editprofile-field">
				<div class="editprofile-field-label">Ваш новый пароль: </div>
				<div class="editprofile-field-input"><input type="password" name="password"></div>
			</div>
			
			<div class="editprofile-field">
				<div class="editprofile-field-label">Подтверждение: </div>
				<div class="editprofile-field-input"><input type="password" name="password_confirm"></div>
			</div>
			 

			<div class="editprofile-button">
				<? Yii::$app->decor->button('Обновить профиль', '', 'js-updateprofile') ?>
			</div>
		</form>

	</div>