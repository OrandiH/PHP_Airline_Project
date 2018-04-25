<?php 
	//Define variables for database access
	$serverName = "localhost";
	$dbUserName = "root";
	$dbPassword = "";
	$dbName = "Airlines_DB";
	
	//establish database connection		
	$conn = new PDO("mysql:host=$serverName;dbname=$dbName",$dbUserName,$dbPassword);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//set the default PDO fetch mode to object
	$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
?>


