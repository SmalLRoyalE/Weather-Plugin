<?php
/*
Plugin Name: Weather Plugin
Description: Display current weather information.
Author: Akash Prasad
*/

function get_weather_data($city = 'Delhi') {
    $api_key = 'YOUR-OPENWEATHERMAP-API'; //09f98fccb011192cff645499ca8016e3 or use this
    $base_url = 'https://api.openweathermap.org/data/2.5/weather';

    // Determine the location to query (current location or Delhi)
    $query = ($city === 'Delhi') ? 'q=Delhi' : "lat=LATITUDE&lon=LONGITUDE"; // Replace LATITUDE and LONGITUDE with actual coordinates for current location if needed.

    $request_url = "$base_url?$query&appid=$api_key";

    $response = wp_remote_get($request_url);

    if (is_array($response)) {
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body);

        return $data;
    } else {
        return false;
    }
}

function display_weather() {
    $current_weather = get_weather_data(); // Fetch weather data for Delhi
    if ($current_weather) {
        $city = $current_weather->name;
        $description = $current_weather->weather[0]->description;
        $temperature = $current_weather->main->temp - 273.15; // Temperature in Celsius
        $humidity = $current_weather->main->humidity;

        echo "<h2>Weather in $city</h2>";
        echo "<p>Description: $description</p>";
        echo "<p>Temperature: $temperature °C</p>";
        echo "<p>Humidity: $humidity%</p>";
    } else {
        echo "Error fetching weather data.";
    }
}

add_shortcode('current_weather', 'display_weather');
