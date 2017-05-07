<?php
/* @var $this yii\web\View */
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
                <!-- Списко целей-->
                <div class="output">
                    <div class="output-header">
                        <div class="mygoals-name-div">
                            <h2 class="mdlst-h2t-goals withButton">Мои цели (<?= count($goals) ?>)</h2>
                            <a class="goal-done-button mdlst-button withHeader" href="<?= Yii::$app->urlManager->createUrl('personal/goal-add') ?>">+ Добавить новую цель</a>

                            <div class="clear"></div>
                        </div>
                    </div>


                <?php if( !empty($goals) ) { ?>

                    <?php foreach ($goals as $goal) {
                        $g = "ListbGoal" . $goal->goal_id;
                        ?>




                        <div class="goal-content">
                            <div class="mygoals-name-div">
                                <div class="input-check withList">
                                    <input <?= $goal->completed ? 'checked = "checked"' : ''; ?> type="checkbox"
                                                                                                 id="<?= $g; ?>"
                                                                                                 name="<?= $g; ?>"
                                                                                                 value="<?= $g; ?>"/>
                                    <label for="<?= $g; ?>" class="subtask-top-name" id="mygoals-name">
                                        <a class="mygoals-block"
                                           href="<?= Yii::$app->urlManager->createUrl(['personal/goal', 'goal_id' => $goal->goal_id]) ?>">
                                            <?= $goal->name ?>
                                        </a>

                                    </label>
                                </div>
                                <div class=""></div>
                            </div>
                            <div class="listGoals-left">
                                <div class="clear"></div>
                                <div class="mygoals-stats-div withNoButton">
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
                                        <span class="mygoals-dead">Дедлайн</span>
                                        <span
                                            class="mygoals-dead color-red"><? echo date("Y.m.d", strtotime($goal->deadline)) ?></span>
                                        <?
                                        if ($goal->private) {
                                            echo '
                                 		<div class="mygoals-lock"><img src="/template/img/goals/lock.png" alt=""/></div>
                                 		 <span class="mygoals-privat">Приватная</span>';
                                        } ?>
                                        <div class="mygoals-progress withProcess">
                                            <div class="interests-selector-scale-viewport userpanel-info-scale-scale">
                                                <div class="interests-selector-scale-track"
                                                     style="margin-left: -<?= 100 - $goal->getProgressPercent() ?>%;"></div>
                                            </div>
                                        </div>
                                        <?
                                        if ($goal->active) {
                                            echo '
                                 <div class="processWprogress">
                                 <div class="mygoals-clock"><img src="/template/img/goals/clock.png" alt=""></div>
                                  <span class="mygoals-process">В процессе</span>
                                 </div>';
                                        } ?>
                                    </div>
                                </div>
                                <div class="goalDescr goals-description">
                                    <?= $goal->description ?>
                                </div>
                            </div>
                            <!--listGoals-left-->
                            <?php if(!empty($goal->getPhotos()[0])) {  ?>
                            <div class="goals-picture-mid"><img src="uploads<?= $goal->getPhotos()[0]->filename ?>"
                                                                alt=""/></div>
                            <?php } ?>
                            <div class="clear"></div>


                            <?=$this->render("_goal_subtask.php", ['goal' => $goal]) ?>

                        </div>
                        <!--goal-content-->
                    <? } ?>










                    <?php }else { ?>

                        <? Yii::$app->decor->infoPanel('Вы пока не добавили целей. Добавьте с помощью кнопки выше!', 'info'); ?>
 
                    <? } ?>

                    <!--goal-content-->
                </div>
                <!--output-->
                <!-- Списко целей-->
            </div>
        </div>
    </div>
</div>

<!-- . CONTENT END -->