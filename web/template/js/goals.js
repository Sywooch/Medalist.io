 

$(document).ready(function(){



 


		/* GOALS  */
		$('.js-addach-isdifficult').hide();
		console.log($('[data-toggle="rangeslider"]').rangeslider({ polyfill: false }));
		$('.addach-description-text-textarea').trumbowyg(  );
		$('[data-toggle="datepicker"]').datepicker( {format: 'dd.mm.yyyy'});
		
		console.log( $('[data-toggle="rangeslider"]').rangeslider('update', true) );
 

		$(document).on('keydown', '.js-tag-adder', function(e ){
		 	var  v = $(this).val();

			if( e.which == 13 ){
				e.preventDefault();
				$(this).val('');
				$('.addach-tags-w').append('<div class="  mdlst-button mdlst-button-default addach-tags-tag"  >'+v+'<div class="mdlst-button-closer "></div></div>')

			}
		});
		$(document).on('change', 'input[name="addach-chk-isimportant"]', function(e ){
			console.log('123');
		 	if( $(this).is(":checked")) {
				$('.js-addach-isdifficult').show();
				$('.js-addach-isdifficult-h').hide();
		 	}else{
		 		$('.js-addach-isdifficult').hide();
		 		$('.js-addach-isdifficult-h').show();
		 	}
		});

		if ( $('input[name=difficult]').length > 0  ){
			$('.js-addach-isdifficult').show();
			$('.js-addach-isdifficult-h').hide();
		}



		//Взять квест
		$(document).on('click', '.js-add-achievement', function(){
			var p = $(this).parents('.addachievement-form'),
				name = p.find('input[name="name"]'),
				description = p.find('textarea[name="description"]'),
				difficulty = p.find('input[name="difficulty"]'),
				difficult = p.find('input[name="addach-chk-isimportant"]'),
				entity = p.find('[name="entity"]'),
				date_achieved = p.find('[name="date_achieved"]'),
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
				data['difficult'] = ( difficult.attr("checked") == 'checked' ?1:0);
				data['date_achieved'] = date_achieved.val();
				data['entity'] = entity.val();
				data['interests'] =  tagWords;
				data['_csrf'] = _csrf.val();
				 
		 	
				$.ajax({
					url: ajaxUrls['addAchievement'],
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



		/* GOALS END */

 


});