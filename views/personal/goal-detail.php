<?php
/* @var $this yii\web\View */
use app\models\Like;
use app\models\Goal;

echo $this->render('_panel.php');
?>
<link rel="stylesheet" href="/template/css/goals.css">
<!-- CONTENT -->
<div class="container">
    <div class="wc">
        <div class="container-cols">
            <?= $this->render("_menu.php") ?>
            <!-- container-content -->
            <div class="container-col container-col-2">
                <!-- Цель детально-->
                <div class="output">
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
                            <div class="mygoals-name-button"><a class="goal-done-button mdlst-button" href="#">Выполнить
                                    цель</a></div>
                        </div>
                        <div class="clear"></div>
                        <div class="mygoals-stats-div">
                            <div class="mygoals-left-wrapper">
                                <span class="mygoals-diff">Сложность</span>

                                <div class="mygoals-stars">
                                    <?
                                    for ($n = 1; $n <= $goal->difficulty; $n++) {
                                        echo '<div class="mygoals-star star-yellow"></div>';
                                    }
                                    for ($n = $goal->difficulty; $n < 3; $n++) {
                                        echo '<div class="mygoals-star star-grey"></div>';
                                    }

                                    ?>
                                </div>
                                <span class="mygoals-dead">Дедлайн</span>
                                <span
                                    class="mygoals-dead color-red"><? echo date("Y.m.d", strtotime($goal->deadline)) ?></span>

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
                            <div class="mygoals-edit-button"><a class="goal-edit-button mdlst-button" href="#">Редактировать</a>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="goals-pictures">
                            <div class="goals-picture-big"><img src="uploads<?= $goal->getPhotos()[0]->filename ?>"
                                                                alt=""/></div>
                            <div class="goals-pictures-small">

                                <? $Photos = $goal->getPhotos();
                                for ($n = 1; $n < count($Photos); $n++) {
                                    echo '<div class="goals-picture-small"><img src="uploads' . $Photos[$n]->filename . '" alt=""/></div>';
                                }
                                ?>

                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="goals-description marginBottom30 marginTop30">
                            <?= $goal->description ?>
                        </div>
                        <div class="questblock-info-controlls">
                            <div class="questblock-info-controlls-likes">
                                <div class="like-controll">
                                    <div class="like-controll-plus like-controll-active">
                                        <span></span><?= Like::getLikesOfObjectCount($goal) ?></div>
                                    <div class="like-controll-minus">
                                        <span></span><?= Like::getDislikesOfObjectCount($goal) ?></div>
                                </div>
                            </div>
                            <div class="questblock-info-controlls-comments">
                                <div class="comment-controll"><span></span><?= count($goal->getComments()) ?></div>
                            </div>
                        </div>
                        <div class="tabs-container marginTop30">
                            <div class="tabs">
                                <ul class="tabs-ul">
                                    <li class="tabs-li">
                                        <input type="radio" name="tabs-0" checked="checked" id="tabs-0-0"/>
                                        <label for="tabs-0-0">Список подзадач</label>
                                        <div>
                                            <? $subtasks = Goal::getSubtasksById($goal->goal_id);
                                            $g = "ListbGoal" . $goal->goal_id;
                                            $is_subtasks = count($subtasks) > 0; ?>

                                            <? if ($is_subtasks){ ?>
                                            <div>
                                                <ul class="goal-subtask">
                                                    <? } ?>

                                                    <? foreach ($subtasks as $subtask){
                                                    $s = $g . "s" . $subtask->goal_subtask_id;
                                                    ?>
                                                    <li class="subtask-container">
                                                        <div class="subtask-top">
                                                            <div
                                                                class="subtask-top-left <?= $subtask->completed ? 'subtask-done' : ''; ?>">
                                                                <div class="input-check">
                                                                    <input <?= $subtask->completed ? 'checked = "checked"' : ''; ?>
                                                                        type="checkbox" id="<?= $s; ?>"
                                                                        name="<?= $s; ?>" value="<?= $s; ?>"/>
                                                                    <label for="<?= $s; ?>"
                                                                           class="subtask-top-name">1. <?= $subtask->name ?></label>
                                                                </div>
                                                                <div class="subtask-progress">
                                                                    <div
                                                                        class="interests-selector-scale-viewport userpanel-info-scale-scale subtask-progress-height">
                                                                        <div
                                                                            class="interests-selector-scale-track subtask-progress-height"
                                                                            style="margin-left: -<?= 100 - $subtask->getProgressPercent() ?>%;"></div>
                                                                    </div>
                                                                </div>
                                                                <span
                                                                    class="mygoals-dead color-red subtask-top-dead"><? echo date("Y.m.d", strtotime($subtask->deadline)) ?></span>
                                                            </div>
                                                            <a class="container-menu-list-meta-add margin-0" href="#">
                                                                <span class="container-menu-list-meta-add-plus">+</span>
                                                            </a>
                                                        </div>
                                                        <div class="subtask-bottom">
                                                            <?= $subtask->description ?>
                                                        </div>

                                                        <? $subtasks_points = $subtask->getSubtasks();
                                                        $is_subtask_points = count($subtasks) > 0; ?>

                                                        <? if ($is_subtask_points){ ?>
                                                        <ul class="subtask-points">
                                                            <? } ?>

                                                            <? foreach ($subtasks_points as $subtask_point) {
                                                                $p = $s . "p" . $subtask_point->goal_subtask_id;
                                                                ?>


                                                                <li>
                                                                    <div
                                                                        class="input-check <?= $subtask_point->completed ? 'subtask-done' : ''; ?>">
                                                                        <input <?= $subtask_point->completed ? 'checked = "checked"' : ''; ?>
                                                                            type="checkbox" id="<?= $p ?>"
                                                                            name="<?= $p ?>" value="<?= $p ?>"/>
                                                                        <label for="<?= $p ?>" class="subtask-top-name">1. <?= $subtask_point->name ?></label>
                                                                    </div>
                                                                    <div class="clear"></div>
                                                                </li>
                                                            <? } ?>

                                                            <? if ($is_subtask_points){ ?>
                                                        </ul>
                                                    <? } ?>

                                                        <? } ?>


                                            </div>

                                    </li>
                                    <li class="tabs-li">
                                        <input type="radio" name="tabs-0" id="tabs-0-1"/>
                                        <label for="tabs-0-1">Новости цели</label>

                                        <div>
                                            <p>Какой-то контент
                                            </p>
                                        </div>
                                    </li>
                                </ul>
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