<?php
	session_start();
?>

<?php
	//set local variables empty 
	$email = $pswd = $status = "";
	$payment = $discount = $no_Of_Person = $ticket_Cost = "";
	
	$email = $_SESSION['user_info']['userEmail'];
	$pswd = $_SESSION['user_info']['userPassword'];
	
	//Calculate ticket cost
	function flightCost($no_Of_Person, $ticket_Cost)
	{
		$total = "";
		
		$no_Of_Person * $ticket_Cost;
		return $total;
	}
	
	//calculate discount if user exist
	function processDiscount($payment)
	{
		$dis = "";
		
		$dis = $payment * 0.2;
		return $dis;
	} //end processDiscount
	
	$email = $_SESSION['user_info']['userEmail']; 
	$pswd = $_SESSION['user_info']['userPassword']; 
	$ticket_Cost = $_SESSION['flight_cost']['flight_charge']; 
	$no_Of_Person = $_SESSION['book_info']['passenger'];
	
	//check if customer exist 
	if ($email != "" && $pswd != "")
	{
		$status = 0;
		//registered customer discount calculation
		$discount = processDiscount($payment);
		$payment = flightCost($no_Of_Person, $ticket_Cost) + $discount;
		/*
		//varibles for payment session
		try {
			//database connection
			include("connection.php");
			
			//search parameters
			$string1 = "select flight_cost.flightID,flightName,depatureCity,destinationCity,depatureDate,AmountOfSeats,cost";
			//join parameters
			$string2 = "join flight_cost on flight.flightID = flight_cost.flightID";
			//where parameters
			$string3 = "depatureCity='$depCity' and destinationCity='$arrCity' and depatureDate='$dDate'";
					
			//search database for matchig flights
			$query = "$string1 from flight $string2 where $string3";					
			$stmt = $conn->prepare($query);
			$stmt->bindParam('depatureCity', $depCity, PDO::PARAM_STR);
			$stmt->bindValue('destination', $arrCity, PDO::PARAM_STR);
			$stmt->bindValue('depatureDate', $dDate, PDO::PARAM_STR);
			$stmt->execute();
			$count = $stmt->rowCount();
			$row   = $stmt->fetch(PDO::FETCH_ASSOC);
			  
			//validates if matchig flight was found
			if($count > 0 && !empty($row)) 
			*/	
	} //end if
	else
	{
		$status = 1;
		//no discount for non-registered customer
		$payment = flightCost($no_Of_Person, $ticket_Cost);
	} //end else
		
	//test status
	$status = 1;
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Flight Payment</title>
	<!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	
	<meta charset="utf-8">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="assets/style.css">

	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<style>
		/* Gradient transparent - color - transparent */
		hr {
			border: 0;
			height: 3px;
			background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
		}
		
		.modal-body {
			margin: auto;
			padding: 20px;
			width: 450px;
			position: relative;
			border-radius: 7px;
			background: rgba(255, 255, 255, 0.75);
		}
		
		h5 {
			color: blue;
			text-align: center;
		}
		
		h3 {
			color: white;
			font-size: 25px;
		}
		
		/* Gradient transparent - color - transparent */
		hr {
			border: 0;
			height: 3px;
			background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
		}
		
		body { 
			  background: url(assets/images/home.jpg) no-repeat center center fixed; 
			  -webkit-background-size: cover;
			  -moz-background-size: cover;
			  -o-background-size: cover;
			  background-size: cover;
		}
	</style>
</head>
<body>
	
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" role="navigation">
	    <div class="container">
	        <h3>FLIGHT PAYMENT</h3>
	        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
	            &#9776;
	        </button>
	        <div class="collapse navbar-collapse" id="exCollapsingNavbar">
	            <ul class="nav navbar-nav flex-row justify-content-between ml-auto">
	                <li class="nav-item">
	                    <button type="button" class="btn btn-outline-primary">
							<a href="index.php" class="nav-link">Log Out</a>
						</button>
	                </li>
	            </ul>
	        </div>
	    </div>
	</nav>
	<br><br>
	
	<?php
		//form to collect not existing customer information
		if( $status == 1)
		{
			echo "
			<div class='modal-body'>
				<h5>PAYMENT INFRORMATION</h5>
				<hr/>
				<!-- form starts here -->
				<form action='' method='POST'>
					<div class='form-row'>
						<div class='col-6'>
							<input type='text' class='form-control' placeholder='First Name' name='userFirstName'>
						</div>
						<div class='col-6'>
							<input type='text' class='form-control' placeholder='Last Name' name=userLastName'>
						</div>
					</div>
					<br>
					<div class='form-row row'>
						<div class='col'>
							<input type='email' class='form-control' name='userEmail' placeholder='Email'>
						</div>
					</div>
					<br>
					<div class='form-row row'>
						<div class='col'>
							<input type='password' class='form-control' name='userPassword' placeholder='Password'>
						</div>
					</div>
					<br>
					<div class='form-row'>
						<div class='col-6'>
							<select class='form-control placeholder'>
							   <option value=''>Select Card Type</option>
							   <option value='1'>American Express</option>
							   <option value='2'>MasterCard</option>
							   <option value='3'>Discover</option>
							   <option value='4'>Visa</option>
							   <option value='5'>PayPal</option>
							</select>
						</div>
						<div class='col-6'>
						  <input type='text' class='form-control' placeholder='Credit Card Number' name='userCCNum'>
						</div>
					</div>
					<br>
					<div class='form-row'>
						<div class='col'>
						  <input type='text' class='form-control' placeholder='Address' name='userAddress'>
						</div>
					</div>
					<br><br>
					<div class='col-xs-1' align='right' >
						<button type='button' class='btn btn-primary' name='confirmBtn'>Confirm</button>
					</div>
				</form>
			</div>
			<br><br><br>
			";
		} //end if
	?>
	
	<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------> 
	<!--Scripts for form validation-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>

	<script src="assets/js/formValidation.js"></script>


	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------> 
	
</body>
</html>
