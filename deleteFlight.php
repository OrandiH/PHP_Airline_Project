<?php
 

    $delflight= $_GET['delflight'];

    $servername = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
    $dbName = "airlines_db";

    
	$pdo = new PDO("mysql:host=$servername;dbname=$dbName",$dbUsername,$dbPassword);
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
	$stmt = $pdo->prepare('DELETE FROM flight_cost WHERE flightID = :del');
    $stmt->execute(array(
        ':del'=> $delflight));

        $deleteStmt = $pdo->prepare('DELETE FROM flight WHERE flightID = :del');
        $deleteStmt->execute(array(
            ':del'=> $delflight));
    
        if($deleteStmt && $stmt)
    {
        echo'<script>alert("DELETED");window.location="adminDashboard.php" </script>';
    }

?>
