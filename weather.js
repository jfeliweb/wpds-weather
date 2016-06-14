jQuery(document).ready(function ($) {
	updateWeather();
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
				html = '<i class="icon weather-'+weather.code+'"></i><span class="temperature">'+weather.temp+'&deg;'+weather.units.temp+'<span class="condition">'+weather.currently+'</span>';
				elem.html(html);
			},
			error: function(error) {
				elem.html('<p>'+error+'</p>');
			}
		});
	});
}
