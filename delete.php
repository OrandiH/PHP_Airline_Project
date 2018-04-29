<?php
 

    $deluser= $_GET['deluser'];

    $servername = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
    $dbName = "airlines_db";

    
	$pdo = new PDO("mysql:host=$servername;dbname=$dbName",$dbUsername,$dbPassword);
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
	$stmt = $pdo->prepare('DELETE FROM customer_login WHERE username = :email');
        $stmt->execute(array(
            ':email'=> $deluser));

        $deleteStmt = $pdo->prepare('DELETE FROM customer WHERE username = :email');
        $deleteStmt->execute(array(':email'=> $deluser));
    
        if($deleteStmt && $stmt)
    {
        echo'<script>alert("DELETED");window.location="adminDashboard.php" </script>';
    }

?>



