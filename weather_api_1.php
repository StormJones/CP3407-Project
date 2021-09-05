<?php
	
	// Static API Key for OpenWeather API
	$APIKEY = "c4e44b0722840790c67497825f9084d9";
	
	// Search Location
	$location = "Townsville";
	
	// Constructed API URL
	$weatherURL = "api.openweathermap.org/data/2.5/weather?q=$location&appid=$apiKey";
	
	// Create & initialize a curl session
	$curl = curl_init();

	// Set url
	curl_setopt($curl, CURLOPT_URL, $weatherURL);

	// Return the transfer as a string, also with setopt()
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	// curl_exec() executes the started curl session
	$output = curl_exec($curl);
	
	echo $output;

	// close curl resource
	curl_close($curl);


?>