<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var bool $success
 * @var string $email
 */

 
?>

<!-- REGISTRATION -->
            <div class="pregister-interests">
                <div class="wc wc-c">
                    <input type="hidden" name="childInterestsUrl" value="<?=Yii::$app->urlManager->createUrl('user/ajax-more-interests')?>">

                    <div class="pregister-img-interests"><img src="/template/img/interests-hello.png" alt=""></div>
                    <div class="h-interests-before-reward">
                        <h2 class="mdlst-h2">Выберите 7 наиболее<br>интересных вещей для вас</h2>
                        <h3 class="mdlst-h3">Попробуйте заполнить шкалу полностью, добавляя интересы.<br>Мы лучше поймём, что вам интересно, а вы получите приветственную награду.</h3>
                         <div class="interests-selector">
                         <?php foreach($interests as $int ) { ?>
                            <div class="interests-button mdlst-button js-interest-selector-takeinterest" data-id="<?=$int->interest_id?>"><?=$int->name;?></div>
                        <? } ?>
                           
                         </div>
                         <div class="mdlst-hr"></div>
                     </div>

                     <div  class="h-interests-after-reward" style="display: none;">
                     <h2 class="mdlst-h2">Вы получили награду!</h2>
                    <h3 class="mdlst-h3">Вы не стеснялись говорить о себе и получили +5 баллов социальности.</h3>
                    <div class="pregister-reward"> <img src="/template/img/reward/reward-01.png" alt=""></div>
                    </div>

                     <div class="interests-selector-selected">
                        
                     </div> 
                     <div class="interests-selector-scale">
                        <div class="interests-selector-scale-viewport">
                            <div class="interests-selector-scale-track"></div>
                        </div>
                     </div>
                     <a href="#" class="mdlst-button mdlst-button-accent">Перейти в личный кабинет</a>
                </div>
            </div>
 
        <!-- .REGISTRATION END-->