<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
     <title><?= Html::encode($this->title) ?></title>
    
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="/template/css/system.css">
    <link rel="stylesheet" href="/template/css/style.css">
    <script src="/template/js/jquery-3.2.0.min.js"></script>
    <script src="/template/js/main.js"></script>
  </head>

  <body>
    <?php $this->beginBody() ?>
    <!-- HEADER -->
    <header class="header" id="header">
        <div class="wc header-wrapper">
            <div class="header-logo"><img src="/template/img/logo-white.png"> </div>
            <nav class="header-menu">
                <ul class="header-menu-list">
                    <li class="header-menu-list-li"><a href="#" class="header-menu-list-li-a">Последние достижения</a></li>
                    <li class="header-menu-list-li"><a href="#" class="header-menu-list-li-a">Как это работает</a></li>
                    <li class="header-menu-list-li"><a href="#" class="header-menu-list-li-a">Истории успеха</a></li>
                </ul>
            </nav>
            <div class="header-enter">
                <a class="header-enter-link" href="#">Регистрация</a>
                <a class="header-enter-button mdlst-button" href="#">Войти</a>
            </div>
        </div>

    </header>
    <!-- .HEADER END -->

    <div id="content" class="content  <?php if( !empty($this->params['wrapperExtraClass']) ) { echo $this->params['wrapperExtraClass']; } ?>">
        <?= $content ?>
    </div>
    <footer id="footer" class="footer">
        <div class="footer-wrapper">
            <div class="wc">
                <div class="footer-copy">@Medalyst, 2017</div>
                <div class="footer-menu">
                    <ul class="footer-menu-list">
                        <li class="footer-menu-list-li"><a href="#" class="footer-menu-list-li-a">Политика</a></li>
                        <li class="footer-menu-list-li"><a href="#" class="footer-menu-list-li-a">Обратная связь</a></li>
                        <li class="footer-menu-list-li"><a href="#" class="footer-menu-list-li-a">Публичная оферта</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>