var geocoder;
var map;
$(document).ready(function() {
	var cityName = getParameterByName('q');
	if (cityName) {
		$('#cityName').val(cityName);
		google.maps.event.addDomListener(window, 'load', search(cityName));
	} else {
		google.maps.event.addDomListener(window, 'load', initialize);
	}
	$(document).keypress(function(e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			search($('#cityName').val());
		}
	});
	$("#search").click(function() {
		search($('#cityName').val());
	});
});
function initialize() {
	geocoder = new google.maps.Geocoder();
	var latlng = new google.maps.LatLng(13.7246005, 100.6331108);
	var mapOptions = {
		zoom : 13,
		center : latlng
	}
	map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}
function search(cityName) {
	initialize();
	if (cityName) {
		changeUrlParam('q', cityName);
		codeAddress(cityName);
	} else {
		alert('Please type the city name.');
	}
}
function codeAddress(address) {
	$('body').loading({
		theme : 'dark'
	});
	geocoder.geocode({
		'address' : address
	}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			$.ajax({
				method : "POST",
				url : baseUrl + 'tweets/gettweets',
				dataType : "json",
				data : {
					lat : results[0].geometry.location.A,
					lng : results[0].geometry.location.F,
					city : address
				}
			}).done(function(tweetsObject) {
				getTweetsObjectSuccess(tweetsObject, results);
			});
		} else {
			alert('Geocode was not successful for the following reason: '
					+ status);
			$('body').loading('stop');
		}
	});
}
function getTweetsObjectSuccess(tweetsObject, results) {
	map.setCenter(results[0].geometry.location);
	var image = {
		url : '',
		size : new google.maps.Size(48, 48),
		origin : new google.maps.Point(0, 0),
		anchor : new google.maps.Point(0, 0)
	};
	$.each(tweetsObject, function(i, tweet) {
		image.url = tweet.userProfileImageUrl
		var myLatLng = new google.maps.LatLng(tweet.lat, tweet.lng);
		var marker = new google.maps.Marker({
			map : map,
			position : myLatLng,
			icon : image,
			title : tweet.userName
		});
		var infowindow = new google.maps.InfoWindow({
			content : tweet.text + ' When ' + tweet.createdAt
		});
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map, marker);
		});
	});
	$('.labels').text('TWEETS ABOUT ' + $('#cityName').val());
	$('body').loading('stop');
}
function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex
			.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g,
			" "));
}
function getURLParameter(name) {
	return decodeURIComponent((new RegExp('[?|&]' + name + '='
			+ '([^&;]+?)(&|#|;|$)').exec(location.search) || [ , "" ])[1]
			.replace(/\+/g, '%20'))
			|| null;
}
function changeUrlParam(param, value) {
	var currentURL = window.location.href + '&';
	var change = new RegExp('(' + param + ')=(.*)&', 'g');
	var newURL = currentURL.replace(change, '$1=' + value + '&');
	if (getURLParameter(param) !== null) {
		try {
			window.history.replaceState('', '', newURL.slice(0, -1));
		} catch (e) {
			console.log(e);
		}
	} else {
		var currURL = window.location.href;
		if (currURL.indexOf("?") !== -1) {
			window.history.replaceState('', '', currentURL.slice(0, -1) + '&'
					+ param + '=' + value);
		} else {
			window.history.replaceState('', '', currentURL.slice(0, -1) + '?'
					+ param + '=' + value);
		}
	}
}