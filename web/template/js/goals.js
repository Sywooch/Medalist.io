 

$(document).ready(function(){



 


		/* GOALS  */
	 
	 
		$('[data-toggle="trumbowyg"]').trumbowyg(  );
	 
		
		console.log( $('[data-toggle="rangeslider"]').rangeslider('update', true) );
 
  



		//Взять квест
		$(document).on('click', '.js-add-goal', function(){
			var p = $(this).parents('.addgoal-form'),
				name = p.find('input[name="name"]'),
				description = p.find('textarea[name="description"]'),
				difficulty = p.find('input[name="difficulty"]'),
				deadline = p.find('[name="deadline"]'),
				private = p.find('[name="private"]'),
				tags = p.find('.addach-tags-w .addach-tags-tag'),
				subtasksBlocks = $('.subtasks-pane-block'),
				tagWords = [],
				subtasks = [],
				_csrf = p.find('input[name=_csrf]'),
				data = {}
				;

				tags.each(function(i,e){
					tagWords[ tagWords.length ] = $(e).text();
				});
				subtasksBlocks.each(function(i,e){
					subtasks[ subtasks.length ] = $(e).find('.subtasks-pane-block-name').text();
				});

				data['name'] = name.val();
				data['description'] = description.val();
				data['difficulty'] = difficulty.val();
				data['deadline'] = deadline.val();
				data['private'] = (private.is(":checked"))?1:0;
				data['interests'] =  tagWords;
				data['subtasks'] =  subtasks;
				data['files'] =  myDropzoneFiles;
				data['_csrf'] = _csrf.val();
				 
		 	
				$.ajax({
					url: ajaxUrls['addGoal'],
					data: data,
					dataType: 'json',
					type: 'post',
					success: function(data){
						console.log(data);

						if( data.success ){
							$('.addach').slideUp();
							$('.addach-success').slideDown();
						}else{
							$('.addach-errors').slideDown();
							$('.addach-errors-list').html('');
							for( var k in data.errors ){
									$('.addach-errors-list').append('<li>'+data.errors[k]+'</li>');
							}
						}

						EventEngine.registerEventFromRawAjax (data);
					}

				});

				return false;
 
			
		});

		//Взять квест
		$(document).on('click', '.js-delete-goal', function(){
			if( confirm('Вы точно хотите удалить эту цель?') ){
				document.location.href = $(this).data('delete_url');
			}else{
				return false;
			}
		});


		//Взять квест
		$(document).on('click', '.js-update-goal', function(){
			var p = $(this).parents('.addgoal-form'),
				name = p.find('input[name="name"]'),
				goal_id = p.find('input[name="goal_id"]'),
				description = p.find('textarea[name="description"]'),
				difficulty = p.find('input[name="difficulty"]'),
				deadline = p.find('[name="deadline"]'),
				private = p.find('[name="private"]'),
				tags = p.find('.addach-tags-w .addach-tags-tag'),
				tagWords = [],
				_csrf = p.find('input[name=_csrf]'),
				data = {}
				;

				tags.each(function(i,e){
					tagWords[ tagWords.length ] = $(e).text();
				});

				data['name'] = name.val();
				data['description'] = description.val();
				data['difficulty'] = difficulty.val();
				data['deadline'] = deadline.val();
				data['goal_id'] = goal_id.val();
				data['private'] = (private.is(":checked"))?1:0;
				data['interests'] =  tagWords;
				data['files'] =  myDropzoneFiles;
				data['_csrf'] = _csrf.val();
				 
		 	
				$.ajax({
					url: ajaxUrls['updateGoal'],
					data: data,
					dataType: 'json',
					type: 'post',
					success: function(data){
						console.log(data);

						if( data.success ){
							$('.addach').slideUp();
							$('.addach-success').slideDown();
						}else{
							$('.addach-errors').slideDown();
							$('.addach-errors-list').html('');
							for( var k in data.errors ){
									$('.addach-errors-list').append('<li>'+data.errors[k]+'</li>');
							}
						}

						EventEngine.registerEventFromRawAjax (data);
					}

				});

				return false;
 
			
		});



		$(document).on('click', '.js-add-subtask-showform', function(){
			var p = $(this).parents('.goal-addsubtask'),
				addTitle = p.find('.goal-addsubtask-controll')
				form = p.find('.goal-addsubtask-addform');

			form.slideDown();
			addTitle.slideUp();
			form.find('[name=name]').focus();
			return false;
		});



		var renderGoalSubtaskHTML= function(goal_subtask_id, no, holder){
			var url = ajaxUrls['renderGoalSubtaskHTML'];

			$.ajax({
				url: url,
				data: { goal_subtask_id : goal_subtask_id, no:no },
				success: function(data){
					data = $(data);

					$(holder).append(data);

					blinkNew( data );

				}
			});

		};

		var renderTotalGoalProgress = function( goal_id ){
			$.ajax({
				url: ajaxUrls['calcGoalProgress'],
				data: {goal_id: goal_id},
				dataType: 'json',
				success: function(data){
					if( typeof data.progress != 'undefined'){
						$('.mygoals-progress .interests-selector-scale-track').css('margin-left', '-'+(100 - data.progress)+'%');
					}
				}
			});
		};

		var markSubtaskComplete = function(goal_subtask_id, goal_id){
			$.ajax({
				url: ajaxUrls['setGoalSubtaskComplete'],
				data: {goal_subtask_id: goal_subtask_id},
				dataType: 'json',
				success: function(data){
					$('[data-goal_subtask_id='+goal_subtask_id+']').find('[type=checkbox]').attr('checked', data.status==1?"checked":false);
				 	$('[data-goal_subtask_id='+goal_subtask_id+']').find('.interests-selector-scale-track').css('margin-left', '-'+(100 - data.progress)+'%');
				}
			});
			renderTotalGoalProgress(goal_id);
		};

		$(document).on('click', '.js-add-subtask', function(){
			var p = $(this).parents('.goal-addsubtask-addform'),
				goal_id = p.data('goal_id'),
				name = p.find('[name=name]'),
				deadline = p.find('[name=date]');

			if( name.val().length < 10 ){
				alert("Введите подцель не короче 10 символов");
				return false;
			}

			$.ajax({
				url: ajaxUrls['addGoalSubtask'],
				data: {name: name.val(), deadline: deadline.val(), goal_id: goal_id, _csrf : p.find('input[name=_csrf]').val() },
				type: 'post',
				dataType: 'json',
				success: function(data){
					console.log(data);
					name.val('');
					deadline.val('');

					renderGoalSubtaskHTML( data.goal_subtask_id, ($('.subtask-container').length+1), '.goal-subtask' );
				}
			})

			return false;
		});

		$(document).on('click', '.js-set-subtask-complete', function(){
			var goal_subtask_id = $(this).data('goal_subtask_id'),
			 	 goal_id = $(this).data('goal_id'),
				completed = $(this).hasClass('subtask-done');

			if( completed ){
				$(this).removeClass('subtask-done');
			}else{
				$(this).addClass('subtask-done');
			}

			markSubtaskComplete(goal_subtask_id, goal_id);
			return false;
		});


		/* GOALS END */

		//$('.subtasks-pane-output').sortable();
		//$('.subtasks-pane-output').sortable();
		

		$(document).on('keydown', '.subtaskadder', function(ev){
			var data = $(this).val(),
				l = $('.subtasks-pane-block').length;

			console.log(l);
			if(ev.which == 13 || ev.keyCode == 13){
				ev.preventDefault();
				ev.stopPropagation();

				$(this).val('');

				$('.subtasks-pane-output').append('<div class="subtasks-pane-block"><div class="subtasks-pane-block-num">'+(l+1)+'.</div><div class="subtasks-pane-block-name">'+(data)+'</div><div class="subtasks-pane-block-delete"></div></div>');
				$('.subtasks-pane-output').sortable();
				//$('.subtasks-pane-output').sortable({  handle: '.handle' });

				return false;


			}

		});

 


});