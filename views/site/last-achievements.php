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
            <a class="lastachievement" style="background-image: url(<?=$photo->filename?>); background-size: cover; background-position:  center;">
                <div class="lastachievement-info">
                    <div class="lastachievement-info-pic">
                        <img src="/template/img/">
                    </div>
                    <div class="lastachievement-info-data">
                        <div class="lastachievement-info-data-pic"><?=$u->getProfile()->one()->getAvatarSrc();?></div>
                        <div class="lastachievement-info-data-name"><?=$u->getName();?></div>
                        <div class="lastachievement-info-data-text"><?=$achievement->name;?></div>
                    </div>
                </div>
            </a>
            <?
        }
    ?>
    </div>

</div>