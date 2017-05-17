<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var amnah\yii2\user\models\forms\ResendForm $model
 */

$this->title = Yii::t('user', 'Resend');
$this->params['breadcrumbs'][] = $this->title;
?>


<!-- LOGIN -->
<div class="pregister">
    <div class="wc wc-c">
        <div class="pregister-img"><img src="/template/img/pic-register.png" alt=""></div>
        <h2 class="mdlst-h2">Перевыслать подтверждение регистрации</h2>
        <h3 class="mdlst-h3">Введите свой email</h3>

    <?php if ($flash = Yii::$app->session->getFlash('Resend-success')): ?>

        <div class="alert alert-success">
            <p><?= $flash ?></p>
        </div>

    <?php else: ?>

        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'resend-form']); ?>
                    <?= $form->field($model, 'email') ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('user', 'Submit'), ['class' => 'btn btn-primary']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    <?php endif; ?>
            
            <div class="pregister-socials">
                <p>войти через социальные сети</p>
                <div class="pregister-socials-icons">
                    <div class="pregister-socials-icons-i pregister-socials-icons-i-vk "></div>
                    <div class="pregister-socials-icons-i pregister-socials-icons-i-fb"></div>
                    <div class="pregister-socials-icons-i pregister-socials-icons-i-tw"></div>
                    <div class="pregister-socials-icons-i pregister-socials-icons-i-gp"></div>
                </div>
            </div>

    </div>
</div>
<!-- .LOGIN END-->




<!--
<div class="user-default-resend">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($flash = Yii::$app->session->getFlash('Resend-success')): ?>

        <div class="alert alert-success">
            <p><?= $flash ?></p>
        </div>

    <?php else: ?>

        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'resend-form']); ?>
                    <?= $form->field($model, 'email') ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('user', 'Submit'), ['class' => 'btn btn-primary']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    <?php endif; ?>

</div>
-->