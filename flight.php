<?php 
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Book Flight</title>
	<!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="assets/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
	<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css">
</head>
<body background="assets/images/home.jpg" >
	
	<div class="container-fluid">
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" role="navigation">
			<div class="container">
				<h6 style="color: white; font-size: 30px;">FLIGHT OPTION</h6>
				<button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
					&#9776;
				</button>
				<div class="collapse navbar-collapse" id="exCollapsingNavbar">
					<ul class="nav navbar-nav flex-row justify-content-between ml-auto">
						<li class="nav-item"><a href="index.php" class="nav-link">View Profile</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
	
	<!-- form starts here -->
	<form action="bookFlight.php" method="POST">
		<?php
			//calculate discount if user exist
			function processDiscount($payment)
			{
				$discount = $payment * 0.2;
				return $discount;
			} //end processDiscount	
				
			//database connection
			include("connection.php");
			//local variables
			$depCit = $desCity = $dDate = $msg = "";
			
			//set values 
			$depCit = $_SESSION['depatureCity'];
			$desCity = $_SESSION['depatureCity'];
			$dDate =  $_SESSION['depatureDate'];
			
			if($depCit != "" && $desCity != "" && $desCity != "") 
			{
				try {
					//search database for user
					$query = "select * from flight where depatureCity='$depCit' and destinationCity='$desCity' and depatureDate='$dDate'";					
					$stmt = $conn->prepare($query);
					$stmt->bindParam('depatureCity', $depCit, PDO::PARAM_STR);
					$stmt->bindValue('destinationCity', $desCity, PDO::PARAM_STR);
					$stmt->bindValue('depatureDate', $dDate, PDO::PARAM_STR);
					$stmt->execute();
					$count = $stmt->rowCount();
					$row   = $stmt->fetch(PDO::FETCH_ASSOC);
				  
					//validates if user was found
					if($count > 0 && !empty($row)) 
					{
						/******************** Display available flights***********************/
						$msg = "<label style='color:green'> Choose your flight option...!</label>";
						echo $msg;
						//Database starts here -->
						echo "<table>
							<tr>
								<th>FLIGHT ID</th> 
								<th>FLIGHT NAME</th> 
								<th>DEPATURE CITY</th>
								<th>DESTINATION CITY</th>
								<th>DEPATUREDATE</th>
								<th>RETURNDATE</th>
								<th>AMOUNTOFSEATS</th>
							</tr>";
							// output data of each row
							while($row   = $stmt->fetch(PDO::FETCH_ASSOC)) 
						    {
								echo "<tr>"
										"<td>" . $row["flightID"] . "</td>"
										"<td>" . $row["flightName"] . "</td>"
										"<td>" . $row["depatureCity"]. "</td>"
										"<td>" . $row["destinationCity"]. "</td>"
										"<td>" . $row["depatureDate"]. "</td>"
										"<td>" . $row["returnDate"]. "</td>"
										"<td>" . $row["AmountOfSeats"]. "</td>"
									"</tr>";
							} //end while
						echo "</table>";
						
						//header("location:MyProfile.php");
					}
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
				}  //end if
				else 
				{
					$msg = '<label style="color:red">You MUST enter fligh details first...!</label>';
				} //end else	
				
				echo"<br>";
				echo $msg;
	?>

	
	<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------> 
	<!-- Bootstrap Script Links --> 
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
	<!-- jQuery first, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/js/bootstrap.js"></script>
	<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------> 
	
</body>
</html>
