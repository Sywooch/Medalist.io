<?php

/* @var $this yii\web\View */
 
$this->title = 'Медалист. Система хранения достижений, выполнения квестов и формирования рейтингов.';
?>


<div class="wc page">
    <div class="output-header">
        <div class="mygoals-name-div">
            <h2 class="mdlst-h2t-goals withButton">Последние достижения!</h2>
      
            <div class="clear"></div>
        </div>
    </div>
    <p>Вы сможете лучше!</p>
    <div class="lastachievement-wrapper">
    <?php
        foreach($achievements as $achievement){
            $u = $achievement->getUser();
            $photo = $achievement->getPhotos()[0];
            ?>
            <a class="lastachievement" style="background-image: url(<?=$photo->filename?>); background-size: cover; background-position:  center;" href="<?=Yii::$app->urlManager->createUrl( ['personal/achievement','achievement_id' => $achievement->achievement_id])?>">
                <div class="lastachievement-info">
                   
                    <div class="lastachievement-info-data">
                        <div class="lastachievement-info-data-pic" style="background-image: url(<?=$u->getProfile()->one()->getAvatarSrc();?>)"></div>
                        <div class="lastachievement-info-data-data" >
                            <div class="lastachievement-info-data-name"><?=$u->getName();?></div>
                            <div class="lastachievement-info-data-text"><?=$achievement->name;?></div>
                        </div>
                    </div>
                </div>
            </a>
            <?
        }
    ?>
    </div>

</div>