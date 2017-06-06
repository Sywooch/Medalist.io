<?php
/* @var $this yii\web\View */
use app\models\Like;
use app\models\Comment;
use app\models\Goal;

echo $this->render('_panel.php');



if( Yii::$app->user->isGuest ){
    $myGoal = false;
}else{
    $myGoal = (Yii::$app->user->identity->id == $goal->user_id);
}


?>
<!-- CONTENT -->
<div class="container">
    <div class="wc">
        <div class="container-cols">
            <?= $this->render("_menu.php") ?>
            <!-- container-content -->
            <div class="container-col container-col-2">
                <!-- Цель детально-->
                <div class="output">
                <div class="simplebox simplebox-padding">
                    <div class="output-header">
                        <h2 class="mdlst-h2t-goals">Цель</h2>
                        <div class="output-header-meta-goals">
                            <?
                            if ($goal->active) {
                                echo '
                     <div class="mygoals-clock"><img src="/template/img/goals/clock.png" alt=""></div>
                     <span class="mygoals-process">В процессе</span>';
                            } ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="output-content">
                        <div class="mygoals-name-div">
                            <div class="mygoals-name"><?= $goal->name ?></div>
                            <?php if( $myGoal ) {?><div class="mygoals-name-button"><a class="goal-done-button mdlst-button" href="<?=Yii::$app->urlManager->createUrl(['personal/achievement-add', 'goal_id'=> $goal->goal_id ])?>">Выполнить
                                    цель</a></div><? } ?>
                        </div>
                        <div class="clear"></div>
                        <div class="mygoals-stats-div">
                            <div class="mygoals-left-wrapper">
                                <span class="mygoals-diff">Сложность</span>

                                <div class="mygoals-stars">
                                    <?
                                     $difficulty = round( ($goal->difficulty / 100) * 3 );
                                    for ($n = 1; $n <= $difficulty; $n++) {
                                        echo '<div class="mygoals-star star-yellow"></div>';
                                    }
                                    for ($n = $difficulty; $n < 3; $n++) {
                                        echo '<div class="mygoals-star star-grey"></div>';
                                    }

                                    ?>
                                </div>
                                <?php if(!empty($goal->deadline) ) { ?>
                                <span class="mygoals-dead">Дедлайн</span>
                                <span
                                    class="mygoals-dead <?php if( strtotime($goal->deadline) < time() ) { ?>color-red <?php } ?>"><? echo date("d.m.Y", strtotime($goal->deadline)) ?></span>
                                    <? } ?>

                                <?
                                if ($goal->private) {
                                    echo '
                                 		<div class="mygoals-lock"><img src="/template/img/goals/lock.png" alt=""/></div>
                                 		 <span class="mygoals-privat">Приватная</span>';
                                } ?>


                                <div class="mygoals-progress">
                                    <div class="interests-selector-scale-viewport userpanel-info-scale-scale">
                                        <div class="interests-selector-scale-track"
                                             style="margin-left: -<?= 100 - $goal->getProgressPercent() ?>%;"></div>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="mygoals-edit-button"><a class="goal-edit-button mdlst-button" href="#">Редактировать</a></div>-->
                        </div>
                        <div class="clear"></div>


                        <?php if(!empty($goal->getPhotos()) ) { ?>
                        <div class="goals-pictures">
                            <a class="goals-picture-big"   data-fancybox="group"  href="<?=$goal->getPhotos()[0]->filename?>" <?php if(!empty($goal->getPhotos()[0]) ) { ?> style = "background-image: url(<?=$goal->getPhotos()[0]->filename?>);"<? } ?>></a>

                            <div class="goals-pictures-small">

                                <? $Photos = $goal->getPhotos();
                                for ($n = 1; $n < count($Photos); $n++) {?>
	                            <a class="goals-picture-small" data-fancybox="group"  style = "background-image: url(<?=$Photos[$n]->filename?>);" href="<?=$Photos[$n]->filename?>"></a>
                                <? }
                                ?>

                            </div>
                        </div>
                        <? } ?>

                        <div class="clear"></div>
                        <div class="goals-description marginBottom30 marginTop30">
                            <?= $goal->description ?>
                        </div>


                        <?php if( $goal->private != 1) { ?>
                            <div class="goal-share"><? Yii::$app->decor->shareWidget(); ?></div>
                        <? }?>


                        <div class="questblock-info-controlls">
                            <div class="questblock-info-controlls-likes">
                                 <?=Yii::$app->like->renderWidget($goal);?>
                            </div>
                            <div class="questblock-info-controlls-comments">
                                <?=Yii::$app->comment->renderCommentCount( count(Comment::getCommentsOfObject($goal)->all() ), 'goal-comments-'.$goal->goal_id );?>
                            </div>
                        </div>
                        <div class="tabs-container marginTop30">
                            <div class="tabs">
                                <ul class="tabs-ul">
                                    <li class="tabs-li">
                                        <input type="radio" name="tabs-0" checked="checked" id="tabs-0-0"/>
                                        <label for="tabs-0-0">Список подзадач</label>





                                        <div  style="padding: 25px">





                                        <!-- widget add subgoal -->
                           
                                        <?php if( $myGoal ) {?>
                                        <?=$this->render('_goal_subtask_add.php', ['goal' => $goal]);?>
                                        <? } ?>
                                        <hr>
                                        <!-- widget add subgoal task -->


                                        


                                            <? $subtasks = Goal::getSubtasksById($goal->goal_id);
                                            $g = "ListbGoal" . $goal->goal_id;
                                            $is_subtasks = count($subtasks) > 0; ?>

                                          
                                            <div>
                                                <ul class="goal-subtask">
                                                

                                                    <? foreach ($subtasks as $i => $subtask){

                                                        
                                                    $s = $g . "s" . $subtask->goal_subtask_id;
                                                    ?>
                                                    <li class="subtask-container">
                                                        <div class="subtask-top">
                                                            <div
                                                                class="subtask-top-left <?= $subtask->completed ? 'subtask-done' : ''; ?>  <?php if( $myGoal ) {?>js-set-subtask-complete<? }?>" data-goal_subtask_id="<?=$subtask->goal_subtask_id?>" data-goal_id="<?=$subtask->goal_id?>">

                                                                 <?php if( $myGoal ) {?>
                                                                 <div class="input-check">
                                                                    <input <?= $subtask->completed ? 'checked = "checked"' : ''; ?>
                                                                        type="checkbox" id="<?= $s; ?>"
                                                                        name="<?= $s; ?>" value="<?= $s; ?>"/>
                                                                    <label for="<?= $s; ?>"
                                                                           class="subtask-top-name"><?=($i+1)?>. <?= $subtask->name ?></label>
                                                                </div>
                                                                <? }else { 
                                                                    ?>
                                                                <div class="input-check">
                                                                   
                                                                    <label  class="subtask-top-name"><?=($i+1)?>. <?= $subtask->name ?></label>
                                                                </div>
                                                                    <?
                                                                    }?>

                                                                <div class="subtask-progress">
                                                                    <div
                                                                        class="interests-selector-scale-viewport userpanel-info-scale-scale subtask-progress-height">
                                                                        <div
                                                                            class="interests-selector-scale-track subtask-progress-height"
                                                                            style="margin-left: -<?= 100 - $subtask->getProgressPercent() ?>%;"></div>
                                                                    </div>
                                                                </div>
                                                                <span
                                                                    class="mygoals-dead <?php if( strtotime($subtask->deadline) < time() ) { ?>color-red <?php } ?> subtask-top-dead"><? if( !empty($subtask->deadline) ) { echo date("d.m.Y", strtotime($subtask->deadline)); } ?></span>
                                                            </div>
                                                           
                                                           <? // Yii::$app->decor->plus('','js-add-subsubtask'); ?>

                                                        </div>
                                                        <div class="subtask-bottom">
                                                            <?= $subtask->description ?>
                                                        </div>

                                                        <? $subtasks_points = $subtask->getSubtasks();
                                                        $is_subtask_points = count($subtasks) > 0; ?>


                                                        <!-- SUBTASK POINTS -->
                                                        <? if ($is_subtask_points){ ?>
                                                        <ul class="subtask-points">
                                                            <? } ?>

                                                            <? foreach ($subtasks_points as  $j => $subtask_point) {
                                                                $p = $s . "p" . $subtask_point->goal_subtask_id;

                                                                ?>


                                                                <li>
                                                                    <div
                                                                        class="input-check <?= $subtask_point->completed ? 'subtask-done' : ''; ?>">
                                                                       <?php if( $myGoal ) {?> <input <?= $subtask_point->completed ? 'checked = "checked"' : ''; ?>
                                                                            type="checkbox" id="<?= $p ?>"
                                                                            name="<?= $p ?>" value="<?= $p ?>"/> <? } ?>
                                                                        <label for="<?= $p ?>" class="subtask-top-name"><?=($j+1)?>. <?= $subtask_point->name ?></label>
                                                                    </div>
                                                                    <div class="clear"></div>
                                                                </li>
                                                            <? } ?>

                                                            <? if ($is_subtask_points){ ?>
                                                        </ul>
                                                    <? } ?>

                                                    <!-- SUBTASK POINTS END -->
                                                </li>
                                            <? } ?>

                                        </ul>

                                       

                                 
                                     </div>
                                    <!--<li class="tabs-li">
                                        <input type="radio" name="tabs-0" id="tabs-0-1"/>
                                        <label for="tabs-0-1">Новости цели</label>

                                        <div>
                                            
                                        </div>
                                    </li>-->
                                    <li class="tabs-li">
                                        <input type="radio" name="tabs-0" id="tabs-0-2"/>
                                        <label for="tabs-0-2">Комментарии</label>

                                        <div>
                                            <div class="goal-comments-block goal-comments-<?=$goal->goal_id?>  comments-widget" data-obj="Goal" data-id="<?=$goal->goal_id?>" >
                                                <div class="questblock-comments-form"><?=Yii::$app->comment->renderResponseForm( $goal  );?></div>
                                                <div class="questblock-comments-form-wrapper"><?=Yii::$app->comment->renderCommentFeed( $goal, 0, 10 );?></div>
                                            </div>
                                           
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <!-- Цель детально-->
            </div>
        </div>
    </div>
</div>

<!-- . CONTENT END -->