 


$(document).ready(function(){



 
		$(document).on('click','.js-follow-person', function(){
			var user_id = $(this).data('user_id'),
				that  = this;
			if( $(this).hasClass('followed') ){
				return false;
			}

			 $.ajax({
			 	url: ajaxUrls['addFollower'],
			 	data: {user_id: user_id},
			 	type: 'get',
			 	dataType: 'json',
			 	success: function(data){
			 		console.log(data);

			 		if( data.success ){
			 			$(that).addClass('followed');
			 			$(that).css('opactiy', 0.7);
			 			$(that).text('Добавлен');
			 		}

			 	}
			 });


			 return false;
		});
 


});