<?php
	
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
                <a class="nav-link" href="#">Sign out</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg> Home<span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg> Favourites
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg> Alerts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Profile
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Saved Locations</span>
              <a class="d-flex align-items-center text-muted" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
              </a>
            </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> Brisbane
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> Townsville
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> Newcastle
                            </a>
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



    