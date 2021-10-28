<?php

	require 'database.php';
	
	$userid = 1;
	
	if(isset($_GET['location']))
	{
		
		$location = $_GET['location'];
		mysqli_query($connection, "INSERT INTO favorites (userid, city) VALUES ('$userid', '$location')");
		
		header("Location: map.php?location=$location");
		
	}

?>