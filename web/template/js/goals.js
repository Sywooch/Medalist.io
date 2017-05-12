 

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
				data['interests'] =  tagWords;
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
				success: function(data){
					if( typeof data.progress != 'undefined'){
						$('.interests-selector-scale-track').css('margin-left', '-'+(100 - data.progress)+'%');
					}
				}
			});
		};

		var markSubtaskComplete = function(goal_subtask_id, goal_id){
			$.ajax({
				url: ajaxUrls['setGoalSubtaskComplete'],
				data: {goal_subtask_id: goal_subtask_id},
				success: function(data){
					if( typeof data.progress != 'undefined'){
						$('.interests-selector-scale-track').css('margin-left', '-'+(100 - data.progress)+'%');
					}
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

 


});