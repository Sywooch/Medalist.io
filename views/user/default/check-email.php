<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\User $profile
 * @var string $userDisplayName
 */

$module = $this->context->module;

$this->title = Yii::t('user', 'Register');
$this->params['breadcrumbs'][] = $this->title;
?>

    <!-- REGISTRATION -->
            <div class="pregister-checkemail">
                <div class="wc wc-c">
                    <div class="pregister-img"><img src="/template/img/postman.png" alt=""></div>
                    <h2 class="mdlst-h2">Первый шаг сделан</h2>
                    <h3 class="mdlst-h3">Письмо с кодом активации отправлено на указанную электронную почту.</h3>
                     
                </div>
            </div>
 
        <!-- .REGISTRATION END-->
 