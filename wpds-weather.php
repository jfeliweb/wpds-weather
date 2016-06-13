<?php

/*
Plugin Name: WPDS Weather Widget
Plugin URI: http://pixelydo.com/work/wordpress-digital-signage/
Description: The weather for WPDS. Many thanks to @fleetingftw for SimpleWeatherJS.
Author: Nate Jones
Version: 1.0
Author URI: http://pixelydo.com/
Text Domain: wpds-weather
*/

// Load text domain
function wpds_weather_load_plugin_textdomain() {
    load_plugin_textdomain( 'wpds-weather', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'wpds_weather_load_plugin_textdomain' );


class wpds_weather_widget extends WP_Widget {

	/**
	* Constructor
	*/
	function __construct() {
		parent::__construct(
			'wpds-weather-widget',
			__('The Weather', 'wpds-weather'),
			array(
				'description' => __( 'A simple weather indicator for the dock.', 'wpds-weather' ), 
			)
		);
	}

	/**
	* Widget form creation
	*/
	function form($instance) {
		// Check values
		if( $instance) {
			$place = esc_attr($instance['place']);
			$select = esc_attr($instance['select']);
		} else {
			$place = '';
			$select = '';
		}
		?>
<p>
	<label for="<?php echo $this->get_field_id('place'); ?>"><?php _e('Your location', 'wpds-weather'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('place'); ?>" name="<?php echo $this->get_field_name('place'); ?>" type="text" value="<?php echo $place; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('select'); ?>"><?php _e('Temperature scale', 'wpds-weather'); ?></label>
	<select name="<?php echo $this->get_field_name('select'); ?>" id="<?php echo $this->get_field_id('select'); ?>" class="widefat">
	<?php
	$options = array(
		'c' => __('Celsius'),
		'f' => __('Fahrenheit'), 
	);
	foreach ($options as $k => $v) {
		echo '<option value="' . $k . '" id="' . $k . '"', $select == $k ? ' selected="selected"' : '', '>', $v, '</option>';
	}
	?>
	</select>
</p>
		<?php
	}

	/**
	* Update widget
	*/
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance['place'] = strip_tags($new_instance['place']);
		$instance['select'] = strip_tags($new_instance['select']);
		return $instance;
	}

	/**
	* Display widget
	*/
	function widget($args, $instance) {
		extract( $args );
		// these are the widget options
		$place = $instance['place'];
		$select = $instance['select'];
		echo $before_widget;
		// Display the widget
		echo '<div class="weather" data-unit="' . $select . '" data-place="' . $place . '"></div>';
		echo $after_widget;
	}
}

/**
* Register and load the widget
*/
function wpds_weather_load_widget() {
    register_widget( 'wpds_weather_widget' );
}
add_action( 'widgets_init', 'wpds_weather_load_widget' );

/**
* Load scripts and styles
*/
function wpds_weather_load_scripts()
{
	wp_register_style( 'wpds-weather-style', plugins_url( '/weather.css', __FILE__ ) );
	wp_enqueue_style( 'wpds-weather-style' );

	wp_register_script( 'simpleWeather', '//cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.1.0/jquery.simpleWeather.min.js', array ('jquery'), false, false);
	wp_enqueue_script( 'simpleWeather' );

	wp_register_script( 'wpds-weather-script', plugins_url( '/weather.js', __FILE__ ), array('jquery'), false, true );
	wp_enqueue_script( 'wpds-weather-script' );
}
add_action( 'wp_enqueue_scripts', 'wpds_weather_load_scripts' );
