var EventEngine = EventEngine || {};

EventEngine.events = [];
EventEngine.handlers = {};

EventEngine.registerEvent = function( eventName, eventParams ){

	EventEngine.events[ EventEngine.events.length ] = {eventName:eventName, eventParams: eventParams, fired: false };
	console.log(' NOW EVENTS REGISTERED ');
	console.log(EventEngine.events);
	EventEngine.fireEvents();
};


EventEngine.registerEventFromRawAjax = function ( data ){
	if( typeof data.eventName == 'string' && typeof data.eventParams != 'undefined' ){
		console.log('event recieved from ajax ' + data.eventName + 'withparams ');
		console.log( data.eventParams)
		EventEngine.registerEvent ( data.eventName, data.eventParams );
	}
};

EventEngine.fireEvents = function() {
	console.log(' //Firing events ');

	for( var k in EventEngine.events  ){

		//Если есть такой обработчик
		//Todo последовательное выполнение
		console.log(' event... ');
		console.log( EventEngine.events[k] );

		if( (typeof EventEngine.handlers[ EventEngine.events[k].eventName + 'Handler' ] != 'undefined') &&   EventEngine.events[k].fired == false ){
			console.log( 'Such handler ('+ EventEngine.events[k].eventName + 'Handler'  +') exists and Event Not Fired');
			console.log( ' ****** NOW HANDLER FUNCTION WILL BE FIRED ');
				console.log('firing' + EventEngine.events[k].eventName + 'Handler');
			 EventEngine.handlers[ EventEngine.events[k].eventName + 'Handler' ] ( EventEngine.events[k].eventParams );
			 EventEngine.events[k].fired = true;
		}

	}
	console.log('registerEvent');
};

EventEngine.registerHandler = function( eventName, f, predefinedParams ){
	console.log('registering handler ' + eventName+'Handler');
	EventEngine.handlers[eventName+'Handler'] = f;
	console.log(EventEngine.handlers);
};


//=====================================================================================

//Вызов события по JavaScript - хендлер ПОСЛЕ добавления бейджа - красивый попап
EventEngine.registerHandler( 'newBadge', function(params){
	var badge_id = params.badge_id,
		url = ajaxUrls['getBadgeInfo'];

		console.log( 'registering...' );
		console.log( params );
		console.log( { badge_id: badge_id } );
		console.log( { url } );

		$.ajax({
			url: url, 
			data: { badge_id: badge_id },
			dataType: 'json',
			success: function( data ){
				//fireNewBadgePopup( data );
				//TODO new Event - updateUserPoints
				window.fireNewBadgePopup(data.badge);
				console.log(data);
				//alert(data.badge.name);


			}
		})

} );