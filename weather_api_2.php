<?php
// setting APIKey for easy  access.
$apikey ="QFIlKf2cy3y9GM3EGnGddJmNLpGBl3vG";

// set URL variable to have easy access to
$URL = "http://dataservice.accuweather.com/forecasts/v1/daily/1day/3494540?apikey=$apikey&language=en-us&metric=true";

// open URL and stream get to get data through resource
$forecast_content = fopen($URL, "r");
$daily_forecasts = stream_get_contents($forecast_content);
fclose($forecast_content);
?>

<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>testSite</title>
</head>
<>
    <h1>API TestSite 2</h1>
    <h2> <a href="https://developer.accuweather.com/">Accuweather API</a></h2>
    <b>API Key: </b><u><?php print $apikey; ?> </u>
    <br>
    <b>Output: </b>
    <br>
    <?php print $daily_forecasts;?>


</body>
</html>
