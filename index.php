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
			return $response; //If an error occurs return the value in $response
		}
		else{
			$response = 1;//If the $response is 1 set session values
			$_SESSION['user_info'] = array(
			'userFirstName' => $value1, 
			'userLastName' => $value2,
			'userPassword' => $value3,
			'userEmail' => $value4,
			'userAge' => $value5,
			'userAddress' => $value6,
			'userCreditCrdNum' => $value7
			);
			return $response;//Return $response value
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
		$fNameErr = "Firstname is invalid";
		$errFlag = 1;
	}
	//Validate full name
	if(!preg_match("/^([A-Z]{1})([A-Za-z-])?/", $cleanLastName))
	{
		$LNameErr = "Lastname is invalid";
		$errFlag = 1;
	}
	//Validate email
	if(!filter_var($cleanEmail,FILTER_VALIDATE_EMAIL))
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
	if(!preg_match("/^(?:4[0-9]{12})(?:[0-9]{3})?/",$cleanCCNum)){
		$ccNumErr = "Credit card isn't valid";
		$errFlag = 1;
	}

	//Pass in validated information
	$Val = processFormData($cleanFirstName,$cleanLastName,$cleanPassword
	,$cleanEmail,$cleanAge,$cleanAddress,$cleanCCNum,$errFlag);

	//Connect to DB and enter data
	try{
		if($Val==1){
				//Set DB connection
		$conn = new PDO("mysql:host=$serverName;dbname=$dbName",$dbUserName,$dbPassword);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//Set queries for inserting into DB
		$sql = "INSERT INTO customer (userName,firstName,lastName,age,mailAddress,credit_card_Num, profile_pic) VALUES 
		('$cleanEmail','$cleanFirstName','$cleanLastName','$cleanAge','$cleanAddress','$hash_creditNum', '$profilePic')";

		$sql2 = "INSERT INTO customer_login (userName,password) VALUES 
		('$cleanEmail','$hash_password')";

		//Execute statements
		$conn->exec($sql);
		$conn->exec($sql2);

		echo '<div class="alert alert-success">
		  <strong>Success!</strong> Record Added
		</div>';
		}
		else{
			echo '<div class="alert alert-primary">
		  <strong>An error occured!</strong>
		</div>';
	
		// header('Refresh: 2; URL=index.php');
		}

		//header('Refresh: 2; URL=index.php');

 }catch(PDOException $e){
 			echo $sql. "<br>" . $e->getMessage();
		}
 		$conn = null;//Close connection to db
		}
	}

?>
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
	        <a class="navbar-brand" href="#">Booking</a>
	        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
	            &#9776;
	        </button>
	        <div class="collapse navbar-collapse" id="exCollapsingNavbar">
	            <ul class="nav navbar-nav flex-row justify-content-between ml-auto">
	                <li class="nav-item"><a href="#" class="nav-link">Already a member?</a></li>
	                <li class="dropdown order-1">
	                    <button type="button" id="dropdownMenu1" data-toggle="dropdown" class="btn btn-outline-primary dropdown-toggle ">Login/Register</button>
	                    <ul class="dropdown-menu dropdown-menu-right mt-1 transparent">
	                      <li class="p-3">
	                            <form class="form" role="form" action="" method="POST">
	                                <div class="form-group">
	                                    <input id="emailInput" placeholder="Email" class="form-control form-control-sm" type="text" ="">
	                                </div>
	                                <div class="form-group">
	                                    <input id="passwordInput" placeholder="Password" class="form-control form-control-sm" type="text" ="">
	                                </div>
	                                <div class="form-check">
								    <input type="checkbox" class="form-check-input" id="exampleCheck1">
								    <label class="form-check-label" for="exampleCheck1">Remember Me</label>
								  </div>
								  <br>
	                                <div class="form-group">
	                                    <button type="submit" class="btn btn-primary btn-block">Login</button>
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
<div class="modal" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header ">
        <h4 class="modal-title" id="exampleModalLabel">Sign Up</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"  aria-hidden="true">&times;
        </button>
      </div>
      <div class="modal-body">
		
		<!-- form starts here -->
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" id="registration">
		  <div class="form-row">
		    <div class="col-6">
		    <input type="text" class="form-control" placeholder="First Name" name="userFirstName" >
				<?php echo $fNameErr; ?>
		  </div>
		    <div class="col-6">
		      <input type="text" class="form-control" placeholder="Last Name" name="userLastName" >
					 <?php echo $LNameErr; ?>
		    </div>
		  </div>
		  <br>
		  <div class="form-row row">
		    <div class="col">
		    	<input type="email" class="form-control" name="userEmail" placeholder="Email" >
					 <?php echo $emailErr; ?>
		    </div>
		  </div>
		  <br>
		  <div class="form-row row">
		    <div class="col">
		    	<input type="password" class="form-control" name="userPassword" placeholder="Password" >
				 <?php echo $passwdErr; ?>
		    </div>
		  </div>
		  <br>
		  <div class="form-row">
		    <div class="col-6">
		      <input type="number" class="form-control" placeholder="Age" name="userAge" min="1" >
					<?php echo $ageErr; ?>
		    </div>
		    <div class="col-6">
		      <input type="text" class="form-control" placeholder="Credit Card Number" name="userCCNum" >
					 <?php echo $ccNumErr; ?>
		    </div>
		  </div>
		  <br>
		   <div class="form-row">
		    <div class="col">
		      <input type="text" class="form-control" placeholder="Address" name="userAddress" >
					 <?php echo $addressErr; ?>
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
		 <button type="submit" class="btn btn-primary" name="registerBtn" id="registerBtn">Register</button>
		  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
		</form>
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
		    	<input type="date" class="form-control" style="width: 100%" name="dapartDate">
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
		      <input type="number" class="form-control" max="10" min="1">
		    </div>
		  </div>
		  <br>
		  <center>
		  <input class="btn btn-primary btn-lg btn-block" type="submit" value="Book">
		  </center>
		</form>
	</div>
	</div>

	</div>
	
	<!-- Bootstrap Script Links --> 
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<!--The script below is to show the preview of the user profile-->
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

	<!--Scripts for form validation-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>

	<script src="assets/js/formValidation.js"></script>

</body>
</html>
