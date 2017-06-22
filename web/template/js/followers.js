 


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

			 	 	var p = $(that).parents('.profileview-aside-follower'),
			 	 		toShow = p.find('.js-unfollow-person');

			 	 		toShow.removeClass('js-hidden');
			 	 		$(that).addClass('js-hidden');

			 	}
			 });


			 return false;
		});

 
		$(document).on('click','.js-unfollow-person', function(){
			var user_id = $(this).data('user_id'),
				that  = this;
			if( $(this).hasClass('followed') ){
				return false;
			}

			 $.ajax({
			 	url: ajaxUrls['removeFollower'],
			 	data: {user_id: user_id},
			 	type: 'get',
			 	dataType: 'json',
			 	success: function(data){
			 		console.log(data);
					var p = $(that).parents('.profileview-aside-follower'),
		 	 		toShow = p.find('.js-follow-person');

		 	 		toShow.removeClass('js-hidden');
		 	 		$(that).addClass('js-hidden');
			 		 

			 	}
			 });


			 return false;
		});
 


});