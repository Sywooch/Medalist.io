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
						<div class="output">
							<div class="output-header">
								<h2 class="mdlst-h2t-goals">Цели</h2>
								<div class="output-header-meta-goals">
										<div class="mygoals-clock"><img src="/template/img/goals/clock.png" alt=""></div>
										 <span class="mygoals-process">В процессе</span>
								</div>
    						</div> 




							<div class="output-content">
								
								 <div class="mygoals-name-div">
									 <div class="mygoals-name">Купить квартиру в Кудрово</div>
									 <div class="mygoals-name-button"><a class="goal-done-button mdlst-button" href="#">Выполнить цель</a></div>
								</div>

								<div class="clear"></div>
								 <div class="mygoals-stats-div">
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

										<div class="mygoals-progress">
											<div class="interests-selector-scale-viewport userpanel-info-scale-scale">
										 		<div class="interests-selector-scale-track" style="margin-left: -80%;"></div>
										 	</div>
									 	</div>
									</div>
										 <div class="mygoals-edit-button"><a class="goal-edit-button mdlst-button" href="#">Редактировать</a></div>
								</div>
								<div class="clear"></div>


								<div class="goals-pictures">
									<div class="goals-picture-big"><img src="/template/img/goals/goal-pic-big.png" alt=""/></div>

									<div class="goals-pictures-small">
	
										<div class="goals-picture-small"><img src="/template/img/goals/goal-pic-1.png" alt=""/></div>
										<div class="goals-picture-small"><img src="/template/img/goals/goal-pic-2.png" alt=""/></div>
										<div class="goals-picture-small"><img src="/template/img/goals/goal-pic-3.png" alt=""/></div>
										<div class="goals-picture-small"><img src="/template/img/goals/goal-pic-4.png" alt=""/></div>

									</div>


								</div>

								<div class="clear"></div>

								<div class="goals-description">
									<p>Награды подтверждают выдающи	еся достижения. У нас есть обширный каталог наград, а есть и секретные, о которых никто не знает.</p>
								</div>

								<div class="questblock-info-controlls">
									<div class="questblock-info-controlls-likes">
										<div class="like-controll">
											<div class="like-controll-plus like-controll-active"><span></span>25</div>
											<div class="like-controll-minus"><span></span>12</div>
										</div>
									</div>
									<div class="questblock-info-controlls-comments">
										<div class="comment-controll"><span></span>94</div>
									</div>
								</div>
    
								<div class="tabs-container">
									<div class="tabs">
									  <ul class="tabs-ul">
									    <li class="tabs-li">
											<input type="radio" name="tabs-0" checked="checked" id="tabs-0-0" />
									        <label for="tabs-0-0">Список подзадач</label>
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
		
																<a class="container-menu-list-meta-add margin-0" href="#">
																	<span class="container-menu-list-meta-add-plus">+</span>
																</a>

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
		
																<a class="container-menu-list-meta-add margin-0" href="#">
																	<span class="container-menu-list-meta-add-plus">+</span>
																</a>

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
		
																<a class="container-menu-list-meta-add margin-0" href="#">
																	<span class="container-menu-list-meta-add-plus">+</span>
																</a>

															</div>
															<div class="subtask-bottom">
																Лучше всего летом, так как в городе не очень хочется...
															</div>

													</li>



												</ul>
											</div>
									   </li>
									   <li class="tabs-li">
									     <input type="radio" name="tabs-0" id="tabs-0-1" />
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

						</div>

					</div>


				</div>
			</div>
		</div>
		<!-- . CONTENT END -->