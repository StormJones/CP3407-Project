<?php

	session_start();
	require 'database.php';
	
	if(isset($_POST['email']))
	{
		// Do login stuff
		
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirmpassword = $_POST['confirmpassword'];
		
		if($password != $confirmpassword)
		{
			die('passwords don\'t match!');
		}
		
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		mysqli_query($connection, "INSERT INTO user (email, password) VALUES ('$email', '$hashedPassword')");
		header('Location: login.php');
		
	}


?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="..\Images\Logo.png">

    <title>Aussie Weather | Sign Up</title>

    <!-- Core CSS -->
    <link rel="stylesheet" type="text/css" href="../css/corestylesheet.css">
    
    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="../css/signupstylesheet.css">

</head>

<body class="text-center">

    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        
        <a class="navbar-brand" href="#">Aussie Weather</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

        <div class="collapse navbar-collapse" id="navbarsExample03">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="map.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Return to Login</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="content">
        <form class="form-signin" action='' method='POST'>
            <img class="mb-4" src="..\Images\Logo.png" alt="" width="150" height="150">
            <h1 class="h3 mb-3 font-weight-normal">Welcome!</h1>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" name='email' id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name='password' id="inputPassword" class="form-control" placeholder="Select Password" required="">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name='confirmpassword' id="confirmPassword" class="form-control" placeholder="Confirm Password" required="">
            <p class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols</p>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Create Account</button>
            <p class="mt-5 mb-3 text-muted">Aussie Weather © 2021</p>
        </form>
    </div>

</body>

</html>