$(function() {
	var tri = $('div#svg svg').svgTriangles({
		size: {w: 100, h: 100},
		speed: 25
	});
	
	$('img').show();
	tri.switchRandomOn();
	
	var i = true;
	setInterval(function() {
		if ( i ) {
			tri.switchRandomOff();
		} else tri.switchRandomOn();
		
		i = !i;
	}, 2000);
	
});