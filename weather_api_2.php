<?php
$apikey ="QFIlKf2cy3y9GM3EGnGddJmNLpGBl3vG";
$forecast_content = fopen("http://dataservice.accuweather.com/forecasts/v1/daily/1day/3494540?apikey=$apikey&language=en-us&metric=true", "r");
$daily_forecasts = stream_get_contents($forecast_content);
fclose($forecast_content);
$dayForecast = json_decode($daily_forecasts, true);
print $dayForecast;
?>

<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>testSite</title>
</head>
<body>


</body>
</html>
