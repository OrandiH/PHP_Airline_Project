<?php

function cleanInputs($value){

	$value = trim($value);
	$value = stripcslashes($value);
	$value = htmlspecialchars($value);
	return $value;
}	

if($_SERVER["REQUEST_METHOD"] == "POST"){

	$userFirstName = $_POST['userFirstName'];
	$userLastName = $_POST['userLastName'];
	$userEmail = $_POST['userEmail'];
	$userPassword = $_POST['userPassword'];
	$userTele = $_POST['userTele'];
	$userAddress = $_POST['userAddress'];

	$cleanFirstName = cleanInputs($userFirstName);
	$cleanLastName = cleanInputs($userLastName);
	$cleanEmail = cleanInputs($userEmail);
	$cleanPassword = cleanInputs($userPassword);
	$cleanTele = cleanInputs($userTele);
	$cleanAddress = cleanInputs($userAddress);


	$serverName = "localhost";
	$dbUserName = "root";
	$dbPassword = "";
	$dbName = "Airlines_db";

	//Connect to DB and enter data

	try{
		$conn = new PDO("mysql:host=$serverName;dbname=$dbName",$dbUserName,$dbPassword);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "INSERT INTO newusers (userEmail,userFName,userLName,userTele,userAddress,userPassword) VALUES 
		('$cleanEmail','$cleanFirstName','$cleanLastName','$cleanTele','$cleanAddress','$cleanPassword')";

		$conn->exec($sql);

		echo "Record added";
 }catch(PDOException $e){
 	echo $sql. "<br>" . $e->getMessage();
 }
 $conn = null;//Close connection to db
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

      	<form action="index.php" method="POST">
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
		    <div class="col">
		      <input type="text" class="form-control" placeholder="Telephone" name="userTele">
		    </div>
		  </div>
		  <br>
		   <div class="form-row">
		    <div class="col">
		      <input type="text" class="form-control" placeholder="Address" name="userAddress">
		    </div>
		  </div>
		  <br>
		 <div class="d-flex justify-content-between">
		  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  		<button type="button float-right" class="btn btn-primary" href="#">Register</button>
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
					    <input type="radio" name="tripType" id="option1" autocomplete="off" checked> Round Trip
					  </label>
					  <br>
					  <label class="btn btn-primary">
					    <input type="radio" name="tripType" id="option2" autocomplete="off"> One Way
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
		      <input type="date" class="form-control return" style="width: 100%" name="returnDate">
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

</body>
</html>
