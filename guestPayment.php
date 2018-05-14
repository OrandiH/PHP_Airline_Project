<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{		
    $login = 0;
    $error = false;
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
    $username = $password = $login = $display = $msg = "";
	//set local payment variables empty 
	$payment = $discount = $no_Of_Person = $ticket_Cost = $confirmNum = "";
	
	//define variables and set to empty values
	$fname = $lname = $email = $address = $cardNum = "";
	$fnameErr = $lnameErr = $emailErr = $addressErr =  $cardNumErr = "";
	$error = false;
	
	//local flight variables empty
    $trip = $depCity = $arrCity = $dDate = $rDate = $flightId = $flightName = "";
    
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
     //------------------------ Validate Form Data --------------------------------------------------------//
        if(isset($_POST['paymentBtn']))
        {
        $fname = Clean_Data($_POST["fname"]);
        $lname = Clean_Data($_POST["lname"]);
        $email = Clean_Data($_POST["email"]);
        $address = Clean_Data($_POST["address"]);
        $cardNum = Clean_Data($_POST["cardNum"]);
            //first name validation
            if (empty($_POST["fname"]))
            {
                $fnameErr = "*FIRST NAME is required...!";
                $error = true;
            } 
            else if(preg_match("/^([A-Z]{1})([A-Za-z-])?/", $_POST["fname"]) == false)
            {
                $fnameErr = "*First name must begin with a CAPITAL letter...!";	
                $error = true;
            }
            else if (strlen($_POST["fname"]) > 30)
            {
                $fnameErr = "*First name must be 30 characters or less...!";
                $error = true;					
            } //end else
                
            //last name validation
            if (empty($_POST["lname"]))
            {
                $lnameErr = "*LAST NAME is required...!";
                $error = true;
            } 
            else if(preg_match("/^([A-Z]{1})([A-Za-z-])?/", $_POST["lname"]) == false)
            {
                $lnameErr = "*Last name MUST begin with a CAPITAL letter...!";	
                $error = true;
            }
            else if (strlen($_POST["lname"]) > 30)
            {
                $lnameErr = "*Last name MUST be 30 characters or less...!";
                $error = true;					
            } //end else
                
            //email validation
            if (empty($_POST["email"]))
            {
                $emailErr = "*EMAIL is required...!";
                $error = true;
            } 
            else if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false)
            {
                $emailErr = "*Invalid email format...!";
                $error = true;
            } //end else
                
            //address validation
            if (empty($_POST["address"]))
            {
                $addressErr = "*ADDRESS is required...!";
                $error = true;
            } //end if
            else if (strlen($_POST["address"]) > 50)
            {
                $addressErr = "*Address MUST be 50 characters or less...!";
                $error = true;					
            } //end else
                
            //credit card number validation
            if (empty($_POST["cardNum"]))
            {
                $cardNumErr = "*CARD NUMBER is required...!";
                $error = true;
            } //end if
            
            //check if all inputs were valid
            if (!$error)
            {
                //hide non-user payment form 
                $display = 1;
                //no discount for non-registered customer
                $payment = flightCost($no_Of_Person, $ticket_Cost);
                if( $login == 0 && $display  == 1 && $trip == "oneway")
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
                                <button type='button' class='btn btn-success' name='printBtn'><a href='index.php'>Back to home</a></button>
                            </div>
                            <br><br>
                        </div>
                    ";
                    
                } //end if
                if( $login == 0 && $display == 1 && $trip == "round trip")
		            {
			            echo "<div class='table-responsive' style='display: flex; flex-flow: row wrap; justify-content: center;'>
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
						<!---- second section ---------->
						<tr> 
							<td>
								<p> 
									&nbsp &nbsp RETURN DATE &nbsp &nbsp $rDate
									&nbsp Please verify flight time Prior to departure
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
									Departing At: $arrCity
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
									Arriving At: $depCity
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
                    <button type='button' class='btn btn-success' name='printBtn'><a href='index.php'>Back to home</a></button>
					</div>
					<br><br>
				</div>
			";
		} //end if														
            }
         }
} //end 


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Guest Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="assets/style.css">

	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body style="background-color: aqua;">
<div class='inner-container'>
					<hr>
					<h4> ENTER YOUR PAYEMENT INFORMATION TO COMPLETE BOOKING <h4>
					<hr>
</div>
				<br>
<div class='modal-body'>
	<h5>PAYMENT INFRORMATION</h5>
					<hr><hr>
					<br>
					<!-- form starts here -->
					<form id='info' action='guestPayment.php' method='POST'>
						<div class='form-row'>
							<div class='col-6'>
								<input type='text' class='form-control' placeholder='First Name' name='fname'>
								<span class='text-danger'><?php if (isset($fnameErr)) echo $fnameErr;?></span>
							</div>
							<div class='col-6'>
								<input type='text' class='form-control' placeholder='Last Name' name='lname'>
								<span class='text-danger'><?php if (isset($lnameErr)) echo $lnameErr;?></span>
							</div>
						</div>
						<br>
						<div class='form-row row'>
							<div class='col'>
								<input type='email' class='form-control' name='email' placeholder='Email'>
								<span class='text-danger'><?php if (isset($emailErr)) echo $emailErr; ?></span>
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
								</select>
								 <span class='text-danger'><?php if (isset($cardTypeErr)) echo $cardTypeErr;?></span>
							</div>
							<div class='col-6'>
							  <input type='number' class='form-control' placeholder='Credit Card Number' name='cardNum'>
							   <span class='text-danger'><?php if (isset($cardNumErr)) echo $cardNumErr;?></span>
							</div>
						</div>
						<br>
						<div class='form-row'>
							<div class='col'>
							  <input type='text' class='form-control' placeholder='Address' name='address'>
							  <span class='text-danger'><?php if (isset($addressErr)) echo $addressErr; ?></span>
							</div>
						</div>
						<br><br>
						<div class='col-xs-1' align='right' >
							<button type='submit' class='btn btn-primary' name='paymentBtn'>Make Payment</button>
						</div>
					</form>
				</div>
				<br><br><br>
</body>
</html>