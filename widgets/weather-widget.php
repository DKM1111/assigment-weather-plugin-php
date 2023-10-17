class Weather_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'weather_widget',
            'Weather Widget',
            array('description' => 'Display weather information for the current location or Delhi')
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        echo $args['before_title'] . 'Weather Widget' . $args['after_title'];
        $weather_data = get_weather_data();
        // Process and display weather data here
        echo $args['after_widget'];
    }
}
