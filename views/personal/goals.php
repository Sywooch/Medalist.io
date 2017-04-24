<?php
/* @var $this yii\web\View */

echo $this->render('_panel.php');
?>


 <link rel="stylesheet" href="/template/css/goals.css">

		<!-- CONTENT -->
		<div class="container">
			<div class="wc">
				<div class="container-cols">
					<?=$this->render("_menu.php")?>


					<!-- container-content -->
					<div class="container-col container-col-2">



<!-- Списко целей-->


						<div class="output">
							<div class="output-header">
								 <div class="mygoals-name-div">
									<h2 class="mdlst-h2t-goals withButton">Мои цели (<?=count($goals)?>)</h2>
									 <a class="goal-done-button mdlst-button withHeader" href="#">+ Добавить новую цель</a>

								<div class="clear"></div>

								</div>
    						</div> 


							<?php foreach($goals as $goal) { ?> 

							<a class="mygoals-block" href="<?=Yii::$app->urlManager->createUrl(['personal/goal-detail', 'goal_id' => $goal->goal_id])?>">

							<div class="goal-content">
   								 <div class="mygoals-name-div">
                                     <div class="input-check withList">
									    <input type="checkbox" id="ListbGoal1" name="ListbGoal1" value="ListbGoal1"/>
    										<label for="ListbGoal1" class="subtask-top-name" id="mygoals-name"><?=$goal->name?></label>
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
											for($n=1;$n<=$goal->difficulty;$n++){
												 echo'<div class="mygoals-star star-yellow"></div>';
											}
											for($n=$goal->difficulty;$n<3;$n++){
												 echo'<div class="mygoals-star star-grey"></div>';
											}
											
											?>
										</div>
										 <span class="mygoals-dead">Дедлайн</span>
										 <span class="mygoals-dead color-red"><? echo date("Y.m.d",strtotime($goal->deadline))?></span>


											<?
											if($goal->private){
												 echo'
													<div class="mygoals-lock"><img src="/template/img/goals/lock.png" alt=""/></div>
													 <span class="mygoals-privat">Приватная</span>';
											}?>

										<div class="mygoals-progress withProcess">
											<div class="interests-selector-scale-viewport userpanel-info-scale-scale">
										 		<div class="interests-selector-scale-track" style="margin-left: -<?=100-$goal->percent_completed?>%;"></div>
										 	</div>
									 	</div>

											<?
											if($goal->active){
												 echo'
										<div class="processWprogress">
											<div class="mygoals-clock"><img src="/template/img/goals/clock.png" alt=""></div>
											 <span class="mygoals-process">В процессе</span>
										</div>';
											}?>

									</div>
								</div>

								<div class="goalDescr goals-description">
									<?=$goal->description?>
								</div>

							</div><!--listGoals-left-->

							<div class="goals-picture-mid"><img src="uploads<?=$goal->getPhotos()[0]->filename?>" alt=""/></div>

							<div class="clear"></div>

							<span class="showSubtasts">Смотреть подцели (<?=count($goal->getSubtasks())?>)</span>
							
											<div>
												<ul class="goal-subtask"> 
												<? 
												        $goal_subtasks = $goal->getSubtasks();
														var_dump($goal_subtasks);
														foreach($goal_subtasks as $subtask){?>
												        <?//=$subtask->goal_id?>
														<li class="subtask-container">
															<div class="subtask-top">
																<div class="subtask-top-left subtask-done">
                                                                    <div class="input-check">
																	    <input checked="checked" type="checkbox" id="subGoal1" name="subGoal1" value="subGoal1"/>
																		<label for="subGoal1" class="subtask-top-name">1. Выбрать дату с Мариной</label>
																	</div>
																	<div class="subtask-progress">
																		<div class="interests-selector-scale-viewport userpanel-info-scale-scale subtask-progress-height">
																	 		<div class="interests-selector-scale-track subtask-progress-height" style="margin-left: -80%;"></div>
																	 	</div>
																 	</div>
																	 <span class="mygoals-dead color-red subtask-top-dead">10.01.2017</span>
																</div>
		

															</div>
															<div class="subtask-bottom">
																Лучше всего летом, так как в городе не очень хочется...
															</div>

													</li>

												<?}?>
													<li class="subtask-container">
															<div class="subtask-top">
																<div class="subtask-top-left">
                                                                    <div class="input-check">
																	    <input type="checkbox" id="subGoal2" name="subGoal2" value="subGoal2"/>
																		<label for="subGoal2" class="subtask-top-name">1. Выбрать дату с Мариной</label>
																 	</div>

																	<div class="subtask-progress">
																		<div class="interests-selector-scale-viewport userpanel-info-scale-scale subtask-progress-height">
																	 		<div class="interests-selector-scale-track subtask-progress-height" style="margin-left: -80%;"></div>
																	 	</div>
																 	</div>
																	 <span class="mygoals-dead color-red subtask-top-dead">10.01.2017</span>
																</div>
		

															</div>
															<div class="subtask-bottom">
																Лучше всего летом, так как в городе не очень хочется...
															</div>
															<ul class="subtask-points">
																<li>
																	<div class="input-check">
																	    <input type="checkbox" id="subGoal2p1" name="subGoal2p1" value="subGoal2p1"/>
																		<label for="subGoal2p1" class="subtask-top-name">1. Выбрать дату с Мариной</label>
																	</div>
																	<div class="clear"></div>
																</li>
																<li>
                                                                    <div class="input-check">
																	    <input type="checkbox" id="subGoal2p2" name="subGoal2p2" value="subGoal2p2"/>
																		<label for="subGoal2p2" class="subtask-top-name">1. Выбрать дату с Мариной</label>
																	</div>
																	<div class="clear"></div>
																</li>

															</ul>
													</li>


													<li class="subtask-container">
															<div class="subtask-top">
																<div class="subtask-top-left subtask-done">
                                                                    <div class="input-check">
																	    <input checked="checked" type="checkbox" id="subGoal3" name="subGoal3" value="subGoal3"/>
																		<label for="subGoal3" class="subtask-top-name">1. Выбрать дату с Мариной</label>
																 	</div>
																	<div class="subtask-progress">
																		<div class="interests-selector-scale-viewport userpanel-info-scale-scale subtask-progress-height">
																	 		<div class="interests-selector-scale-track subtask-progress-height" style="margin-left: -80%;"></div>
																	 	</div>
																 	</div>
																	 <span class="mygoals-dead color-red subtask-top-dead">10.01.2017</span>
																</div>
		

															</div>
																	<div class="clear"></div>

															<div class="subtask-bottom">
																Лучше всего летом, так как в городе не очень хочется...
															</div>

													</li>



												</ul>
											</div>


						</div><!--goal-content-->
						</a>
							<? }  ?> 

							<div class="goal-content">

   								 <div class="mygoals-name-div">
                                     <div class="input-check withList">
									    <input type="checkbox" id="ListbGoal2" name="ListbGoal2" value="ListbGoal2"/>
										<label for="ListbGoal2" class="subtask-top-name" id="mygoals-name">Купить квартиру в Кудрово</label>
									</div>
									 <div class=""></div>
								</div>
								
								<div class="listGoals-left">


								<div class="clear"></div>
								 <div class="mygoals-stats-div withNoButton">
									 <div class="mygoals-left-wrapper">
										 <span class="mygoals-diff">Сложность</span>
										 <div class="mygoals-stars">
											 <div class="mygoals-star star-yellow"></div>
											 <div class="mygoals-star star-yellow"></div>
											 <div class="mygoals-star star-grey"></div>
										</div>
										 <span class="mygoals-dead">Дедлайн</span>
										 <span class="mygoals-dead color-red">10.01.2017</span>

										<div class="mygoals-lock"><img src="/template/img/goals/lock.png" alt=""/></div>
										 <span class="mygoals-privat">Приватная</span>

										<div class="mygoals-progress withProcess">
											<div class="interests-selector-scale-viewport userpanel-info-scale-scale">
										 		<div class="interests-selector-scale-track" style="margin-left: -80%;"></div>
										 	</div>
									 	</div>

										<div class="processWprogress">
											<div class="mygoals-clock"><img src="/template/img/goals/clock.png" alt=""></div>
											 <span class="mygoals-process">В процессе</span>
										</div>
									</div>
								</div>

								<div class="goalDescr goals-description">
									<p>Награды подтверждают выдающи	еся достижения. У нас есть обширный каталог наград, а есть и секретные, о которых никто не знает.</p>
									<p>Награды подтверждают выдающи	еся достижения. У нас есть обширный каталог наград, а есть и секретные, о которых никто не знает.</p>
								</div>

							</div><!--listGoals-left-->

							<div class="goals-picture-mid"><img src="/template/img/goals/goal-pic-mid.png" alt=""/></div>

							<div class="clear"></div>




											<div>
												<ul class="goal-subtask"> 

														<li class="subtask-container">
															<div class="subtask-top">
																<div class="subtask-top-left subtask-done">
                                                                    <div class="input-check">
																	    <input checked="checked" type="checkbox" id="subGoal1" name="subGoal1" value="subGoal1"/>
																		<label for="subGoal1" class="subtask-top-name">1. Выбрать дату с Мариной</label>
																	</div>
																	<div class="subtask-progress">
																		<div class="interests-selector-scale-viewport userpanel-info-scale-scale subtask-progress-height">
																	 		<div class="interests-selector-scale-track subtask-progress-height" style="margin-left: -80%;"></div>
																	 	</div>
																 	</div>
																	 <span class="mygoals-dead color-red subtask-top-dead">10.01.2017</span>
																</div>
		

															</div>
															<div class="subtask-bottom">
																Лучше всего летом, так как в городе не очень хочется...
															</div>

													</li>


													<li class="subtask-container">
															<div class="subtask-top">
																<div class="subtask-top-left">
                                                                    <div class="input-check">
																	    <input type="checkbox" id="subGoal2" name="subGoal2" value="subGoal2"/>
																		<label for="subGoal2" class="subtask-top-name">1. Выбрать дату с Мариной</label>
																 	</div>

																	<div class="subtask-progress">
																		<div class="interests-selector-scale-viewport userpanel-info-scale-scale subtask-progress-height">
																	 		<div class="interests-selector-scale-track subtask-progress-height" style="margin-left: -80%;"></div>
																	 	</div>
																 	</div>
																	 <span class="mygoals-dead color-red subtask-top-dead">10.01.2017</span>
																</div>
		

															</div>
															<div class="subtask-bottom">
																Лучше всего летом, так как в городе не очень хочется...
															</div>
															<ul class="subtask-points">
																<li>
																	<div class="input-check">
																	    <input type="checkbox" id="subGoal2p1" name="subGoal2p1" value="subGoal2p1"/>
																		<label for="subGoal2p1" class="subtask-top-name">1. Выбрать дату с Мариной</label>
																	</div>
																	<div class="clear"></div>
																</li>
																<li>
                                                                    <div class="input-check">
																	    <input type="checkbox" id="subGoal2p2" name="subGoal2p2" value="subGoal2p2"/>
																		<label for="subGoal2p2" class="subtask-top-name">1. Выбрать дату с Мариной</label>
																	</div>
																	<div class="clear"></div>
																</li>

															</ul>
													</li>


													<li class="subtask-container">
															<div class="subtask-top">
																<div class="subtask-top-left subtask-done">
                                                                    <div class="input-check">
																	    <input checked="checked" type="checkbox" id="subGoal3" name="subGoal3" value="subGoal3"/>
																		<label for="subGoal3" class="subtask-top-name">1. Выбрать дату с Мариной</label>
																 	</div>
																	<div class="subtask-progress">
																		<div class="interests-selector-scale-viewport userpanel-info-scale-scale subtask-progress-height">
																	 		<div class="interests-selector-scale-track subtask-progress-height" style="margin-left: -80%;"></div>
																	 	</div>
																 	</div>
																	 <span class="mygoals-dead color-red subtask-top-dead">10.01.2017</span>
																</div>
		

															</div>
																	<div class="clear"></div>

															<div class="subtask-bottom">
																Лучше всего летом, так как в городе не очень хочется...
															</div>

													</li>



												</ul>
											</div>




						</div><!--goal-content-->
						
						</div><!--output-->
<!-- Списко целей-->

						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- . CONTENT END -->