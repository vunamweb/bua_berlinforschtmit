<?php

	global $maps, $dir;

	$maps = '

<script src="https://maps.google.com/maps/api/js?key=AIzaSyC0q7EC_0bYKE44cC-70DIxLY6T-CeL1Uk" type="text/javascript"></script>

<script type="text/javascript">
	function createMap(lat, lng, zoomVal) {
	    var mapOptions ={
	        center: new google.maps.LatLng(lat, lng),
	        zoom: zoomVal,
	        scrollwheel: false,
	        zoomControl: true,
	        zoomControlOptions: {
	            position: google.maps.ControlPosition.LEFT_CENTER
	        },
	//        mapTypeId: google.maps.MapTypeId.SATELLITE,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
	//        mapTypeId: google.maps.MapTypeId.HYBRID,
	//        mapTypeId: google.maps.MapTypeId.TERRAIN,
	//        styles : [{featureType:\'all\',stylers:[{"color": "#f5f5f5"},{saturation:-61.8},{gamma:1},{lightness:40}]
	        styles :
[
    {
        "featureType": "all",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "weight": "2.00"
            }
        ]
    },
    {
        "featureType": "all",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#9c9c9c"
            }
        ]
    },
    {
        "featureType": "all",
        "elementType": "labels.text",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f2f2f2"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#ffffff"
            }
        ]
    },
    {
        "featureType": "landscape.man_made",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#ffffff"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 45
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#eeeeee"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#7b7b7b"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "color": "#ffffff"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#46bcec"
            },
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#c8d7d4"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#070707"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "color": "#ffffff"
            }
        ]
    }
]


	    };

	    map = new google.maps.Map(document.getElementById("google-map"), mapOptions);

		var image = "'.$dir.'images/map-icon.png";
		var marker = new google.maps.Marker({
	      position: new google.maps.LatLng(lat, lng),
	      map: map,
	      icon: image
		});

	}
	var map;

	function initialize() {
	  createMap('.$text.');
	  // console.log("here");

	}

	google.maps.event.addDomListener(window, \'load\', initialize);

</script>
';



	$output .= '<section id="google-map" class="gmap slider-parallax"></section>'.$maps;


$morp= "Google MAP";

?>