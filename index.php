<?php
	session_start();

	//Define empty variables for errors
	$fNameErr = "";
	$passwdErr = "";
	$LNameErr = "";
	$emailErr = "";
	$ageErr = "";
	$addressErr = "";
	$ccNumErr = "";
	$Val = 0; 
	$errFlag = 0; //This is needed to identify errors
	
	//Define empty booking variables
	$tripType = $oneway = $deptCity = $arrCity = $dDay = $rDay = $noOfpassenger = "";

	//Define variables for database access
	$serverName = "localhost";
	$dbUserName = "root";
	$dbPassword = "";
	$dbName = "Airlines_db";

	//Variables to store hashed values
	$hash_password = "";
	$hash_creditNum = "";

	//Function to clean inputs received from form
	function cleanInputs($value){

		$value = trim($value);
		$value = stripcslashes($value);
		$value = htmlspecialchars($value);
		return $value;
	}	

	function processFormData($value1,$value2,$value3,$value4,$value5,$value6,$value7,$errFlag){
		$response= 0;//Initializing $response variable
		if($value1=="" && $value2 =="" && $value3 == "" && $value4 == "" && $value5 == "" && $value6 == "" && $value7 == "")
			{
				return $response; //If the values are empty return 0 
			}else if($errFlag == 1){
				return $response; //IF an error occurs return the value in $response
			}
			else{
				$response = 1;//If the response is 1 set session values
				$_SESSION['user_info'] = array(
				'userFirstName' => $value1, 
				'userLastName' => $value2,
				'userPassword' => $value3,
				'userEmail' => $value4,
				'userAge' => $value5,
				'userAddress' => $value6,
				'userCreditCrdNum' => $value7
				);
				return $response;//Return response value
			}
	}
	//Verify length of password user submits
	function verifyPasswordLength($value)
	{
		if(strlen($value) < 8)
		{
			$passwdErr = "Password is too short,password must be 8 characters";
			$errFlag = 1;
		}
		else if (strlen($value) > 8) 
		 {
			$passwdErr = "Password is too long,password must be 8 characters at least";
			$errFlag = 1;
		}
		else{
			$passwdErr = "";
		}
		return $passwdErr;
	}


	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		
		if(isset($_POST['registerBtn'])){
			//Collect form data here
			$userFirstName = $_POST['userFirstName'];
			$userLastName = $_POST['userLastName'];
			$userEmail = $_POST['userEmail'];
			$userPassword = $_POST['userPassword'];
			$userAge = $_POST['userAge'];
			$userAddress = $_POST['userAddress'];
			$userCCNum = $_POST['userCCNum'];

		
			//First level of sanitation here
			$cleanFirstName = cleanInputs($userFirstName);
			$cleanLastName = cleanInputs($userLastName);
			$cleanEmail = cleanInputs($userEmail);
			$cleanPassword = cleanInputs($userPassword);
			$cleanAge = cleanInputs($userAge);
			$cleanAddress = cleanInputs($userAddress);
			$cleanCCNum = cleanInputs($userCCNum);

			$profile_pic = ""; //to be used for bonus marks

			$passwdErr = verifyPasswordLength($cleanPassword);

			$hash_creditNum = md5($cleanCCNum);
			$hash_password = password_hash($cleanPassword,PASSWORD_DEFAULT);


			$profilePic = "";



			//Connect to DB and enter data
			//Validate username
			if(!preg_match("/^([A-Z]{1})([A-Za-z-])?/", $cleanFirstName))
			{
				$nameErr = "Firstname is invalid";
				$errFlag = 1;
			}
			//Validate full name
			if(!preg_match("/^([A-Z]{1})([A-Za-z-])?/", $cleanLastName))
			{
				$wholeNameErr = "Lastname is invalid";
				$errFlag = 1;
			}
			//Validate email
			if(!filter_var($cleanUserEmail,FILTER_VALIDATE_EMAIL))
			{
				$emailErr = "Email is invalid";
				$errFlag = 1;
			}
			//Validate address
			if(!preg_match("/^[0-9a-zA-Z,. ]+/", $cleanAddress))
			{
				$addressErr = "Address is invalid";
				$errFlag = 1;
			}
			//Validate age
			if(!filter_var($cleanAge,FILTER_VALIDATE_INT))
			{
				$ageErr = "Age is invalid";
				$errFlag = 1;
			}
			//Validate credit card num
			if(!preg_match("^(?:4[0-9]{12}(?:[0-9]{3})?",$cleanCCNum)){
				$ccNumErr = "Credit card isn't valid";
				$errFlag = 1;
			}

			//Pass in validated information
			$Val = process_customer_query($cleanFirstName,$cleanLastName,$cleanPassword
			,$cleanEmail,$cleanAge,$cleanAddress,$cleanCCNum,$errFlag);

			//Connect to DB and enter data
			try{
				//Set DB connection
				$conn = new PDO("mysql:host=$serverName;dbname=$dbName",$dbUserName,$dbPassword);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				
				//establish database connection
						
						$conn = new PDO("mysql:host=$serverName;dbname=$dbName",$dbUserName,$dbPassword);
						// set the PDO error mode to exception
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						//set the default PDO fetch mode to object
						$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

				//Set queries for inserting into DB
				$sql = "INSERT INTO customer (userName,firstName,lastName,age,mailAddress,credit_card_Num, profile_pic) VALUES 
				('$cleanEmail','$cleanFirstName','$cleanLastName','$cleanAge','$cleanAddress','$hash_creditNum', '$profilePic')";

				$sql2 = "INSERT INTO customer_login (userName,password) VALUES 
				('$cleanEmail','$hash_password')";

				//Execute statements
				$conn->exec($sql);
				$conn->exec($sql2);
				
				// Free result set
				unset($sql);
				unset($sq2);
				
				echo '<div class="alert alert-success">
				  <strong>Success!</strong> Record Added
				</div>';

				//header('Refresh: 2; URL=index.php');

			}catch(PDOException $e){
				echo $sql. "<br>" . $e->getMessage();
			}
				$conn = null;//Close connection to db
			} //end if
			else if(isset($_POST['loginBtn']))
			{
				//direct user to flight page
				header("location:flight.php");
			}
			else if(isset($_POST['bookBtn'])){
				//Collect and clean booking data here
				$tripType = cleanInputs($_POST['tripType']);
				$deptCity = cleanInputs( $_POST['departure']);
				$arrCity = cleanInputs($_POST['arrival']);
				$dDay = cleanInputs($_POST['departDate']);
				$rDay = cleanInputs($_POST['returnDate']);
				$noOfpassenger = cleanInputs($_POST['passenger']);
				
				//session variable to store book details
				$_SESSION['book_info'] = array(
					'tripType' => $tripType, 
					'departure' => $deptCity,
					'arrival' => $arrCity,
					'departDate' => $dDay,
					'returnDate' => $rDay,
					'passenger' => $noOfpassenger,
				);
				
				//error not outputing trip type
				$m = $_SESSION['book_info']['tripType'];
				
				echo "<br><br><br><br>";
				echo  $m; 
				
				//direct user to flight page
				header("location:flight.php");
				
			} //end if
			
	} // end if post
?>


<!DOCTYPE html>
<html>
<head>
	<title>Airline Tickets</title>
	<meta charset="utf-8">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="assets/style.css">

	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>
<body background="assets/images/home.jpg">
	<div class="container-fluid">
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" role="navigation">
			<div class="container">
				<a class="navbar-brand" href="#">Booking</a>
				<button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
					&#9776;
				</button>
				<div class="collapse navbar-collapse" id="exCollapsingNavbar">
					<ul class="nav navbar-nav flex-row justify-content-between ml-auto">
						<li class="nav-item"><a href="#" class="nav-link">Already a member?</a></li>
						<li class="dropdown order-1">
							<button type="button" id="dropdownMenu1" data-toggle="dropdown" class="btn btn-outline-primary dropdown-toggle ">Login/Register <span class="caret"></span></button>
							<ul class="dropdown-menu dropdown-menu-right mt-1 transparent">
							  <li class="p-3">
									<form class="form" role="form" action="" method="POST">
										<div class="form-group">
											<input id="emailInput" placeholder="Email" class="form-control form-control-sm" type="text" required="">
										</div>
										<div class="form-group">
											<input id="passwordInput" placeholder="Password" class="form-control form-control-sm" type="text" required="">
										</div>
										<div class="form-check">
										<input type="checkbox" class="form-check-input" id="exampleCheck1">
										<label class="form-check-label" for="exampleCheck1">Remember Me</label>
									  </div>
									  <br>
										<div class="form-group">
											<button type="submit" name="loginBtn" class="btn btn-primary btn-block">Login</button>
										</div>
										<center>
										<div class="form-group text-xs-center">
											<small>New Here? <a href="#" data-toggle="modal" data-target="#registerModal">Register</a></small>
										</div>
										</center>
									</form>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	
	<!-- Modal -->
	<div class="modal" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header ">
			<h4 class="modal-title" id="exampleModalLabel">Sign Up</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			
			<!-- form starts here -->
			<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
			  <div class="form-row">
				<div class="col-6">
				<input type="text" class="form-control" placeholder="First Name" name="userFirstName">
			  </div>
				<div class="col-6">
				  <input type="text" class="form-control" placeholder="Last Name" name="userLastName">
				</div>
			  </div>
			  <br>
			  <div class="form-row row">
				<div class="col">
					<input type="email" class="form-control" name="userEmail" placeholder="Email">
				</div>
			  </div>
			  <br>
			  <div class="form-row row">
				<div class="col">
					<input type="password" class="form-control" name="userPassword" placeholder="Password">
				</div>
			  </div>
			  <br>
			  <div class="form-row">
				<div class="col-6">
					<select class="form-control placeholder">
					   <option value="">Select Card Type</option>
					   <option value="1">American Express</option>
					   <option value="2">MasterCard</option>
					   <option value="3">Discover</option>
					   <option value="4">Visa</option>
					   <option value="5">PayPal</option>
					</select>
				</div>
				<div class="col-6">
				  <input type="text" class="form-control" placeholder="Credit Card Number" name="userCCNum">
				</div>
			  </div>
			  <br>
			   <div class="form-row">
				<div class="col">
				  <input type="text" class="form-control" placeholder="Address" name="userAddress">
				</div>
			  </div>
			  <br>
			  <div class="form-row">
				<div class="col">
					<img id="blah" src="http://placehold.it/180" alt="your image" />
					<input type='file' onchange="readURL(this);" name="profilePic">
				</div>
			  </div>
			  <br>
			 <div class="d-flex justify-content-between">
			 <button type="button float-right" class="btn btn-primary" href="#" id="registerBtn">Register</button>
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
			</form>
			</div>
		<div class="modal-footer">
				
				</div>
		</div>
	  </div>
	</div>


	<div class="container container-body">
		<form action="" method="POST">
			<div class="form-row">
				<div class="col">
					<center>
					<div class="btn-group btn-group-toggle btn-primary" data-toggle="buttons">
					  <label class="btn btn-primary active">
					    <input type="radio" name="tripType" id="option1" autocomplete="off" checked onChange="disablefield();"> Round Trip
					  </label>
					  <br>
					  <label class="btn btn-primary">
					    <input type="radio" name="tripType" id="option2" autocomplete="off" onChange="disablefield();"> One Way
					  </label>
					</div>
					</center>
				</div>
			</div>
			<br>
		  <div class="form-row">
		    <div class="col">
		    <input type="text" class="form-control" placeholder="Depart From" name="departure">
		  </div>
		  </div>
		  <br>
		  <div class="form-row">
		    <div class="col-12">
		      <input type="text" class="form-control" placeholder="Arrive At" name="arrival">
		    </div>
		  </div>
		  <br>
		  <div class="form-row row">
		    <div class="col-6">
		    	Depart
		    	<input type="date" class="form-control" style="width: 100%" name="departDate">
		    </div>
		    <div class="col-6">
		    	Return
		      <input type="date" id="returnDate" class="form-control return" style="width: 100%" name="returnDate">
		    </div>
		  </div>
		  <br>
		  <div class="form-row">
		    <div class="col">
		    	Number Of Passengers
		      <input type="number" class="form-control" max="10" min="1" name="passenger">
		    </div>
		  </div>
		  <br>
		  <center>
		  <input type="submit" class="btn btn-primary btn-lg btn-block" name="bookBtn" value="Book" />
		  </center>
		</form>
	</div>
	</div>

	</div>

	<script type="text/javascript"> 

		function disablefield(){ 
			if (document.getElementById('option2').checked == 1){ 
				document.getElementById('returnDate').disabled='disabled';
				document.getElementById('returnDate').value='disabled'; 
			}else{ 
				document.getElementById('returnDate').disabled=''; 
				document.getElementById('returnDate').value='Allowed';
			} 
		}

		function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        } 
	</script>
	
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
