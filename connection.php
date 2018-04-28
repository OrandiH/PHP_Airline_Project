<?php 
<<<<<<< HEAD
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


=======
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
>>>>>>> 6aed7924a3f6628fd0f17bbd1dc5fde09a52f15f
