<?php

$flightID = $_GET["flightid"];

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "airlines_db";

$pdo = new PDO("mysql:host=$servername;dbname=$dbName",$dbUsername,$dbPassword);
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);

$sql = 'SELECT * FROM flight WHERE flightID = :flightID';
		
$stmt = $pdo->prepare($sql);
$stmt->execute(['flightID'=> $flightID]);
$results = $stmt->fetchAll(); 
    
$flightID = $results[0]-> flightID;
$flightName = $results[0]-> flightName;
$depatureCity = $results[0]-> depatureCity;
$destinationCity = $results[0]-> destinationCity;
$depatureDate = $results[0]-> depatureDate;
$returnDate = $results[0]-> returnDate;
$AmountOfSeats = $results[0]-> AmountOfSeats;


//flight Cost
$con = new PDO("mysql:host=$servername;dbname=$dbName",$dbUsername,$dbPassword);
$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);

$sql = 'SELECT * FROM flight_cost WHERE flightID = :flightID';
		
$stmt = $con->prepare($sql);
$stmt->execute(['flightID'=> $flightID]);
$ans = $stmt->fetchAll(); 
    
$cost = $ans[0]-> cost;

if($_POST)
{ 
	if(empty($_POST['flightID']))
	{
		$flightID = $flightID;
	}
	else
	{
	$flightID = $_POST['flightID'];
	}
	//
	if(empty($_POST['flightName']))
	{
		$flightName=$flightName;
	}else
	{
	$flightName = $_POST['flightName'];
	}
	//
	if(empty($_POST['depatureCity']))
	{
	}
	else{
	$depatureCity = $_POST['depatureCity'];
	}
	
	if(empty($_POST['destinationCity']))
	{
		$destinationCity = $destinationCity;
	}else
	{
	$destinationCity = $_POST['destinationCity'];
	}
	if(empty($_POST['depatureDate']))
	{
		$depatureDate = $depatureDate;
	}
	else{
	$depatureDate = $_POST['depatureDate'];
	}
	if(empty($_POST['returnDate']))
	{
		$returnDate = $returnDate;
	}
	else{
	$returnDate= $_POST['returnDate'];
	}
	if(empty($_POST['AmountOfSeats']))
	{
		$AmountOfSeats = $AmountOfSeats;
	}
	else
	{
	$AmountOfSeats = $_POST['AmountOfSeats'];
	}
	if(empty($_POST['cost']))
	{
		$cost = $cost;
	}
	else
	{
		$cost = $_POST['cost'];
	}
	
	$conn = new PDO("mysql:host=$servername;dbname=$dbName",$dbUsername,$dbPassword);
	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
	
	$sql = 'UPDATE flight set flightID = :flightID, flightName = :flightName, depatureCity = :depatureCity, 
				destinationCity = :destinationCity, depatureDate =:depatureDate, returnDate =:returnDate, AmountOfSeats=:AmountOfSeats
				WHERE flightID = :flightID';
	$stmt = $con->prepare($sql);
    $stmt->execute(array(':flightID'=> $flightID,
						':flightName'=>$flightName,
						':destinationCity'=>$destinationCity,
						':depatureCity'=>$depatureCity,
						':depatureDate'=>$depatureDate,
						':returnDate'=> $returnDate,
						':AmountOfSeats' =>$AmountOfSeats,
	));
   
	$con2 = new PDO("mysql:host=$servername;dbname=$dbName",$dbUsername,$dbPassword);
	$con2->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$con2->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
	
	$sql2 = 'UPDATE flight_cost set flightID = :flightID, cost = :cost WHERE flightID = :flightID';
	$updatestmt = $con2->prepare($sql2);
    $updatestmt->execute(array(':flightID'=> $flightID,
						':cost'=> $cost));
	
	if($updatestmt)
	{
		echo '<script>alert("RECORD UPDATED");window.location="adminDashboard.php" </script>';
	}
}
?>



<!doctype html>
<html>
<head></head>
<title></title>
<body>
	<form method='POST'>
		<input type = "Text" name="flightID" value="<?php echo $flightID;?>">
		<input type = "Text" name="flightName" value="<?php echo $flightName;?>">
		<input type = "Text" name="depatureCity" value="<?php echo $depatureCity;?>">
		<input type = "Text" name="destinationCity" value= "<?php echo $destinationCity;?>">
		<input type = "Date" name="depatureDate" value="<?php echo $depatureDate;?>">
		<input type = "Date" name="returnDate" value="<?php echo $returnDate;?>">
		<input type = "Number" name="AmountOfSeats" value="<?php echo $AmountOfSeats;?>">
		<input type = "Number" name="cost" value="<?php echo $cost;?>">
		<input type = "Submit" name="update" value="update">
		
	</form>
</body>

</html>