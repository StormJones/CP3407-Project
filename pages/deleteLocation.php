<?php

	require 'database.php';
	
	$userid = 1;
	
	if(isset($_GET['location']))
	{
		
		$location = $_GET['location'];
		mysqli_query($connection, "DELETE FROM favorites WHERE userid = '$userid' AND city = '$location'");
		
		header("Location: map.php?location=$location");
		
	}

?>