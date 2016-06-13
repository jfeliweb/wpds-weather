jQuery(document).ready(function ($) {
	$('.weather').each(function(){
		var elem = $(this);
		$.simpleWeather({
			location: elem.attr('data-place'),
			unit: elem.attr('data-unit'),
			success: function(weather) {
				html = '<i class="icon weather-'+weather.code+'"></i><span class="temperature">'+weather.temp+'&deg;'+weather.units.temp+'<br /><span class="condition">'+weather.currently+'</span>';
				elem.html(html);
			},
			error: function(error) {
				elem.html('<p>'+error+'</p>');
			}
		});
	});
});
