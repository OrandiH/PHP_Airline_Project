<?php 
session_start();
	try {			
		$conn = new PDO('mysql:host=localhost;dbname=airlines;charset=utf8mb4', 'root', '');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);  
	} catch (PDOException $e) {
		echo "Connection failed : ". $e->getMessage();
	} //end catch
?>