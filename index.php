<?php
// init Latitude and Longitude
$lat    = -6.200000; //Jakarta Latitude
$long   = 106.816666; //Jakarta Longitude

// use your API key here
$key  = "";

// URL of the API endpoint
$apiUrl = "api.openweathermap.org/data/2.5/forecast?lat=$lat&lon=$long&appid=$key";
// Initialize cURL session
$ch     = curl_init($apiUrl);
// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Execute cURL session and fetch the response
$response = curl_exec($ch);
// $data = json_decode($response);
// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}
// Close cURL session
curl_close($ch);

// Process the response
if ($response) {
    // Your code to handle the API response
    $data = json_decode($response, true);

    if (isset($data['list'])) {
        $filteredData = array_filter($data['list'], function ($forecast) {
            return date('H', $forecast['dt']) == 15;
        });

        foreach ($filteredData as $forecast) {
            $timestamp          = $forecast['dt'];
            $date               = date('D, d M Y', $timestamp);
            $temperatureKelvin  = $forecast['main']['temp'];
            $temperatureCelsius = $temperatureKelvin - 273.15;

            echo "{$date}: {$temperatureCelsius}°C<br/>";
        }
    } else {
        echo 'Invalid API response.';
    }
} else {
    echo 'No response from the API';
}
?>