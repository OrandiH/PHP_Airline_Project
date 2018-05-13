<?php
	include('db.php');
	session_start();
	
	//Define empty booking variables
	$tripType = $oneway = $deptCity = $arrCity = $dDay = $rDay = $noOfpassenger = "";

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
	


	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST['loginBtn']))
			{
						$userName = $_POST['username'];
						$password = $_POST['password'];
						$hash_password = md5($password);
						//Define variables for database access
						$DB_host = "localhost";
						$DB_user = "root";
						$DB_pass = "";
						$DB_name = "Airlines_DB";

						try
						{
								//Set SQL statement using named parameters
								$stmt = $DBcon->prepare("SELECT * FROM customer WHERE userName = :username && password = :password");
								$stmt->bindparam(':username', $userName);
								$stmt->bindparam(':password', $hash_password);
								$stmt->execute();//This is key

								$users = $stmt->fetchAll();
								$userCount = $stmt->rowCount();

								if($userCount == 1)
								{
										$_SESSION['users'] = (array) $users;
										echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>";
										echo "<script type='text/javascript' src='profile.js'></script>";
									//	header("Refresh: 4; url=flight.php");
								}
								else{
										echo "<script>alert('Invalid userID or password!');</script>";
									  header("Refresh:3; url=index.php");
										
								}
						}
						catch(PDOException $e)
						{
								echo "ERROR : ".$e->getMessage();
						}
						$stmt = null;//Close connection to db
 						$DBcon = null;
			}

	}



			

		

			
			
			/*
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
				exit(header("Location:flight.php"));
				
			} //end if
			
	} // end if post
	*/
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
							<button type="button" class="btn btn-outline-primary profile" style="display:none"><a href="profile.php">Profile</a></button>
							<button type="button" class="btn btn-outline-primary logout" style="display:none"><a href="logoutCustomer.php">Logout</a></button>
							<button type="button" id="dropdownMenu1" data-toggle="dropdown" class="btn btn-outline-primary dropdown-toggle ">Login/Register <span class="caret"></span></button>
							<ul class="dropdown-menu dropdown-menu-right mt-1 transparent">
							  <li class="p-3">
									<form class="form" role="form" action="index.php" method="POST">
										<div class="form-group">
											<input name="username" placeholder="Username" class="form-control form-control-sm" type="text" required="">
										</div>
										<div class="form-group">
											<input name="password" placeholder="Password" class="form-control form-control-sm" type="password" required="">
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
			<span class="alert alert-danger display-error" style="display: none"></span>
			<form role="form" class="registerForm">
			<div class="form-row">
				<div class="col-6">
				</div>
			</div>
			  <div class="form-row">
				<div class="col-6">
				<input type="text" class="form-control" placeholder="First Name" name="userFirstName" id="firstName">
			  </div>
				<div class="col-6">
				  <input type="text" class="form-control" placeholder="Last Name" name="userLastName" id="lastName">
				</div>
			  </div>
			  <br>
			  <div class="form-row row">
				<div class="col">
					<input type="email" class="form-control" name="userEmail" placeholder="Email" id="email">
				</div>
			  </div>
			  <br>
			  <div class="form-row row">
				<div class="col">
					<input type="password" class="form-control" name="userPassword" placeholder="Password" id="password">
				</div>
			  </div>
			  <br>
			  <div class="form-row">
				<div class="col-6">
				  <input type="text" class="form-control" placeholder="Credit Card Number" name="userCCNum" id="cardNum">
					
				</div>
				<div class="col-6">
				  <input type="text" class="form-control" placeholder="Age" name="userAge" id="age">
					
				</div>
			  </div>
			  <br>
			   <div class="form-row">
				<div class="col">
				  <input type="text" class="form-control" placeholder="Address" name="userAddress" id="address">
					
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
			 <button type="submit" class="btn btn-primary" name="registerBtn" id="submit">Register</button>
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
					    <input type="radio" name="tripType" id="option1" autocomplete="off" checked onChange="disablefield();" value="round trip"> Round Trip
					  </label>
					  <br>
					  <label class="btn btn-primary">
					    <input type="radio" name="tripType" id="option2" autocomplete="off" onChange="disablefield();" value="oneway"> One Way
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
<!--Script for validation-->
<script type="text/javascript">
  $(document).ready(function() {
      $('.registerForm').submit(function(e){
        e.preventDefault();
				//Variables for data to be sent for validation
        var firstname = $("#firstName").val();
				var lastname = $("#lastName").val();
        var email = $("#email").val();
				var password = $("#password").val();
				var cardNum = $("#cardNum").val();
				var age = $("#age").val();
        var address = $("#address").val();
				//AJAX call 
        $.ajax({
            type: "POST",
            url: "/PHP_Airline_Project/registerDataProcess.php",
						dataType: "json",
            data: {firstname:firstname, lastname:lastname,email:email,password:password,cardnum:cardNum, age:age,address:address},
            success : function(data){
                if (data.code == "200"){
                    alert("Success: Record added!");
										$("#registerModal").modal("hide");
										$(".registerForm")[0].reset();
										$(".display-error").css("display","none");
										alert("" + data.msg);
                } else {
                    $(".display-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-error").css("display","block");
                }
            },
						error: function(){
							alert("Sumn no right!");
						}	
        });
      });
  });
</script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>