$(document).ready(function(){





 var map;
var egglabs = new google.maps.LatLng(13.0630171, 80.2296082);
var mapCoordinates = new google.maps.LatLng(13.0630171, 80.2296082);


var markers = [];
var image = new google.maps.MarkerImage(
    '9lessons.png',
    new google.maps.Size(84,56),
    new google.maps.Point(0,0),
    new google.maps.Point(42,56)
  );

function addMarker() 
{
      markers.push(new google.maps.Marker({
      position: egglabs,
      raiseOnDrag: false,
	  icon: image,
      map: map,
      draggable: false
      }));
      
}



function initialize() {
  var mapOptions = {
   center: mapCoordinates,
 							zoom: 8,
							panControl: false,
							zoomControl: true,
							mapTypeControl: false,
							scaleControl: false,
							streetViewControl: false,
							overviewMapControl: false,
							scrollwheel: false,
							
							zoomControlOptions: {
					    style: google.maps.ZoomControlStyle.SMALL
					  },

    mapTypeId: google.maps.MapTypeId.ROADMAP,
	styles: [
			  {
			    "featureType": "landscape.natural",
			    "elementType": "geometry.fill",
			    "stylers": [
			      { "color": "#000" }
			    ]
			  },
			  {
				    "featureType": "landscape.man_made",
				    "stylers": [
				      { "color": "#ffffff" },
				      { "visibility": "off" }
				    ]
			  },
			  {
				    "featureType": "water",
				    "stylers": [
				       { "color": "#80C8E5" },
				      { "saturation": 0 }
				    ]
			  },
			  {
				    "featureType": "road.arterial",
				    "elementType": "geometry",
				    "stylers": [
				      { "color": "#999999" }
				    ]
			  }
			 ,{
				    "elementType": "labels.text.stroke",
				    "stylers": [
				      { "visibility": "off" }
				    ]
			  }
				,{
				    "elementType": "labels.text",
				    "stylers": [
				      { "color": "#333333" }
				    ]
				  }
				
				,{
				    "featureType": "road.local",
				    "stylers": [
				      { "color": "#dedede" }
				    ]
				  }
				,{
				    "featureType": "road.local",
				    "elementType": "labels.text",
				    "stylers": [
				      { "color": "#666666" }
				    ]
				  }
				,{
				    "featureType": "transit.station.bus",
				    "stylers": [
				      { "saturation": -57 }
				    ]
				  }
				,{
				    "featureType": "road.highway",
				    "elementType": "labels.icon",
				    "stylers": [
				      { "visibility": "off" }
				    ]
				  },{
				    "featureType": "poi",
				    "stylers": [
				      { "visibility": "off" }
				    ]
				  }
			
			]
    
  };


map = new google.maps.Map(document.getElementById('g-map'),mapOptions);
addMarker();



 
}

google.maps.event.addDomListener(window, 'load', initialize);


});