var EventEngine = EventEngine || {};

EventEngine.events = [];
EventEngine.handlers = {};

EventEngine.registerEvent = function( eventName, eventParams ){

	EventEngine.events[ EventEngine.events.length ] = {eventName:eventName, eventParams: eventParams, fired: false };
	console.log(EventEngine.events);
	EventEngine.fireEvents();
};


EventEngine.registerEventFromRawAjax = function ( data ){
	if( typeof data.eventName == 'string' && typeof data.eventParams != 'undefined' ){
		EventEngine.registerEvent ( data.eventName, data.eventParams );
	}
};



EventEngine.fireEvents = function() {

	for( var k in EventEngine.events  ){

		//Если есть такой обработчик
		//Todo последовательное выполнение
		if( (typeof EventEngine.handlers[ EventEngine.events[k].eventName + 'Handler' ] != 'undefined') &&   EventEngine.events[k].fired == false ){
				console.log('firing' + EventEngine.events[k].eventName + 'Handler');
			 EventEngine.handlers[ EventEngine.events[k].eventName + 'Handler' ] ( EventEngine.events[k].eventParams );
			 EventEngine.events[k].fired = true;
		}

	}
	console.log('registerEvent');
};

EventEngine.registerHandler = function( eventName, f, predefinedParams ){
	EventEngine.handlers[eventName+'Handler'] = f;
};


//=====================================================================================


EventEngine.registerHandler( 'newBadge', function(params){
	var badgeId = params.badgeId,
		url = ajaxUrls['getBadgeInfo'];

		console.log( params );
		console.log( { badge_id: badgeId } );

		$.ajax({
			url: url, 
			data: { badge_id: badgeId },
			dataType: 'json',
			success: function( data ){
				//fireNewBadgePopup( data );
				console.log(data);
				alert(data.badge.name);
			}
		})

} );