<?php
	session_start();
	
	//------------------------ Clean Form Data --------------------------------------------------------//
	function Clean_Data($data) 
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
				
		return $data;
	} //end function

	//calculate discount if user exist
	function processDiscount($payment)
	{
		$dis = "";
		
		$dis = $payment * 0.2;
		return $dis;
	} //end processDiscount
	
	//Calculate ticket cost
	function flightCost($no_Of_Person, $ticket_Cost)
	{
		$total = "";
		
		$total = $no_Of_Person * $ticket_Cost;
		return $total;
	}
	//---------------------------------------------------------------------------------------//
	
	//set local login variables empty 
	$username = $password = $login = $display = $msg = "";
	//set local payment variables empty 
	$payment = $discount = $no_Of_Person = $ticket_Cost = $confirmNum = "";
	
	//define variables and set to empty values
	$fname = $lname = $email = $address = $cardNum = "";
	$fnameErr = $lnameErr = $emailErr = $addressErr =  $cardNumErr = "";
	$error = false;
	
	//local flight variables empty
	$trip = $depCity = $arrCity = $dDate = $rDate = $flightId = $flightName = "";
	if(isset($_SESSION['flight_info']) && isset($_SESSION['users'])){
		//local flight variables to session
	$flightId = $_SESSION['flight_info']['flightId'];
	$flightName = $_SESSION['flight_info']['flightName'];
	$depCity = $_SESSION['flight_info']['departure'];
	$arrCity = $_SESSION['flight_info']['arrival'];
	$dDate = $_SESSION['flight_info']['departDate'];
	$trip = $_SESSION['flight_info']['tripType']; 
	
	//check if oneway or round trip flight
	if (empty($_SESSION['flight_info']['returnDate']) && $trip != "round trip")
	{
		$rDate = "";
	}
	else{
		$rDate = $_SESSION['flight_info']['returnDate'];
	}
	
	$ticket_Cost = $_SESSION['flight_info']['flightCost'];
	$no_Of_Person = $_SESSION['flight_info']['passenger'];
	
	//set confirmation Number
	$confirmNum = rand(10101100011, 1);
	
	//set local variables using sesssion
	$username = $_SESSION['users'][0]['userName'];
	$password = $_SESSION['users'][0]['password'];
	
	//check if customer exist 
	if ($username != "" && $password != "")
	{
		//registered customer discount calculation
		$discount = processDiscount($ticket_Cost);
		$payment = flightCost($no_Of_Person, $ticket_Cost) - $discount;
		
		//varibles for payment session
		try {
			//database connection
			include("db.php");
			
			$stmt = $DBcon->prepare("SELECT firstName,lastName,credit_card_Num FROM customer WHERE userName=:username and password=:password");
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':password', $password);	
			$stmt->execute();
			$count = $stmt->rowCount();
			$row   = $stmt->fetch(PDO::FETCH_ASSOC);
			//validates if matching user/customer was found
			if($count == 1) 
			{
				$fname = $row['firstName'];
				$lname = $row['lastName'];
				$cardNum = $row['credit_card_Num'];	

				//initialize queries for inserting into DB
				$sql1 = "INSERT INTO booked_flights (flightID,userName) VALUES 
				('$flightId','$username')";
				$sql2 = "INSERT INTO customer_payment (userName,confirmationNum,amount_received) VALUES 
				('$username','$confirmNum','$payment')";
				echo "<br><br><br>";
				
				//execute query commands
				$DBcon->exec($sql1);
				$DBcon->exec($sql2);
			} //end if
			else
			{
				$msg = '<label style="color:red; font-size: 25px; margin: 0px;">No flights are available for that date...!</label>';
			} //end else
			
			//free queries set
			unset($stmt);
			unset($sql);
			unset($sq2);
			
			//close database connection
			$DBcon = null;
			
			//set login status for payment
			$login = 1;
			
		} //end try
		catch (PDOException $e) 
		{
			$msg = '<label style="color:red; font-size: 25px; margin: auto;">Error :' .$e->getMessage(). '</label>';
		} //end catch
			
	}
 } //end if
	else 
	{
		header("location:guestPayment.php");
		//set login status for payment
		$login = 0;
		//show non-user form
		$display = 1;
	}	
	echo"<br>";
	echo $msg;
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Flight Payment</title>
	<!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="assets/style.css">

	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	
	<style>		
		.inner-container {
			color: white;
			width: 300px;
			margin: auto;
			border-radius: 10px;
			background: red;
			-webkit-animation: mymove 5s infinite; /* Safari 4.0 - 8.0 */
			animation: mymove 5s infinite;
		}

		/* Safari 4.0 - 8.0 */
		@-webkit-keyframes mymove {
			50% {background-color: blue;}
		}

		@keyframes mymove {
			50% {background-color: blue;}
		}
		
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
			text-align: center;
		}
		
		h4 {
			text-align: center;
			color: white;
			font-size: 15px;
		}
		
		h3 {
			color: white;
			font-size: 25px;
		}
		
		h2 {
			color: white; 
			font-family:bookman;
		}
		
		/* Gradient transparent - color - transparent */
		hr {
			color: white;
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
		
		.text-danger {
			font-size: 10px;
		}
		
		table{
			font-size: 12px;
			border-spacing: 5px;
			border-collapse: separate;
			padding-top: 50px;
			padding-right: 50px;
			padding-bottom: 80px;
			padding-left: 60px;
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
	                    <button class="btn btn-outline-primary">
							<a href="logoutCustomer.php">Back to home</a>
						</button>
	                </li>
	            </ul>
	        </div>
	    </div>
	</nav>
	<br><br><br><br>
	<div  class="text-center">
		<h2>FLIGHT RESERVATION PAYEMENT PROCESSING<h2>
		<?php 
			// Prints the day, date, month, year, time, AM or PM
			echo "<label style='font-size:25px; font-family:bookman;'> CURRENT DATE: "  . date('l jS \of F Y') . "</label>";
		?>
		<hr style="width: 500px; font-family:bookman;">
	</div>
	<br><br><br>
	<?php
		//form to collect non existing customer information
		if( $login == 0 && $display  == 1)
		{
			echo "
				<div class='inner-container'>
					<hr>
					<h4> ENTER YOUR PAYEMENT INFORMATION TO COMPLETE BOOKING <h4>
					<hr>
				</div>
				<br>
				<div class='modal-body'>
				
					<h5>PAYMENT INFRORMATION</h5>
					<hr/><hr/>
					<br>
					<!-- form starts here -->
					<form id='info' action='guestPayment.php' method='POST'>
						<div class='form-row'>
							<div class='col-6'>
								<input type='text' class='form-control' placeholder='First Name' name='fname' value='$fname'>";
								echo "<span class='text-danger'>"; if (isset($fnameErr)) echo $fnameErr;  echo "</span>
							</div>
							<div class='col-6'>
								<input type='text' class='form-control' placeholder='Last Name' name='lname' value='$lname'>";
								echo "<span class='text-danger'>"; if (isset($lnameErr)) echo $lnameErr;  echo "</span>
							</div>
						</div>
						<br>
						<div class='form-row row'>
							<div class='col'>
								<input type='email' class='form-control' name='email' placeholder='Email' value='$email'>";
								echo "<span class='text-danger'>"; if (isset($emailErr)) echo $emailErr;  echo "</span>
							</div>
						</div>
						<br>
						<div class='form-row'>
							<div class='col-6'>
								<select class='form-control placeholder' name='cardType'>
								   <option value=''>Select Card Type</option>
								   <option value='1'>American Express</option>
								   <option value='2'>MasterCard</option>
								   <option value='3'>Discover</option>
								   <option value='4'>Visa</option>
								   <option value='5'>PayPal</option>
								</select>";
								 echo "<span class='text-danger'>"; if (isset($cardTypeErr)) echo $cardTypeErr;  echo "</span>
							</div>
							<div class='col-6'>
							  <input type='number' class='form-control' placeholder='Credit Card Number' name='cardNum' value='$cardNum'>";
							   echo "<span class='text-danger'>"; if (isset($cardNumErr)) echo $cardNumErr;  echo "</span>
							</div>
						</div>
						<br>
						<div class='form-row'>
							<div class='col'>
							  <input type='text' class='form-control' placeholder='Address' name='address' value='$address'>";
							  echo "<span class='text-danger'>"; if (isset($addressErr)) echo $addressErr;  echo "</span>
							</div>
						</div>
						<br><br>
						<div class='col-xs-1' align='right' >
							<button type='submit' class='btn btn-primary' name='paymentBtn'>Make Payment</button>
						</div>
					</form>
				</div>
				<br><br><br>
			";
		} //end if
	?>
	
	
	
	<?php
	//Valid user for oneway
		if( $login == 1 && $trip == "oneway")
		{
			echo "
				<div class='table-responsive' style='display: flex; flex-flow: row wrap; justify-content: center;'>
					<table class='table' style='background-color: white; width: 70%;'>
						<tr> 
							<th>
								PREPARED FOR &nbsp &nbsp $lname / $fname
								<br><br>
								<p>AIRLINE RESERVATION CODE &nbsp &nbsp $flightId-11001</p>
								<p>CONFIRMATION NUMBER &nbsp &nbsp $confirmNum</p>
							</th>
						</tr>
						<tr> 
							<td>
								<p> 
									DEPARTURE DATE &nbsp &nbsp $dDate &nbsp 
									Please verify flight time Prior to departure
								</p>
								
							</td>
						</tr>
						<tr> 
							<td style='background-color: #D3D3D3;'>
								<p> 
									$flightName
								</p>
								<p>
									Duaration: N/A
								</p>
								<p>
									Class: N/A
								</p>
								<p>
									Status: Confirmed
								</p>
							</td>
							<td>
								<p> 
									Departing At: $depCity 
								</p>
								<p> 
									Departing time: N/A
								</p>
								<p> 
									Terminal: N/A
								</p>
							</td>
							<td>
								<p> 
									Arriving At: $arrCity
								</p>
								<p> 
									Departing time: N/A
								</p>
								<p> 
									Terminal: N/A
								</p>
							</td>
							<td>
								<p> 
									Aircraft: $flightId
								</p>
								<p> 
									Distance (in Miles): N/A
								</p>
								<p> 
									Stop(s): 0
								</p>
								<p> 
									Meal: Dinner, Breakfast
								</p>
							</td>
						</tr>
						<tr> 
							<td>
								<br>
							<td>
						</tr>
						<tr style='background-color: #D3D3D3;'> 
							<td>
								Passenger Name: &nbsp &nbsp $lname / $fname
							<td>
							<td>
								Seats: Check-in Required
							<td>
						</tr>
						<tr style='background-color: #ADD8E6;'> 
							<td>
								<p>
									Notes: &nbsp &nbsp AIR FAIR IS INCLUSIVE OF TAXES
								</p>
								<p>
									Trip type: &nbsp &nbsp $trip
								</p>
								<p>
									Passenger(s): &nbsp &nbsp $no_Of_Person
								</p>
								<p>
									Discount: &nbsp &nbsp $discount
								</p>
								<p>
									Cost: &nbsp &nbsp $payment
								</p>
							<td>
							<td>
								<p>
									PAYMENT INFORMATION
								</p>
								<p>
									Card #(in hash format): &nbsp &nbsp $cardNum
								</p>
							<td>
						</tr>
					</table>
					
					<br><br>
					<div class='col-xs-12' style='margin-left: 1150px;'>
						<button type='button' class='btn btn-success' name='printBtn' onclick='printpage()'>Print</button>
					</div>
					<br><br>
				</div>
			";
		} //end if
	?>
	
	<?php
	//Valid user for round trip
		if( $login == 1 && $trip == "round trip")
		{
			echo "
				<div class='table-responsive' style='display: flex; flex-flow: row wrap; justify-content: center;'>
					<table class='table' style='background-color: white; width: 70%;'>
						<tr> 
							<th>
								PREPARED FOR &nbsp &nbsp $lname / $fname
								<br><br>
								<p>AIRLINE RESERVATION CODE<br/> $flightId-11001</p>
								<p>CONFIRMATION NUMBER &nbsp &nbsp $confirmNum</p>
							</th>
						</tr>
						</table>
				</div>";
		} //end if
	?>
	
	
	<!--- jQuery first, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/js/bootstrap.js"></script>
	
	
</body>
</html>
