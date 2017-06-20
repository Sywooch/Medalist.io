<?php

/* @var $this yii\web\View */
 
$this->title = 'Медалист. Система хранения достижений, выполнения квестов и формирования рейтингов.';
?>


<div class="pregister">
    <div class="wc page">
        <h1 class="page-h1">Новые достижения</h1>

	<h2 class="page-h2">Докажи, что сможешь лучше!</h2>


    <div class="lastachievement-wrapper">

    <?php
        foreach($achievements as $achievement){
            $u = $achievement->getUser();
            $photo = $achievement->getPhotos()[0];
		$photos = $achievement->getPhotos();
		if(!empty($photos) ) { 
			$thumbs = Yii::$app->decor->getThumbnails($photos);
		}

            ?>
            <a class="lastachievement" style="background-image: url(<?=$thumbs[0]; /*$photo->filename*/?>); background-size: cover; /*background-position:  center top;*/" href="<?=Yii::$app->urlManager->createUrl( ['personal/achievement','achievement_id' => $achievement->achievement_id])?>">
                <div class="lastachievement-info">
                   
                    <div class="lastachievement-info-data">
                        <div class="lastachievement-info-data-pic" style="background-image: url(<?=$u->getProfile()->one()->getAvatarSrc();?>)"></div>
                        <div class="lastachievement-info-data-data" >
                            <div class="lastachievement-info-data-name"><?=$u->getName();?></div>
 			<div class="achievement-block-content-info-date" style="margin-bottom:10px;"><?=date( 'd.m.Y' ,  strtotime($achievement->date_achieved))?></div>
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
</div>