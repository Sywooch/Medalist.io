<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

if ( empty($this->title) ){
    $this->title = 'Medalyst.online - система учёта достижений! Развивайся с нами';

    if (!empty($this->params['og_title'])){
          $this->title = $this->params['og_title'].' - medalyst.online!';
    }
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
     <title><?= Html::encode($this->title) ?></title>


    <?php if(!empty( $this->params['og_title']) ){ ?><meta property="og:title" content="<?=strip_tags($this->params['og_title'])?>" /><? } ?>
    <?php if(!empty( $this->params['og_image']) ){ ?><meta property="og:image" content="<?=$this->params['og_image']?>" /><? } ?>
    <?php if(!empty( $this->params['og_description']) ){ ?><meta property="og:description" content="<?/*=strip_tags($this->params['og_description'])*/?>" /><? } ?>
    <?php if(!empty( $this->params['og_video']) ){ ?><meta property="og:video" content="<?=$this->params['og_video']?>" /><? } ?>
    <?php if(!empty( $this->params['og_url']) ){ ?><meta property="og:url" content="<?=$this->params['og_url']?>" /><? } ?>
    <?php if(!empty( $this->params['og_type']) ){ ?><meta property="og:type" content="<?=$this->params['og_type']?>" /><? } ?>
    
    
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="/template/css/system.css">
    <link rel="stylesheet" href="/template/css/style.css">
    <link rel="stylesheet" href="/template/css/style.768.css">
    <link rel="stylesheet" href="/template/css/style.320.css">
    <link rel="stylesheet" href="/template/js/trumbowyg/dist/ui/trumbowyg.css">
    <link rel="stylesheet" href="/template/js/datepicker/dist/datepicker.css">
    <link rel="stylesheet" href="/template/js/rangeslider/rangeslider.css">
<!--     <link rel="stylesheet" href="/template/css/goals.css">-->
     <link rel="stylesheet" href="/template/js/dropzone/dropzone.css">
     <link rel="stylesheet" href="/template/js/owl/owl.carousel.css">
     <link rel="stylesheet" href="/template/js/fancybox/dist/jquery.fancybox.min.css">

    <script src="/template/js/jquery-3.2.0.min.js"></script>
    <script src="/template/js/datepicker/dist/datepicker.js"></script>
    <script src="/template/js/trumbowyg/dist/trumbowyg.js"></script>
    <script src="/template/js/rangeslider/rangeslider.js"></script>
    <script src="/template/js/dropzone/dropzone.js"></script>
    <script src="/template/js/owl/owl.carousel.min.js"></script>
    <script src="/template/js/fancybox/dist/jquery.fancybox.min.js"></script>
   
    <script type="text/javascript">
        var ajaxUrls = <?php 
            $ajaxUrls = [];
            $ajaxUrls['alarmCheckNew'] = Yii::$app->urlManager->createUrl('alarm/ajax-alarm-check-new');


            $ajaxUrls['getBadgeInfo'] = Yii::$app->urlManager->createUrl('badge/ajax-get-info');

            $ajaxUrls['takeQuest'] = Yii::$app->urlManager->createUrl('quest/ajax-take-quest');
            $ajaxUrls['refuseQuestChallenge'] = Yii::$app->urlManager->createUrl('quest/ajax-refuse-quest-challenge');
            $ajaxUrls['getQuestPendingTaskHtml'] = Yii::$app->urlManager->createUrl('quest/ajax-get-quest-pending-task-html');
            $ajaxUrls['questChallengeSend'] = Yii::$app->urlManager->createUrl('quest/ajax-quest-challenge-send');
            
            $ajaxUrls['addAchievement'] = Yii::$app->urlManager->createUrl('achievement/ajax-add-achievement');
            $ajaxUrls['updateAchievement'] = Yii::$app->urlManager->createUrl('achievement/ajax-update-achievement');


            $ajaxUrls['addGoal'] = Yii::$app->urlManager->createUrl('goal/ajax-add-goal');
            $ajaxUrls['updateGoal'] = Yii::$app->urlManager->createUrl('goal/ajax-update-goal');
            $ajaxUrls['addGoalSubtask'] = Yii::$app->urlManager->createUrl('goal/ajax-add-goal-subtask');
            $ajaxUrls['addGoalSubsubtask'] = Yii::$app->urlManager->createUrl('goal/ajax-add-goal-subsubtask');
            $ajaxUrls['renderGoalSubtaskHTML'] = Yii::$app->urlManager->createUrl('goal/ajax-render-goal-subtask-html');
            $ajaxUrls['calcGoalProgress'] = Yii::$app->urlManager->createUrl('goal/ajax-calc-goal-progress');
            $ajaxUrls['setGoalSubtaskComplete'] = Yii::$app->urlManager->createUrl('goal/ajax-set-goal-subtask-complete');

            $ajaxUrls['addLike'] = Yii::$app->urlManager->createUrl('like/ajax-add-like');
            $ajaxUrls['getLikes'] = Yii::$app->urlManager->createUrl('like/ajax-get-likes');


            $ajaxUrls['addFollower'] = Yii::$app->urlManager->createUrl('follower/ajax-follow');
            $ajaxUrls['removeFollower'] = Yii::$app->urlManager->createUrl('follower/ajax-unfollow');


            $ajaxUrls['addComment'] = Yii::$app->urlManager->createUrl('comment/ajax-add-comment');
            $ajaxUrls['getCommentHtml'] = Yii::$app->urlManager->createUrl('comment/ajax-get-comment-html');

            $ajaxUrls['shareTrack'] = Yii::$app->urlManager->createUrl('site/ajax-share-track');
            echo json_encode( $ajaxUrls );
        ?>     
        var isGuest =  <?=(int)Yii::$app->user->isGuest?> ;
    </script>
    <script src="/template/js/eventengine.js"></script>
    <script src="/template/js/main.js"></script>
    <script src="/template/js/goals.js"></script>
    <script src="/template/js/followers.js"></script>
  </head>

  <body>
    <?php $this->beginBody() ?>

    <!-- HEADER -->

<!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter45078730 = new Ya.Metrika({ id:45078730, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/45078730" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->

    <header class="header" id="header">
        <div class="wc header-wrapper">
            <div class="header-logo"><a href="<?=Yii::$app->urlManager->createUrl(['site/index' ])?>"><img src="/template/img/logo-white.png"></a> </div>
            <nav class="header-menu">
                <ul class="header-menu-list">
                    <li class="header-menu-list-li"><a href="<?=Yii::$app->urlManager->createUrl(['site/last-achievements' ])?>" class="header-menu-list-li-a">Последние достижения</a></li>
                    <li class="header-menu-list-li"><a href="<?=Yii::$app->urlManager->createUrl(['site/howitworks' ])?>" class="header-menu-list-li-a">Как это работает</a></li>
                    <li class="header-menu-list-li"><a href="<?=Yii::$app->urlManager->createUrl(['site/successstories' ])?>" class="header-menu-list-li-a">Истории успеха</a></li>
                </ul>
            </nav>
            <div class="header-enter">
            <?php if( Yii::$app->user->isGuest ) {  ?>
                <a class="header-enter-link" href="<?=Yii::$app->urlManager->createUrl('user/register')?>">Регистрация</a>
                <a class="header-enter-button mdlst-button" href="<?=Yii::$app->urlManager->createUrl('user/login')?>">Войти</a>
                <?php }else{ ?>
                <a class="header-enter-link" href="<?=Yii::$app->urlManager->createUrl('user/logout')?>">Выход</a>
                <a class="header-enter-button mdlst-button" href="<?=Yii::$app->urlManager->createUrl('personal/rewards')?>">Ваш профиль</a>
                <? } ?>
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

<!-- reward popup -->
    <div class="rewardpopup" style="display: none;">
        <div class="rewardpopup-bg"></div>
        <div class="rewardpopup-form">
            <div class="rewardpopup-form-text">
                Вы написали какой-то адский модуль или программу? Покажите её нам!  Уверены, многие программисты оценят ваши стремления. Что она делает и зачем? Не понятно... Но вы старались, и вот ваша награда!
            </div>
            
            <div class="rewardpopup-form-pic"><img src="/template/img/reward/reward-01.png" alt="" class="rewardpopup-form-pic-img"></div>
            <div class="rewardpopup-form-btn-wrapper"><a class="rewardpopup-form-goto-reward rewardpopup-form-btn mdlst-button" href="<?=Yii::$app->urlManager->createUrl('personal/rewards')?>">+20 к  достижению</a></div>

            <!-- todo socials -->
        </div>
    </div>
    <!-- reward popup end-->



    <?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>