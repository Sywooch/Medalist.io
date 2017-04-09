<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var bool $success
 * @var string $email
 */

$this->title = Yii::t('user', $success ? 'Confirmed' : 'Error');
?>
<?php if ($success || !Yii::$app->user->isGuest ): ?>
<!-- REGISTRATION -->
        <div class="pregister pregister-chooseemail">
            <div class="wc wc-c">
                <h2 class="mdlst-h2">Email подтвержден</h2>
                <h3 class="mdlst-h3">Придумайте пароль для учетной записи Medalist</h3>
                <form action="<?=Yii::$app->urlManager->createUrl('user/ajax-change-password')?>" class="pregister-form">
                    <input type="password" class="mdlst-input" placeholder="" name="password">
                    <input type="hidden" value="<?=Yii::$app->request->getCsrfToken()?>" placeholder="email" name="_csrf">
                    <input type="hidden" value="<?=Yii::$app->urlManager->createUrl('user/interests')?>" placeholder="email" name="successUrl">
                    <div class="pregister-button-wrapper"><button class="mdlst-button mdlst-button-default js-set-password">Сохранить и войти в Medalist</button></div>
                    
                     
                </form>
            </div>
        </div>
        <!-- .REGISTRATION END-->
<?php else: ?>

    <div class="alert alert-danger"><?= Yii::t("user", "Invalid token") ?></div>

<?php endif; ?>

<div class="user-default-confirm">

    <?php if ($success): ?>

        <div class="alert alert-success">

            <p><?= Yii::t("user", "Your email [ {email} ] has been confirmed", ["email" => $email]) ?></p>

            <?php if (Yii::$app->user->isLoggedIn): ?>

                <p><?= Html::a(Yii::t("user", "Go to my account"), ["/user/account"]) ?></p>
                <p><?= Html::a(Yii::t("user", "Go home"), Yii::$app->getHomeUrl()) ?></p>

            <?php else: ?>

                <p><?= Html::a(Yii::t("user", "Log in here"), ["/user/login"]) ?></p>

            <?php endif; ?>

        </div>

    <?php elseif ($email): ?>

        <div class="alert alert-danger">[ <?= $email ?> ] <?= Yii::t("user", "Email is already active") ?></div>

    <?php else: ?>

        <div class="alert alert-danger"><?= Yii::t("user", "Invalid token") ?></div>

    <?php endif; ?>

</div>