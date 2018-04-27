<!DOCTYPE html>
<html>
<head>
	<title>Airline Tickets</title>
	<meta charset="utf-8">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="assets/style.css">

	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body background="assets/images/home.jpg">
	<div class="container-fluid">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" role="navigation">
	    <div class="container">
	        <a class="navbar-brand" href="#">View Flights</a>
	    </div>
	</nav>
	<div class="displayLayout">

	<?php
		session_start();
		//calculate discount if user exist
		function processDiscount($payment)
		{
			$discount = $payment * 0.2;
			return $discount;
		} //end processDiscount	
			
		//local variables
		$depCit = $desCity = $dDate = $arDate = $msg = "";
		
		//set values 
		// $depCit = $_SESSION['depatureCity'];
		// $desCity = $_SESSION['destination'];
		// $dDate =  $_SESSION['depatureDate'];
		// $aDate = $_SESSION['returnDate'];
		

		if($depCit != "" && $desCity != "" && $desCity != "") 
			{	
			try {
					//database connection
					include("connection.php");
					
					//search database for user

					$query = ("SELECT * FROM flight WHERE 1");

					//$query = "select * from flight where depatureCity=$depCit and destinationCity=$desCity and depatureDate=$dDate";					
					$stmt = $conn->prepare($query);
					$stmt->bindParam('depatureCity', $depCit, PDO::PARAM_STR);
					$stmt->bindValue('destination', $desCity, PDO::PARAM_STR);
					$stmt->bindValue('depatureDate', $dDate, PDO::PARAM_STR);
					$stmt->execute();
					$count = $stmt->rowCount();
					$row   = $stmt->fetch(PDO::FETCH_ASSOC);
				  
					//validates if matchig flight was found
					//validates if matchig flight was found


					if($count > 0 && !empty($row)) 
					{
						/******************** Display available flights***********************/
						// $fl_msg = "<label style='color: blue'> CHOOSE YOUR FLIGHT OPTION...!</label>";
						// echo "<br>";
						// echo $fl_msg;
						
						
						while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
						{	
							echo'<div class="row">
									<div class="col-md-6">
										<div class="card">
										<div class="row">
											<div class="card-body col-9">
												<strong>Flight ID:</strong> '.$row['flightID']. ' <strong>Flight Name:</strong> ' .$row['flightName']. '
												<br>
												<strong>From:</strong> ' .$row['depatureCity']. ' <strong>To</strong>: ' .$row['destinationCity']. '
												<br>
												<strong>Depart Date:</strong> ' .$row['depatureDate']. ' <strong>Return Date:</strong> ' .$row['returnDate']. '
												<br>
												<strong>Available Seats:</strong> ' .$row['AmountOfSeats']. '
											</div>
											<div class="card-body col-3">
												<a href="#" class="btn btn-primary text-center">Select</a>
											</div>
										</div>
										</div>
									</div>
								</div>
							<br>';


							} //end while
						
						// Free result set
						unset($result);
						
						//header("location:MyProfile.php");
					} // end if
					else
					{
						$msg = '<label style="color:red">No flights are available for that date...!</label>';
					} //end else
								
					//close database connection
					$conn = null;
				} 
				catch (PDOException $e) 
				{
					$msg = "Error : ".$e->getMessage();
				} //end catch
			}
		

	?>

	</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>

	<script src="assets/js/formValidation.js"></script>


	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>