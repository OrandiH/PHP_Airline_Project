<?php 
// session_start();

	$serverName = "localhost";
	$dbUserName = "root";
	$dbPassword = "";
	$dbName = "Airlines_db";


	try {			
		$conn = new PDO("mysql:host=$serverName;dbname=$dbName",$dbUserName,$dbPassword);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);  
	} catch (PDOException $e) {
		echo "Connection failed : ". $e->getMessage();
	} //end catch
?>