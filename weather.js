jQuery(document).ready(function ($) {
	setTimeout(updateWeather, 500);
	// Update weather every half hour
	setInterval(updateWeather, 30 * 60 * 1000);
});

function updateWeather() {
	jQuery('.weather').each(function(){
		var elem = jQuery(this);
		jQuery.simpleWeather({
			location: elem.attr('data-place'),
			unit: elem.attr('data-unit'),
			success: function(weather) {
				//elem.css('background-image', 'url(' + weather.image  + ')');
				html = '';
				html += '<i class="icon weather-'+weather.code+'"></i>';
				html += '<span class="temperature">'+weather.temp+'&deg; '+weather.units.temp+'';
				html += '<span class="condition">'+weather.currently+'</span>';
				html += '</span>';
				elem.html(html);
			},
			error: function(error) {
				elem.html('<p>'+error+'</p>');
				setTimeout(updateWeather, 1 * 60 * 1000);
			}
		});
	});
}
