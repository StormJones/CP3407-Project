<?php

	session_start();
	require 'database.php';
	
	if(!isset($_SESSION['userid']))
		header("Location: login.php");
	
	// Static API Key for OpenWeather API
	$APIKEY = "85a2b9dc008241e1a6131919210509";
	
	// Search Location
	$location = "Australia";
	if(isset($_GET['location']))
		$location = $_GET['location'];
	
	
	
	// Static API Key for OpenWeather API
	$WEATHERAPI_APIKEY = "85a2b9dc008241e1a6131919210509";
	$ACCUWEATHER_APIKEY ="QFIlKf2cy3y9GM3EGnGddJmNLpGBl3vG";
	
	$weatherURL = "http://api.weatherapi.com/v1/current.json?key=$WEATHERAPI_APIKEY&q=$location&aqi=no";
	$useAccuWeather = false;
	if(isset($_GET['useAccuweather']))
	{
		$useAccuWeather = true;
		$weatherURL = "http://dataservice.accuweather.com/forecasts/v1/daily/1day/3494540?apikey=$ACCUWEATHER_APIKEY&language=en-us&metric=true";
	}	
	
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
	
	$jsonEncoded = json_decode($output, true);
	
	// Ignore these variables
	$ignoreList = array(
		"last_updated_epoch",
		"last_updated",
		"is_day",
		"wind_degree",
		"pressure_in",
		"pressure_mb",
		"cloud",
		"condition",
	);
	
	
	// Feed value into this and if it finds a match it'll spit out a new string (used to clean up variable names for output)
	function FindOverWriteName($value_name)
	{
	
		$renameList = array(
			array("temp_c", "Temperature (Celsius)"),
			array("temp_f", "Temperature (Fahrenheit)"),
			array("wind_mph", "Wind Speed (mph)"),
			array("wind_kph", "Wind Speed (kph)"),
			array("wind_dir", "Wind Direction"),
			array("precip_mm", "Percipitation (mm)"),
			array("precip_in", "Percipitation (inch)"),
			array("humidity", "Humidity"),
			array("feelslike_c", "Feels Like (Celsius)"),
			array("feelslike_f", "Feels Like (Fahrenheit)"),
			array("vis_km", "visibility (km)"),
			array("vis_miles", "visibility (miles)"),
			array("uv", "UV Rating"),
			array("gust_mph", "Gust (mph)"),
			array("gust_kph", "Gust (kph)"),
		);
		
		for($i = 0; $i < count($renameList); $i++)
		{
			if(in_array($value_name, $renameList[$i]))
				return $renameList[$i][1];
		}
		return $value_name;
	}
	
	$locationName = '';
	if(!$useAccuWeather)
	{
		if(!empty($jsonEncoded['location']))
		{
			$locationName = $jsonEncoded['location']['name'];
		}
	}

?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="..\Images\Logo.png">

    <title>Aussie Weather | National Map</title>

    <link rel="stylesheet" type="text/css" href="../css/dashboardstylesheet.css">

    <!-- Core CSS -->
    <link rel="stylesheet" type="text/css" href="../css/corestylesheet.css">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="../css/graphstylesheet.css">

</head>

<body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Aussie Weather</a>
		<form action='' method='GET' class=' w-100 m-0 p-0'>
			<input class="form-control form-control-dark w-100" type="text" name='location' value='<?php echo $locationName; ?>' placeholder="Search" aria-label="Search" style='height:40px;'>
        </form>
		<ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="logout.php">Sign out</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Saved Locations</span>
              <a class="d-flex align-items-center text-muted" href="addLocation.php?location=<?php echo $locationName; ?>" title='Click here to save this location as a favorite'>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
              </a>
            </h6>
                    <ul class="nav flex-column mb-2">
					
						<?php
							$getAllFavorites = mysqli_query($connection, "SELECT * FROM favorites WHERE userid = '1'");
							while($displayAllFavorites = mysqli_fetch_assoc($getAllFavorites))
							{
								?>
									<li class="nav-item">
										<a class="nav-link" href="map.php?location=<?php echo $displayAllFavorites['city']; ?>">
											<a href='deleteLocation.php?location=<?php echo $displayAllFavorites['city']; ?>' title='Delete Favorite'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
</svg></a> <?php echo $displayAllFavorites['city']; ?>
										</a>
									</li>
								<?php
							}
						?>						
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                <div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                    <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                        <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                        <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                    </div>
                </div>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">National Map</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href='map.php?useAccuweather=true&&location=<?php echo $location ?>'><button class="btn btn-sm <?php if($useAccuWeather){echo "btn-secondary";}else{echo "btn-outline-secondary";} ?>">ACCU Weather</button></a>
                            <a href='map.php?location=<?php echo $location ?>'><button class="btn btn-sm <?php if(!$useAccuWeather){echo "btn-secondary";}else{echo "btn-outline-secondary";} ?>">Weather API</button></a>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary" id="export">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            Export
                        </button>
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        Current Data
                    </button>
                    </div>
                </div>
				<p><?php if(empty($locationName)){echo "No Match Found!";} ?></p>
				<div class='row <?php if(empty($locationName)){echo "d-none";} ?>'>
					<div class='col-6'>
							<iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCAcl6EcxM-CWyev9tAuZY-yjV0TsjV5tU&q=<?php echo $locationName; ?>" height="600" style="border:0; width:100%;" allowfullscreen="" loading="lazy"></iframe>
					</div>
					<div class='col-6'>
						<h2><?php echo $locationName; ?> Weather Report</h2>
						<h6>Last Updated: <?php 
							if(!$useAccuWeather)
							{
								echo $jsonEncoded['current']['last_updated']; 
							}else{
								echo $jsonEncoded['Headline']['EffectiveDate']; 
							}
						?></h6>
							<div class="table-responsive">
								<table class="table table-striped table-sm">
									<?php
										if(!$useAccuWeather)
										{
											for($i = 0; $i < count($jsonEncoded['current']); $i++)
											{
												$value_name = array_keys($jsonEncoded['current'])[$i];
												
												if(in_array($value_name, $ignoreList))
													continue;
												
												echo "<tr>
													<th>".FindOverWriteName($value_name)."</th>
													<td>".$jsonEncoded['current'][$value_name]."</td>
												</tr>";
											}
										}elseif($baseArrayName == "Headline"){
											
											/*
											
												ACCUWEATHER HERE!
											
											*/
											
										}
									?>
								</table>
							</div>
					</div>
				</div>
                
                
            </main>
        </div>
    </div>

</body>

</html>



    