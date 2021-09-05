<?php
	
	// Static API Key for OpenWeather API
	$APIKEY = "47eedbe51652e1f27b7337a28f386f22";
	
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
	
	// close curl resource
	curl_close($curl);


?>



<html>
	<head>
		<title>API Test One</title>
	</head>
	<body>
		<h1>API Test One</h1>
		<h2>Using OpenWeather API</h2>
		<hr>
		<b>Using API Key: </b><u><?php echo $APIKEY; ?></u><br /><br />
		<b>Output:</b><br />
		<?php echo $output; ?>
	</body>
</html>