<?php

	$servername = "localhost";
	$username = "cp3407";
	$password = "n1NYsXrS72BvjfA0";
	$dbname = "cp3407";
	
	$time = time();
	
	$connection = mysqli_connect($servername, $username, $password, $dbname);
	
	mysqli_query($connection, "INSERT INTO users (username, email, isVerified, password, lastLogon, homeTown, phoneNumber) VALUES ('Storm', 'storm.jones@my.jcu.edu.au', '1', 'hfj3r4h9fu839fh8u3rh7', '$time', 'Townsville', '0411111111')");

?>