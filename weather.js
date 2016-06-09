jQuery(document).ready(function ($) {
  $.simpleWeather({
    location: place,
    //woeid: '',
    unit: units,
    success: function(weather) {
      html = '<i class="icon weather-'+weather.code+'"></i><span class="temperature">'+weather.temp+'&deg;'+weather.units.temp+'<br /><span class="condition">'+weather.currently+'</span>';

      $("#weather").html(html);
    },
    error: function(error) {
      $("#weather").html('<p>'+error+'</p>');
    }
  });
});
