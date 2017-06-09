


                                        <!-- widget add subgoal -->
                                        <div class="goal-addsubtask">
                                            <div class="goal-addsubtask-controll">
                                                <div class="goal-addsubtask-text">
                                                    Добавить подзадачу
                                                </div>
                                                <div class="goal-addsubtask-button">
                                                    <a class="container-menu-list-meta-add margin-0 js-add-subtask-showform"  >
                                                        <span class="container-menu-list-meta-add-plus">+</span>
                                                    </a>    
                                                </div>
                                            </div>


                                            <div class="goal-addsubtask-addform" data-goal_id="<?=$goal->goal_id?>" style="display: none;">
                                                <input type="hidden" value="<?=Yii::$app->request->getCsrfToken()?>"  name="_csrf">
                                                <input type="text" name="name" class="goal-addsubtask-input">
                                                <input type="text" name="date" class="goal-addsubtask-date" data-toggle="datepicker" style="width:  100px;"> 
                                                <?=Yii::$app->decor->button('Добавить подцель', '', 'js-add-subtask')?>
                                            </div>

                                                                                        
                                        </div>
                                      
                                        <!-- widget add subgoal task -->