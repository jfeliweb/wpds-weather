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


class weather_plugin extends WP_Widget {

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
	<label for="<?php echo $this->get_field_id('select'); ?>"><?php _e('Fahrenheit or Celsius', 'wpds-weather'); ?></label>
	<select name="<?php echo $this->get_field_name('select'); ?>" id="<?php echo $this->get_field_id('select'); ?>" class="widefat">
	<?php
	$options = array('f', 'c');
	foreach ($options as $option) {
	echo '<option value="' . $option . '" id="' . $option . '"', $select == $option ? ' selected="selected"' : '', '>', $option, '</option>';
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
		echo '<link rel="stylesheet" href="'. plugins_url( 'weather.css' , __FILE__ ) .'">';
		echo '<script type="text/javascript">var units ="' . $select . '";var place ="' . $place . '";</script>';
		echo '<script src="'. plugins_url( 'weather.js' , __FILE__ ) .'"></script>';
		echo '<div id="weather"></div>';
		echo $after_widget;
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("weather_plugin");'));
