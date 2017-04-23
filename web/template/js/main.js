countInterests = function(){
	return $('.interests-button-selected:visible').length;
};
$(document).ready(function(){

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
		$('[data-toggle="datepicker"]').datepicker();
		
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
		/* . CONTROLLS END ===================== */


});