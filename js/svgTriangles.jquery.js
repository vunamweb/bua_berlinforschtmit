jQuery.fn.svgTriangles = function(options) {
	
	// support multiple elements
    if (this.length > 1){
        this.each(function() { $(this).svgTriangles(options) });
        return this;
    }
	
	
	
	/************************************************/
	/* VARIABLES [Ext] */
	
	// DEFAULT Settings
	var defaults = {
		size: {w: 50, h: 50},
		speed: 5,
		className: 'off',
		classNameOn: 'on',
		classNameTmp: 'tmp'
	};
	
	// Override defaults and merge to settings
	var settings = $.extend({}, defaults, options);
	
	
	
	/************************************************/
	/* VARIABLES [Private] */
	
	// Maximum values
	var max = { 
		w: 0, h: 0,
		x: 0, y: 0 
	};
	
	
	
	/************************************************/
	/* PUBLIC FUNCTIONS */
	
	// First run call
	this.initialize = function() {
		max.w = $(this).width();
		max.h = $(this).height();
		max.x = Math.floor($(this).width() / settings.size.w);
		max.y = Math.floor($(this).height() / settings.size.h);
		
		createTriangles(this);
		
		return this;
	};
	
	// Randomly switch class to new
	this.switchRandomOn = function(speed) {
		switchRandom(this, speed);
	};
	
	this.switchRandomOff = function(speed) {
		switchRandom(this, speed, settings.classNameOn, settings.className);
	};
	
	
	
	/************************************************/
	/* PRIVATE FUNCTIONS */
	
	// Get new SVG Tag that works with jQuery
	var newSVG = function(tagName, attrObj) {
		let newSvgDomEl = document.createElementNS('http://www.w3.org/2000/svg', tagName);
		return $(newSvgDomEl).attr(attrObj);
	};
	
	// Return value if between (Min / Max)
	var mm = function(num, max) {
		return Math.max(Math.min(num, max), 0);
	};
	
	// Get random number
	var randNum = function(min, max) {
		if ( min === 0 ) {
			min = 1;
			max += 1;
			
			return (Math.floor(Math.random() * max) + min) - 1;
		} else return Math.floor(Math.random() * max) + min;
	};
	
	// Select random triangle
	var getRandPoly = function(pObj, className) {
		className = className || settings.className;
		
		var polyObjs    = $(pObj).find('polygon.' + className),
			numPolyObjs = polyObjs.length;
		
		return $(polyObjs).eq(randNum(0, numPolyObjs));
	};
	
	// Calculate triangle downside
	var triangleDown = function(iX, iY) {
		var x1 = mm( iX * settings.size.w 		,max.w),
			y1 = mm( iY * settings.size.h 		,max.h),
			
			x2 = mm( x1 + settings.size.w 		,max.w),
			y2 = mm( y1 						,max.h),
			
			x3 = mm( x1 + settings.size.w / 2 	,max.w),
			y3 = mm( y1 + settings.size.h 		,max.h);

		var p1 = x1 + ',' + y1,
			p2 = x2 + ',' + y2,
			p3 = x3 + ',' + y3;
		
		return p1 + ' ' + p2 + ' ' + p3;
	};
	
	// Calculate triangle upside
	var triangleUp = function(iX, iY) {
		var x1 = mm( iX * settings.size.w 		,max.w),
			y1 = mm( iY * settings.size.h 		,max.h),
			
			x2 = mm( x1 + settings.size.w / 2	,max.w),
			y2 = mm( y1 + settings.size.h		,max.h),
			
			x3 = mm( x1	- settings.size.w / 2	,max.w * 2),
			y3 = mm( y2  						,max.h);

		var p1 = x1 + ',' + y1,
			p2 = x2 + ',' + y2,
			p3 = x3 + ',' + y3;
		
		return p1 + ' ' + p2 + ' ' + p3;
	};
	
	// Generate the triangles
	var createTriangles = function(pObj) {
		for ( var iY = 0; iY < max.y; iY++ ) {
			for ( var iX = 0; iX <= max.x; iX++ ) {
				var elID = 'c' + iY + 'r' + iX;
				
				//if ( iX % 2 ) {
					$(pObj).append(newSVG('polygon', {
						points: triangleUp(iX, iY),
						id: elID,
						'class': settings.className
					}));
				//} else {
					if ( iX < max.x ) {
						$(pObj).append(newSVG('polygon', {
							points: triangleDown(iX, iY),
							id: elID,
							'class': settings.className
						}));
					}
				//}
				
			}
		}
	};
	
	// Randomly switch class to new
	var switchRandom = function(pObj, speed, fromClassName, toClassName) {
		speed         = speed || settings.speed;
		fromClassName = fromClassName || settings.className;
		toClassName   = toClassName || settings.classNameOn;
		
		$(pObj).find('polygon.' + fromClassName).addClass(settings.classNameTmp);
		
		while ( $(pObj).find('polygon.' + settings.classNameTmp).length > 0 ) {
			var polyObj = getRandPoly(pObj, settings.classNameTmp),
				delay   = 100 * randNum(1, speed);
			
			if ( polyObj.length > 0 ) {
				polyObj.removeClass(settings.classNameTmp);
				
				$(polyObj).delay(delay).queue(function(next){
					$(this).removeClass(fromClassName).addClass(toClassName);
					next();
				});
			}
		}
	};
	
	
	
	/************************************************/
	/* RUN */
	
	return this.initialize();
};