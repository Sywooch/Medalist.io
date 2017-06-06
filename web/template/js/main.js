countInterests = function(){
	return $('.interests-button-selected:visible').length;
};

/*effects */
blinkNew = function( className ){
	var cBlink = '#8a44ff',
		h = $('<div></div>');
	console.log(className);
	if( typeof className == 'string' ){
		className = $(className);
	}

	console.log(className);
	console.log(className.length);

	className.css('position', 'relative');
	h.css('background-color', cBlink);
	h.css('width', '100%');
	h.css('height', '100%');
	h.css('left', '0');
	h.css('right', '0');
	h.css('position', 'absolute');
	h.css('z-index', '100');

	className.prepend(h);
	className.removeClass('ajax-prepended');
	h.animate({'opacity': 0}, 500, function(){ h.remove();});


	return false;
};


$(document).ready(function(){




	/*effects end */

	/* REGISTRATION */

		/* interests selector */
		var interestForReward = 7;
		var loadInterestChildren = function( interest_id ){
			if (typeof interest_id == 'undefined') { return false ;}

			console.log( interest_id );

			$.ajax({
				url: $('input[name=childInterestsUrl]').val(),
				data: { interest_id: interest_id },
				type: 'get',
				dataType : 'json',
				success: function(data){
					var dummy = '';
						
					for( var k in data.children ){

						dummy = $('<div class="interests-button mdlst-button js-interest-selector-takeinterest"></div>');
						dummy.text( data.children[k].name );
						//dummy.addClass( "h-interest-" + data.children[k].interest_id);
						dummy.data('id', data.children[k].interest_id);
						 console.log( dummy.data('id'));
						
						$('.interests-selector').append(dummy);
					}

					EventEngine.registerEventFromRawAjax (data);

 
				}
			})
		};


		var checkIfInterestCompleted = function(){
			var count = $('.interests-button-selected').length,
				needed = interestForReward;

				return (count >= needed);
		}

		var curtainReward = function(){
			if( checkIfInterestCompleted() ){
				//Showing Reward
				$('.h-interests-before-reward').stop().slideUp();
				$('.h-interests-after-reward').stop().slideDown();
			}else{
				//Showing Back
				$('.h-interests-before-reward').stop().slideDown();
				$('.h-interests-after-reward').stop().slideUp();
			}
		}

		$(document).on('click', '.js-interest-selector-takeinterest', function(){
			var text = $(this).text(),
				id = $(this).data('id'),
				childLoaded = $(this).data('childloaded'),
				handler = $('.interests-selector-selected'),
				dummy = $('<div class="interests-button-selected mdlst-button">'+text+' <div class="mdlst-button-closer js-interest-selector-removeinterest"></div></div> '),
				track = $('.interests-selector-scale-track');

			console.log('taken id ' + id );

			dummy.data('id', id);
			dummy.css('display', 'none');

			handler.append( dummy );
			dummy.fadeIn(function(){track.css('margin-left', '-'+((interestForReward-countInterests())/interestForReward)*100+'%' );});
			console.log( 'attached id ' + dummy.data('id') );
		 
			if( typeof childLoaded == 'undefined'){
			 
				loadInterestChildren( id );
				$(this).data('childloaded', true);
			}
			$(this).fadeOut();
			curtainReward();
			 

		});

		$(document).on('click', '.js-interest-selector-removeinterest', function(){
			var p = $(this).parents('.interests-button-selected'),
				id = p.data('id'),
				track = $('.interests-selector-scale-track');

			console.log(' removing id ' + id );
					 
			p.fadeOut(function(){track.css('margin-left', '-'+ ((interestForReward-countInterests())/interestForReward)*100+'%' ); p.remove(); curtainReward();});
			$('.js-interest-selector-takeinterest').filter(function(){ return $(this).data("id") == id  }).fadeIn();
			 
			console.log($('.js-interest-selector-takeinterest[data-id="'+id+'"]').length);
			console.log('.js-interest-selector-takeinterest[data-id="'+id+'"]');
			
		});








		$(document).on('click', '.js-quick-register', function(){
			var p = $(this).parents('form.pregister-form'),
				action = p.attr('action'),
				email = p.find('input[name=email]'),
				_csrf = p.find('input[name=_csrf]');
				successUrl = p.find('input[name=successUrl]');

				console.log(  email.val());

				$.ajax({
					type: 'post',
					url: action ,
					data: {email: email.val(), _csrf : _csrf.val()},
					dataType : 'json',
					success: function( data ){

						if( data.success ){
							console.log('123')
							document.location.href =   successUrl.val();
						}


						EventEngine.registerEventFromRawAjax (data);
					}
				});

				return false;
		});

		/* Изменение пароля */
		$(document).on('click', '.js-set-password', function(){
			var p = $(this).parents('form.pregister-form'),
				action = p.attr('action'),
				password = p.find('input[name=password]'),
				_csrf = p.find('input[name=_csrf]');
				successUrl = p.find('input[name=successUrl]');

				 console.log('123');
				 console.log(password.val());
				 console.log(action);
				 console.log(_csrf.val());
				 console.log(successUrl.val());

				$.ajax({
					type: 'post',
					url: action ,
					data: {password: password.val(), _csrf : _csrf.val()},
					dataType : 'json',
					success: function( data ){
						console.log(data);
						if( data.success ){
							console.log('123');
							document.location.href =   successUrl.val();
						}
						EventEngine.registerEventFromRawAjax (data);
					}
				});

				return false;
		});

		/* Изменение пароля */
		$(document).on('click', '.js-register-save-interests', function(){
			var p = $(this).parents('form.pregister-form'),
				action = p.attr('action'),
				_csrf = p.find('input[name=_csrf]'),
				interests = [];

				$('.interests-button-selected').each(function(i,e){
 					interests[interests.length] = $(e).data('id');
				});

				console.log( interests );

			 
				

				
				$.ajax({
					type: 'post',
					url: action ,
					data: {interests: interests, _csrf : _csrf.val()},
					dataType : 'json',
					success: function( data ){
						console.log(data);
					 
						if( data.success ){
							 
							document.location.href =   data.returnUrl;
						}
						EventEngine.registerEventFromRawAjax (data);
					}
				});

				return false;
		});



	/* . REGISTRATION END */





		/* QUESTS ====================*/

		window.fireNewBadgePopup = function(data){
			var popup = $('.rewardpopup');

			popup.find('.rewardpopup-form-pic img').attr('src', data.picture);
			popup.find('.rewardpopup-form-text').text(data.description);
			popup.find('.mdlst-button').text('+' + data.points + ' ' + data.scale);
			popup.fadeIn();
		};

		var pushNewQuestChallenge = function() {};

		//Выводит блок
		var pushNewQuestPending = function(quest_id) {
			$.ajax({
				url: ajaxUrls['getQuestPendingTaskHtml'],
				data: {quest_id:quest_id},
				dataType: 'json',
				success: function(data){
					var h = $(data.html);
					h.css('display', 'none');
					$('.questpending-wrapper').append( h );
					h.slideDown();
					$('.h-quest-pendint-tasks-title').slideDown();
				}
			});

		};

		//Взять квест
		$(document).on('click', '.js-quest-takequest', function(){
			var p = $(this).parents('.questblock'),
				id = $(this).data('id');
				 
		 	
				$.ajax({
					url: ajaxUrls['takeQuest'],
					data: { quest_id : id},
					dataType: 'json',
					success: function(data){
						//TODO Success
						pushNewQuestPending( id );
						p.slideUp();

						EventEngine.registerEventFromRawAjax (data);
					}

				});
 
			
		});




		//Принять вызов
		$(document).on('click', '.js-quest-acceptchallenge', function(){
			var p = $(this).parents('.questssuggested-quests-quest'),
				pp = $(this).parents('.questssuggested'),
				quest_id = $(this).data('quest_id'),
				quest_challenge_id = $(this).data('quest_challenge_id');
				 
		 	
				$.ajax({
					url: ajaxUrls['takeQuest'],
					data: { quest_id : quest_id,  quest_challenge_id : quest_challenge_id },
					dataType: 'json',
					success: function(data){
						//TODO Success
						pushNewQuestPending( quest_id );
						p.slideUp( function(){ p.remove(); 
							if( pp.find('.questssuggested-quests-quest').length == 0 ){
								pp.slideUp(function(){ pp.remove(); });
							}
						});

						EventEngine.registerEventFromRawAjax (data);
					}

				});
 
			
		});
		//Принять вызов
		$(document).on('click', '.js-quest-refusechallenge', function(){
			var p = $(this).parents('.questssuggested-quests-quest'),
				pp = $(this).parents('.questssuggested'),	
				quest_id = $(this).data('quest_id'),
				quest_challenge_id = $(this).data('quest_challenge_id');
				 
		 	
				$.ajax({
					url: ajaxUrls['refuseQuestChallenge'],
					data: { quest_id : quest_id,  quest_challenge_id : quest_challenge_id },
					dataType: 'json',
					success: function(data){
						//TODO Success
						 
						p.slideUp( function(){ p.remove(); 
							if( pp.find('.questssuggested-quests-quest').length == 0 ){
								pp.slideUp(function(){ pp.remove(); });
							}
						});

						EventEngine.registerEventFromRawAjax (data);
					}

				});
 
			
		});


		//Взять квест
		$(document).on('click', '.rewardpopup-bg', function(){
			var p = $(this).parents('.rewardpopup');
				 
		 	 p.fadeOut();
			
		});

		/* . END QUESTS ====================*/


		/* ACHIEVEMENT */
		$('.js-addach-isdifficult').hide();
		console.log($('[data-toggle="rangeslider"]').rangeslider({ polyfill: false }));
		$('.addach-description-text-textarea').trumbowyg(  );
		$('[data-toggle="datepicker"]').datepicker( {format: 'dd.mm.yyyy'});


		if( $('[data-toggle="dropzone"]').length > 0 ){
			myDropzoneFiles = [];
			myDropzone = new Dropzone(
				'[data-toggle="dropzone"]',
				{
					url: 'http://' + window.location.hostname + "/index.php?r=site/ajax-upload-image",
				        success: function(file, response) {
							myDropzoneFiles[ myDropzoneFiles.length ] = response;
							file.fid = myDropzoneFiles.length;
					        if (file.previewElement) {
					          return file.previewElement.classList.add("dz-success");
					        }
				      },

				      removedfile: function(file) {
				        var _ref;
						myDropzoneFiles.splice(file.fid-1,1);

				        if (file.previewElement) {
				          if ((_ref = file.previewElement) != null) {
				            _ref.parentNode.removeChild(file.previewElement);
				          }
				        }
				        return this._updateMaxFilesReachedClass();
				      }


				}
			);

		}
		 
		
		console.log( $('[data-toggle="rangeslider"]').rangeslider('update', true) );
 
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
				data['files'] =  myDropzoneFiles;
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
						myDropzoneFiles = [];

						EventEngine.registerEventFromRawAjax (data);
					}

				});

				return false;
 
			
		});



		//Взять квест
		$(document).on('click', '.js-update-achievement', function(){
			var p = $(this).parents('.addachievement-form'),
				name = p.find('input[name="name"]'),
				achievement_id = p.find('input[name="achievement_id"]'),
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
				data['achievement_id'] = achievement_id.val();
				data['interests'] =  tagWords;
				data['files'] =  myDropzoneFiles;
				data['_csrf'] = _csrf.val();
				 
		 	
				$.ajax({
					url: ajaxUrls['updateAchievement'],
					data: data,
					dataType: 'json',
					type: 'post',
					success: function(data){
						console.log(data);

						if( data.success ){
							$('.addach').slideUp();
							$('.addach-success').slideDown();
						}
						myDropzoneFiles = [];

						EventEngine.registerEventFromRawAjax (data);
					}

				});

				return false;
 
			
		});



		//Взять квест
		$(document).on('click', '.js-delete-achievement', function(){
			if( confirm('Вы точно хотите удалить это достижение?') ){
				document.location.href = $(this).data('delete_url');
			}else{
				return false;
			}
		});




		/* бросить вызов */
		$(document).on('click', '.js-questchallenge-select-user', function(){
			var user_id = $(this).data('user_id');

			if( $(this).hasClass('mdlst-button-disabled') ){
				 $(this).removeClass('mdlst-button-disabled');
				 $(this).removeClass('checked');
				 $(this).text('Бросить вызов');
			}else{
				 $(this).addClass('mdlst-button-disabled');
				 $(this).addClass('checked');
				 
				 $(this).text('Снять выбор');
			}
		});

		$(document).on('click', '.js-questchallenge-send', function(){
			var selected = $('.js-h-questchallenge-user.checked'),
				_csrf = $('[name=_csrf]'),
				quest_id = $('[name=quest_id]'),
				user_ids = [];


				selected.each( function(i,e){
					user_ids[user_ids.length] = $(e).data('user_id');
				}); 

				console.log( user_ids );

				$.ajax({
					url: ajaxUrls['questChallengeSend'],
					data: {user_ids : user_ids, _csrf: _csrf.val(), quest_id: quest_id.val()},
					type: 'post',
					dataType: 'json',
					success: function( data ){
						console.log(data);
						if( data.success ){
							$('.js-h-quest-sended').slideUp();
							$('.js-h-quest-sended-success').slideDown();
						}
					}
				});
		});






		/* бросить вызов end */



		/* ACHIEVEMENT END */


		/* CONTROLLS */
		$(document).on('click','.mdlst-switch', function(){
			var check = $(this).find('input');

			if( $(this).hasClass('mdlst-switch-on') ){
				$(this).removeClass('mdlst-switch-on');
				check.attr('checked', false);
				check.change();
			}else{
				$(this).addClass('mdlst-switch-on');
				check.attr('checked', 'checked');
				check.change();
			}

		});

		$(document).on('change', '.dropdown-select select', function(){
			var o = $(this).find('option:checked'),
				t = o.text(),
				p = $(this).parents('.dropdown-select'),
				tH = p.find('.dropdown-select-block-text');

				tH.text(t);
		});
		$('.dropdown-select select').change();






		$(document).on('keydown', '.js-tag-adder', function(e ){
		 	var  v = $(this).val();

			if( e.which == 13 ){
				e.preventDefault();
				$(this).val('');
				$('.addach-tags-w').append('<div class="  mdlst-button mdlst-button-default addach-tags-tag"  >'+v+'<div class="mdlst-button-closer "></div></div>')

			}
		});


		
		/* . CONTROLLS END ===================== */


		/* LIKES */
		$(document).on('click', '.js-add-like', function(){
			var p = $(this).parents('.like-controll'),
				className = p.data('obj'),
				classId = p.data('id'),
				point = $(this).data('point'),
				data =  {entity_class : className, entity_id: classId, point: point},
				that = this;

				$.ajax({
					url: ajaxUrls['addLike'],
					data: data,
					type: 'get',
					dataType: 'json',
					success: function(data){
						console.log(data);
						p.find('.js-add-like').removeClass('like-controll-active');
						$(that).addClass('like-controll-active');
					}

				})
		});
		/* LIKES END ================== */

		/* COMMENTS */
		var prependComment = function( viewport, commentId, parentCommentId ){
			var html = '';

			//It is an answer - find proper answer section
			if( typeof parentCommentId != 'undefined' && parseInt(parentCommentId) > 0){
				viewport = viewport.find('.comment-id-'+parentCommentId+' .comment-block-answers');
			}

			$.ajax({
				url: ajaxUrls['getCommentHtml'],
				data: {comment_id: commentId, parent_comment_id: parentCommentId },
				success: function(data){

				 
					html = data;
					html = $(html);

					if( typeof viewport == 'string'){
						viewport = $(viewport);
					}

					
					viewport.prepend( html );

					blinkNew( '.ajax-prepended' );

				 
				}
			});

			return html;
		 
		}


		
		$(document).on('click', '.js-add-comment', function(){
			var p = $(this).parents('.form-add-comment'),
				className = p.data('obj'),
				classId = p.data('id'),
				parent_comment_id = p.find('.parent_comment_id').val(),
 				comment = p.find('textarea').val(),
 				err = p.find('.form-add-comment-error'),
				data =  {entity_class : className, entity_id: classId, text: comment, parent_comment_id, parent_comment_id},
				that = this;

				if( comment.length < 10 ){
					err.text('Комментарий слишком короткий');
					err.slideDown();
					return false;
				}
 

				$.ajax({
					url: ajaxUrls['addComment'],
					data: data,
					type: 'get',
					dataType: 'json',
					success: function(data){
						var html;
						console.log(data);
						if( data.success ){
							prependComment( $('.questblock-comments-quest-' + classId + ' .questblock-comments-form-wrapper'), data.comment_id, data.parent_comment_id );	
							console.log('222');
							console.log( $('.ajax-prepended').length );
							


							p.find('textarea').val('');
						}else{
							err.text( data.error );
							err.slideDown;
						}
						
						 
					}

				});

				return false;
		});



		$(document).on('click', '.js-comment-makeresponse', function(){
			var p = $(this).parents('.comments-widget'),
				form = p.find('.form-add-comment');

				form.find('.parent_comment_id').val( $(this).data('id') );
				form.find('textarea').focus();

				//TODO - add label that "Your answer too..."

				 

				return false;
		});


		/* COMMENTS END ================== */


		/* PROFILE UPDATE */
		$(document).on('click', ".js-update-profile-show", function(){
			$('.profileview-content-view').slideUp();
			$('.profileview-edit').slideDown();
		});
		/* PROFILE UPDATE END */



		/* OWL SLIDER */
            $(document).ready(function() {
              var owl = $('.owl-carousel');
              owl.owlCarousel({
                items: 1,
                loop: true,
                margin: 0,
                autoplay: true,
                autoplayTimeout: 7000,
                autoplayHoverPause: false,
				nav: false,
				dots:false
				

              });
              $('.play').on('click', function() {
                owl.trigger('play.owl.autoplay', [7000])
              })
              $('.stop').on('click', function() {
                owl.trigger('stop.owl.autoplay')
              })
            })
		/* OWL SLIDER END */

});