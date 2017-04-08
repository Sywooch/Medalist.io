countInterests = function(){
	return $('.interests-button-selected:visible').length;
};
$(document).ready(function(){

	/* REGISTRATION */

		/* interests selector */

		$('.js-interest-selector-takeinterest').on('click', function(){
			var text = $(this).text(),
				id = $(this).data('id'),
				handler = $('.interests-selector-selected'),
				dummy = $('<div class="interests-button-selected mdlst-button">'+text+' <div class="mdlst-button-closer js-interest-selector-removeinterest"></div></div> '),
				track = $('.interests-selector-scale-track');

			dummy.data('id', id);
			dummy.css('display', 'none');

			handler.append( dummy );
			dummy.fadeIn(function(){track.css('margin-left', '-'+((5-countInterests())/5)*100+'%' );});
			$(this).fadeOut();
			 

		});

		$(document).on('click', '.js-interest-selector-removeinterest', function(){
			var p = $(this).parents('.interests-button-selected'),
				id = p.data('id'),
				track = $('.interests-selector-scale-track');
					 
			p.fadeOut(function(){track.css('margin-left', '-'+ ((5-countInterests())/5)*100+'%' );});
			$('.js-interest-selector-takeinterest[data-id="'+id+'"]').fadeIn();
		});
	/* . REGISTRATION END */


});