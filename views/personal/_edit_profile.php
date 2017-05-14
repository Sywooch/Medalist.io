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
			<?php if(false) { ?>
			
			<div class="editprofile-field">
				<div class="editprofile-field-label">Ваш старый пар: </div>
				<div class="editprofile-field-input"><input type="text" name="name"></div>
			</div>
			<? } ?>

			<div class="editprofile-button">
				<? Yii::$app->decor->button('Обновить профиль', '', 'js-updateprofile') ?>
			</div>
		</form>

	</div>