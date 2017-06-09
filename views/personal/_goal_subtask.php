<?php 
use Yii;
use app\models\Goal;
?>

                            <? $subtasks = Goal::getSubtasksById($goal->goal_id);

                            $is_subtasks = count($subtasks) > 0; ?>

                            <? if ($is_subtasks){ ?>

                            <span class="showSubtasts">Смотреть подцели (<?= count($subtasks); ?>)</span>

                            <div>
                                <ul class="goal-subtask">
                                  


                                    <? foreach ($subtasks as $subtask){
                                    $s = $g . "s" . $subtask->goal_subtask_id;
                                    ?>
                                    <li class="subtask-container">
                                        <div class="subtask-top">
                                            <div
                                                class="subtask-top-left <?= $subtask->completed ? 'subtask-done' : ''; ?>">
                                                <div class="input-check">
                                                    <input <?= $subtask->completed ? 'checked = "checked"' : ''; ?>
                                                        type="checkbox" id="<?= $s; ?>" name="<?= $s; ?>"
                                                        value="<?= $s; ?>"/>
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
                                                            type="checkbox" id="<?= $p ?>" name="<?= $p ?>"
                                                            value="<?= $p ?>"/>
                                                        <label for="<?= $p ?>"
                                                               class="subtask-top-name">1. <?= $subtask_point->name ?></label>
                                                    </div>
                                                    <div class="clear"></div>
                                                </li>
                                            <? } ?>

                                            <? if ($is_subtask_points){ ?>
                                        </ul>
                                    <? } ?>

                                        <? } ?>

                                    </li>

                                </ul>
                            </div> 


                             <? } ?>