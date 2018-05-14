<?php
	session_start();
	echo "<br><br>";
	//local variables
	$msg = $fl_msg = "";
	$trip = $depCity = $arrCity = $dDate = $returnDate = $flightId = $flightName = $flightCost = "";
		
	//set flight search values  
	$trip = $_SESSION['book_info']['tripType'];
	$depCity = $_SESSION['book_info']['departure'];
	$arrCity = $_SESSION['book_info']['arrival'];
	$dDate =  $_SESSION['book_info']['departDate'];
	$returnDate =  $_SESSION['book_info']['returnDate'];
	$noOfpassenger = $_SESSION['book_info']['passenger'];
	
	//set session values for payment
	$_SESSION['flight_info']['tripType'] = $trip;
	
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		//validates if flight is selected
		if(isset($_POST['confirmBtn1']))
		{
			//flight data here
			$flightId = $_POST['fID'];
			$flightName = $_POST['fName'];
			$deptCity = $_POST['departure'];
			$arrCity = $_POST['destination'];
			$dDay = $_POST['dDate'];
			$flightCost  = $_POST['cost'];
			
			//verify that all flight infromation is set
			if($flightId != "" && $flightName != "" && $deptCity != "" && $arrCity != "" && $dDay != "" && $flightCost != "")
			{
				//store flight details in session variable for payment
				$_SESSION['flight_info'] = array(
					'flightId' => $flightId,
					'flightName' => $flightName,
					'departure' => $deptCity,
					'arrival' => $arrCity,
					'departDate' => $dDay,
					'flightCost' => $flightCost,
					'tripType' => $trip,
					'passenger' => $noOfpassenger,
				);
				
				//direct user to payment page
				exit(header("Location:payment.php"));
		
			} //end if
			else
			{
				$msg = '<label style="color:red; font-size: 25px; margin: auto;">Choose your flight plan from flight table...!</label>';
			} //end else
		
		} //end if isset
		else if(isset($_POST['confirmBtn2']))
		{
			//Collect flight data here
			$flightId = $_POST['fID'];
			$flightName = $_POST['fName'];
			$deptCity = $_POST['departure'];
			$arrCity = $_POST['destination'];
			$dDay = $_POST['dDate'];
			$rDay = $_POST['rDate'];
			$flightCost  = $_POST['cost'];
			
			//verify that all flight infromation is set
			if($flightId != "" && $flightName != "" && $deptCity != "" && $arrCity != "" && $dDay != "" && $rDay != "" && $flightCost != "")
			{
				//store flight details in session variable for payment
				$_SESSION['flight_info'] = array(
					'tripType' => $tripType, 
					'flightId' => $flightId,
					'flightName' => $flightName,
					'departure' => $deptCity,
					'arrival' => $arrCity,
					'departDate' => $dDay,
					'returnDate' => $rDay,
					'flightCost' => $flightCost,
					'tripType' => $trip,
					'passenger' => $noOfpassenger,
				);
			
				//direct user to payment page
				header("location:payment.php");
				
			} //end if
			else
			{
				$msg = '<label style="color:red; font-size: 25px; margin: auto;">Choose your flight from flight table...!</label>';
			} //end else
			
		} //end if isset
		
		if(isset($_POST['homeBtn']))
		{
			header("location:index.php");
		} //
		else
		{
			$msg = '<label style="color:red; font-size: 25px; margin: auto;">We are experiencing some technical difficulties. Please try again later...!</label>';
		}
		
	} //end if post
												
?>				

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Book Flight</title>
	<!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	
	<link rel="stylesheet" type="text/css" href="assets/styleflight.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<!-- bootstrap css -->
    <link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css">
	
	<style>
		body { 
			  background: url(assets/images/home.jpg) no-repeat center center fixed; 
			  -webkit-background-size: cover;
			  -moz-background-size: cover;
			  -o-background-size: cover;
			  background-size: cover;
		}
		
		.container1 {
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
		
		
		h6 {
			text-align: center;
			color: white; 
			font-size: 15px;
		}
		

		h5 {
			text-align: center;
			color: blue; 
			font-size: 15px;
		}

		h3 {
			color: white;
			font-size: 25px;
		}	
		
		h1 {
			color: white; 
			font-family:bookman;
		}
		
		/* Gradient transparent - color - transparent */
		hr {
			border: 0;
			height: 3px;
			background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
		}
		
		.btn:hover,
		.btn:focus,
		.btn:active {
			outline: 0 !important;
		}
		
		.inner-container{
			background: rgba(255, 255, 255, 0.75);
			border-radius: 10px;
			padding-left: 20px;
			padding-right: 20px;
			width: 80%;
			height: 550px; 
			margin: auto;
		}
		
		#myInput {
			width: 230px;
			font-size: 16px;
			padding: 10px 20px 10px 20px;
			border-radius: 30px;
			margin-bottom: 12px;
		}
		
		#myInput:focus {
			background-color: #33FFDA;
		}
	</style>
</head>

<body>
	<form action="flight.php" method="POST">
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" role="navigation">
			<div class="container">
				<h3>FLIGHT OPTION</h3>
				<button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
					&#9776;
				</button>
				<div class="collapse navbar-collapse" id="exCollapsingNavbar">
					<ul class="nav navbar-nav flex-row justify-content-between ml-auto">
						<li class="nav-item">
							<button type="submit" name="homeBtn" class="btn btn-outline-primary">
								Return to Home
							</button>
						</li>
					</ul>
					</ul>
				</div>
			</div>
		</nav>
	</form>
	<br><br> <br><br>
	
	<div  class="text-center">
		<h1>ONLINE FLIGHT RESERVATION<h1>
		<?php 
			// Prints the day, date, month, year, time, AM or PM
			echo "<label style='font-size:25px; font-family:bookman;'> CURRENT DATE: "  . date('l jS \of F Y') . "</label>";
		?>
		<hr style="width: 500px; font-family:bookman;">
	</div>
	<div  class="text-center" style='font-size:25px; colorwhite;'>
	<br><br><br>
	
	</div>
	<!-- carouse starts here -->
		<div class="inner-container">
			<br>
			<h2 style="text-align: center; color: blue;">SCROLL TO VIEW CITIES<h2>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<br />

					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
						<ul class="carousel-indicators">
							<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
							<li data-target="#carousel-example-generic" data-slide-to="1"></li>
							<li data-target="#carousel-example-generic" data-slide-to="2"></li>
							<li data-target="#carousel-example-generic" data-slide-to="3"></li>
							<li data-target="#carousel-example-generic" data-slide-to="4"></li>
						</ul>

						<div class="carousel-inner" role="listbox">
							<div class="carousel-item active" style="text-align: center">
								<img src="img/la.jpg" alt="Los Angeles" width="100%" height="350px">
								<div class="carousel-caption">
									<h3>Los Angeles</h3>
									<p>We had such a great time in LA!</p>
								</div>   
							</div>
			
						<div class="carousel-item" style="text-align: center">
							<img src="img/chicago.jpg" alt="Chicago" width="100%" height="350px">
							<div class="carousel-caption">
								<h3>Chicago</h3>
								<p>Thank you, Chicago!</p>
							</div>   
						</div>
			
						<div class="carousel-item" style="text-align: center">
							<img src="img/china.jpg" alt="China" width="100%" height="350px">
							<div class="carousel-caption">
								<h3>China</h3>
								<p>The Great Wall!</p>
							</div>   
						</div>
						
						<div class="carousel-item" style="text-align: center">
							<img src="img/paris.jpg" alt="Paris" width="100%" height="350px">
							<div class="carousel-caption">
								<h3>Paris</h3>
								<p>Lovers leap!</p>
							</div>   
						</div>
						
						<div class="carousel-item" style="text-align: center">
							<img src="img/dubai.jpg" alt="Dubai" width="100%" height="350px">
							<div class="carousel-caption">
								<h3>Dubai</h3>
								<p>Dubai is the largest and most populous city in the United Arab Emirates (UAE)!</p>
							</div>   
						</div>
						
					</div>

        		<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        			<span class="icon-prev" aria-hidden="true"></span>
        			<span class="sr-only">Previous</span>
        		</a>

        		<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        			<span class="icon-next" aria-hidden="true"></span>
        			<span class="sr-only">Next</span>
        		</a>
        	</div>
			<p style="text-align: center; color: black; font-size: 12px;">
				<br><br>
				The most convenient ways to make your reservation and purchase your electronic tickets is via our Website!
				<br>
				Our reservation site will offer you the lowest available fare for the date and locations you specify. Please note that conditions may apply to your fare.
			</p>
        </div>
		<br><br>
      </div>
	<br><br>
	
	<div style="margin: 0px;">
		<?php
			//validates oneway trip flight search
			if($trip == "oneway"){
				
				if($depCity != "" && $arrCity != "" && $dDate!= "") 
				{
					//try database for connection
					try {
						//database connection
						include("db.php");

						//search database for matching flights				
						$stmt = $DBcon->prepare("SELECT flightID,flightName,airlineName,depatureCity,destinationCity,depatureDate,AmountOfSeats,Cost FROM flight WHERE depatureCity = :departureCity and destinationCity = :destinationCity and depatureDate =:depatureDate");
						$stmt->bindParam(':departureCity', $depCity);
						$stmt->bindParam(':destinationCity', $arrCity);
						$stmt->bindParam(':depatureDate', $dDate);
						$stmt->execute();
						$count = $stmt->rowCount();
						$row   = $stmt->fetch(PDO::FETCH_ASSOC);
						

						//validates if matching flight was found
						if($count>0)
						{
							/******************** Display available flights***********************/
							$fl_msg = "<h6>SELECT YOUR FLIGHT PLAN FROM THE AVAILABLE LISTING...!</h6>";
							echo "<div class='container1'>";
							echo "<hr>";
							echo $fl_msg;
							echo "<hr>";
							echo "</div>";
							echo "<input type='text' id='myInput' onkeyup='tableSearchOneway()' placeholder='Search by flight name...'>";
							echo "<br><br>";
								
							//table header here
							echo "<table id='tbl_1' class='table-sm'>";
								echo "<tr>";
									echo "<th>FLIGHT ID</th>"; 
									echo "<th>FLIGHT NAME</th>";
									echo "<th>AIRLINE NAME</th>"; 
									echo "<th>DEPATURE</th>";
									echo "<th>DESTINATION</th>";
									echo "<th>DEPATURE DATE</th>";
									echo "<th>SEATS</th>";
									echo "<th>COST</th>";
									echo "<th>OPTION</th>";
									
								echo "</tr>";
								echo "<tr>";
								foreach ($row as $key => $value) {
									echo "<td>" . $value . "</td>";
								}
								echo "<td> <button class='btn' style='color:blue;' onclick='oneWayFunction();'>Select</button> </td>";
									echo "</tr>";
									echo "</table>";
							} //end while
							else{
								$msg = '<label style="color:red; font-size: 25px; margin: 0px;">No flights are available for that date...!</label>';
							}
							
							//Free result set
							unset($stmt);
			
					//close database connection
					$DBcon = null;
					
					} //end try
					catch (PDOException $e) 
					{
						$msg = '<label style="color:red; font-size: 25px; margin: auto;">Error :' .$e->getMessage(). '</label>';
					} //end catch
				}  //end if
			}	//end if
			//validates round trip flight search
			else if ($trip = "round trip") 
			{
				if($depCity != "" && $arrCity != "" && $dDate != "" && $returnDate != ""  )
				{
					//try database for connection
					try {
						//database connection
						include("db.php");
						
						$stmt = $DBcon->prepare("SELECT flightID,flightName,airlineName,depatureCity,destinationCity,depatureDate,returnDate,AmountOfSeats,Cost FROM flight WHERE depatureCity = :departureCity and destinationCity = :destinationCity and depatureDate =:depatureDate and returnDate = :returnDate");
						$stmt->bindParam(':departureCity', $depCity);
						$stmt->bindParam(':destinationCity', $arrCity);
						$stmt->bindParam(':depatureDate', $dDate);
						$stmt->bindParam(':returnDate', $returnDate);
						
						$stmt->execute();
						$count = $stmt->rowCount();
						$row   = $stmt->fetch(PDO::FETCH_ASSOC);

						//validates if matching flight was found
						if($count > 0) 
						{
							/******************** Display available flights***********************/
							$fl_msg = "<h6>SELECT YOUR FLIGHT PLAN FROM THE AVAILABLE LISTING...!</h6>";
							
							echo "<div class='container1'>";
							echo "<hr>";
							echo $fl_msg;
							echo "<hr>";
							echo "</div>";
							echo "<input type='text' id='myInput' onkeyup='tableSearchRoundTrip()' placeholder='Search by flight name...'>";
							echo "<br><br>";
								
							//table header here
							echo "<table id='tbl_2' class='table-sm'>";
								echo "<tr>";
								echo "<th>FLIGHT ID</th>"; 
								echo "<th>FLIGHT NAME</th>";
								echo "<th>AIRLINE NAME</th>"; 
								echo "<th>DEPATURE</th>";
								echo "<th>DESTINATION</th>";
								echo "<th>DEPATURE DATE</th>";
								echo "<th>RETURN DATE</th>";
								echo "<th>SEATS</th>";
								echo "<th>COST</th>";
								echo "<th>OPTION</th>";
									
								echo "</tr>";
								
								echo "<tr>";
								foreach ($row as $key => $value) {
									echo "<td>" . $value . "</td>";
								}
							echo "<td> <button class='btn' style='color: blue;' onclick='roundTripFunction();'>Select</button> </td>";
							echo "</tr>";
							echo "</table>";
								
							//Free result set
							unset($stmt);
		
							
						} // end if
						else
						{
							$msg = '<label style="color:red; font-size: 25px; margin: 0px;">No flights are available for those dates...!</label>';
						} //end else
										
					//close database connection
					$conn = null;
					
					} //end try
					catch (PDOException $e) 
					{
						$msg = '<label style="color:red; font-size: 25px; margin: auto;">Error :' .$e->getMessage(). '</label>';
					} //end catch						
				} //end if
			} //end else if
			else 
			{
				$msg = '<label style="color:red">You MUST enter your flight details first...!</label>';
			} //end else	
					
			echo"<br>";
			echo $msg;
		?>
	</div>
	<br>
	
	<!-- oneway form starts here -->
	<div class="inner-container1" style='display: none;' id="display1">
		
		<h5> CONFIRM FLIGHT DETAILS <h5>
		<hr>
		<hr>
		<br>
		<form action="flight.php" method="POST">
			<div class="form-row">
				<div class="col-6">
					FLIGHT ID <input type="text" id="fID" class="form-control" name="fID">
				</div>
				<div class="col-6">
					FLIGHT NAME <input type="text" id="fName" class="form-control" name="fName">
				</div>
			</div>
			<br>
			<div class="form-row">
				<div class="col-6">
					DEPART FROM <input type="text" id="departure" class="form-control" name="departure">
				</div>
				<div class="col-6">
					ARRIVE AT <input type="text" id="destination" class="form-control" name="destination">
				</div>
			</div>
			<br>
			<div class="form-row">
				<div class="col-6">
					DEPARTURE DATE <input type="text" id="dDate" class="form-control" name="dDate">
				</div>
				<div class="col-6">
					SEATS <input type="text" id="AmountOfSeats" class="form-control" name="AmountOfSeats">
				</div>
			</div>
			<div class="form-row">
				<div class="col-6">
					
				  COST <input type="text" id="cost" class="form-control" name="cost">
				</div>
			</div>
			<div class="col" align="right" >
					<button type="submit" class="btn btn-primary" name="confirmBtn1">Confirm</button>
			</div>
			<br><br><br><br>
		</form>
	</div>
	
	<!-- round trip form starts here -->
	<div class="inner-container1" style='display: none;' id="display2">
		<h5> CONFIRM FLIGHT DETAILS <h5>
		<hr>
		<hr>
		<br>
		<form action="flight.php" method="POST">
			<div class="form-row">
				<div class="col-6">
					FLIGHT ID <input type="text" id="fID1" class="form-control" name="fID">
				</div>
				<div class="col-6">
					FLIGHT NAME <input type="text" id="fName1" class="form-control" name="fName">
				</div>
			</div>
			<br>
			<div class="form-row">
				<div class="col-6">
					DEPART FROM <input type="text" id="departure1" class="form-control" name="departure">
				</div>
				<div class="col-6">
					ARRIVE AT <input type="text" id="destination1" class="form-control" name="destination">
				</div>
			</div>
			<br>
			<div class="form-row">
				<div class="col-6">
					DEPARTURE DATE <input type="text" id="dDate1" class="form-control" name="dDate">
				</div>
				<div class="col-6">
					RETURN DATE <input type="text" id="rDate1" class="form-control" name="rDate">
				</div>
			</div>
			<div class="form-row">
				<div class="col-6">
					SEATS <input type="text" id="AmountOfSeats1" class="form-control" name="AmountOfSeats">
				</div>
				<div class="col-6">
					
					COST <input type="text" id="cost1" class="form-control" name="cost">
				</div>
			</div>
			<br><br>
			<div class="col" align="right" >
				<button type="submit" class="btn btn-primary" name="confirmBtn2">Confirm</button>
			</div>
		</form>
		<br><br><br><br>
	</div>
	
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="flight.js" type="text/javascript"></script>
		
		
		
		<!--
		function showRoundTrip(row)
		{
			var x=row.cells;
			
			document.getElementById("fID1").value = x[0].innerHTML;
			document.getElementById("fName1").value = x[1].innerHTML;
			document.getElementById("departure1").value = x[2].innerHTML;
			document.getElementById("destination1").value = x[3].innerHTML;
			document.getElementById("dDate1").value = x[4].innerHTML;
			document.getElementById("rDate1").value = x[5].innerHTML;
			document.getElementById("AmountOfSeats1").value = x[6].innerHTML;
			document.getElementById("cost1").value = x[7].innerHTML;
		}
		
		//display oneway flight information
		function onewayFunction() {
			var x = document.getElementById("display1");
			if (x.style.display === "none") {
				x.style.display = "block";
			} else {
				x.style.display = "none";
			}
		}
		
		//display oneway flight information
		function roundTripFunction() {
			var x = document.getElementById("display2");
			if (x.style.display === "none") {
				x.style.display = "block";
			} else {
				x.style.display = "none";
			}
		}
		
		//table filter search
		function tableSearchRoundTrip() {
		  var input, filter, table, tr, td, i;
		  input = document.getElementById("myInput");
		  filter = input.value.toUpperCase();
		  table = document.getElementById("tbl_2");
		  tr = table.getElementsByTagName("tr");
		  for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[1];
			if (td) {
			  if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			  } else {
				tr[i].style.display = "none";
			  }
			}       
		  }
		}
		
		//table filter search
		function tableSearchOneway() {
		  var input, filter, table, tr, td, i;
		  input = document.getElementById("myInput");
		  filter = input.value.toUpperCase();
		  table = document.getElementById("tbl_1");
		  tr = table.getElementsByTagName("tr");
		  for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[1];
			if (td) {
			  if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			  } else {
				tr[i].style.display = "none";
			  }
			}       
		  }
		}
	-->
	

	<!-- jQuery first, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/js/bootstrap.js"></script>
	
	
</body>
</html>