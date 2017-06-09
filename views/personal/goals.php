<?php
/* @var $this yii\web\View */
use app\models\Goal;
use app\models\Like;
use app\models\Comment;

echo $this->render('_panel.php');
?>
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

		            <div class="achievement-list">



                <?php if( !empty($goals) ) { ?>

                    <?php foreach ($goals as $goal) {
                        $g = "ListbGoal" . $goal->goal_id;
                        ?>


                        <div class="goal-content achievement-block achievement-block--big">
						<div class="achievement-block-content">
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
                                <div class="">
                                 
                                </div>
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
                                            class="mygoals-dead color-red"><? echo date("d.m.Y", strtotime($goal->deadline)) ?></span>
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
                            <div class="clear"></div>


													<div class="achievement-block-content-description"><?=$goal->description;?></div>

													<div class="questblock-info-controlls">
														<div class="questblock-info-controlls-likes">
								 							<?=Yii::$app->like->renderWidget($goal);?>
	        											</div>

														<div class="questblock-info-controlls-comments">
																<?=Yii::$app->comment->renderCommentCount( count(Comment::getCommentsOfObject($goal)->all() ) , false, true );?>
        												</div>
													</div>

                            </div>
                            <!--listGoals-left-->

                            <div class="goals-picture-mid" <?php if(!empty($goal->getPhotos()[0]) ) { ?> style = "background-image: url(<?=$goal->getPhotos()[0]->filename?>);"<? } ?>></div>


                            <div class="clear"></div>
                            <? Yii::$app->decor->button( 'Редактировать цель',  Yii::$app->urlManager->createUrl(['personal/goal-update', 'goal_id' => $goal->goal_id]) );?>
                            <? Yii::$app->decor->button( 'Удалить цель',  '', 'mdlst-button-accent js-delete-goal', ['delete_url' => Yii::$app->urlManager->createUrl(['goal/delete-goal', 'goal_id' => $goal->goal_id])] );?>
 

                            <? // $this->render("_goal_subtask.php", ['goal' => $goal, 'g' =>$g]) ?>

                        </div>
                </div>
                        <!--goal-content-->
                    <? } ?>










                    <?php }else { ?>

                        <? Yii::$app->decor->infoPanel('Вы пока не добавили целей. Добавьте с помощью кнопки выше!', 'info'); ?>
 
                    <? } ?>

                    <!--goal-content-->
                </div>
                </div>
                <!--output-->
                <!-- Списко целей-->
            </div>
        </div>
    </div>
</div>

<!-- . CONTENT END -->