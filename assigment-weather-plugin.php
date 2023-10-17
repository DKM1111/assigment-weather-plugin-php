<?php
/*
Plugin Name: Assignment Weather Plugin
Description: Display weather information for the current location or Delhi.
Version: 1.0
Author: Dinesh Kumar (Developer)
*/

// Define the function to get weather data
function get_weather_data() {
    $api_key = '5b66833d7d5b5cb31c75d48dd41166c0';
    $city = 'Delhi';
    $url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$api_key";
    $response = wp_remote_get($url);
    $data = wp_remote_retrieve_body($response);
    return json_decode($data);
}

// Define the Weather Widget class and widget logic here
class Weather_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'weather_widget',
            'Weather Widget',
            array('description' => 'Display weather information for the current location or Delhi')
        );
    }

    // Widget display logic goes here
    public function widget($args, $instance) {
        echo $args['before_widget'];
        echo $args['before_title'] . 'Weather Widget' . $args['after_title'];
        $weather_data = get_weather_data();

        if ($weather_data && isset($weather_data->main) && isset($weather_data->weather[0])) {
            $location = 'Delhi'; // Replace with actual location
            $temperature = isset($weather_data->main->temp) ? round($weather_data->main->temp - 273.15, 1) . '°C' : 'N/A';
            $description = isset($weather_data->weather[0]->description) ? ucfirst($weather_data->weather[0]->description) : 'N/A';
            $icon = isset($weather_data->weather[0]->icon) ? $weather_data->weather[0]->icon : 'N/A';

            echo "<div class='weather-widget'>";
            echo "<div class='weather-location'>$location</div>";
            echo "<div class='weather-data'>";
            $icon_url = 'https://png.pngtree.com/element_origin_min_pic/16/12/31/4da1dba69e7a6e5b9ee165983ce47629.jpg';
            echo "<div class='weather-icon'><img src='$icon_url' alt='$description'></div>";
            // echo "<div class='weather-icon'><img src='http://openweathermap.org/img/wn/$icon.png' alt='$description'></div>";
            echo "<div class='weather-temperature'>$temperature</div>";
            echo "<div class='weather-description'>$description</div>";
            echo "</div></div>";
        } else {
            echo "Failed to fetch weather data.";
        }

        echo $args['after_widget'];
    }
}

// Enqueue the CSS file for your widget
function enqueue_widget_css() {

    wp_enqueue_style('weather-widget-css', plugin_dir_url(__FILE__) . 'weather-widget.css', array(), '1.0.1');

}
add_action('wp_enqueue_scripts', 'enqueue_widget_css');

// Register the widget
function register_weather_widget() {
    register_widget('Weather_Widget');
}
add_action('widgets_init', 'register_weather_widget');
