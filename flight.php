<?php
	session_start();
?>

<?php
			
	//local variables
	$depCit = $desCity = $dDate = $msg = $trip = $var = "";
		
	//set flight search values  
	$trip = $_SESSION['book_info']['tripType'];
	$depCit = $_SESSION['book_info']['departure'];
	$desCity = $_SESSION['book_info']['arrival'];
	$dDate =  $_SESSION['book_info']['departDate'];
	$rDate =  $_SESSION['book_info']['returnDate'];
	
	//set session values for payment
	$_SESSION['flight_info']['tripType'] = $trip;
	
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
	
	<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css">
	
	<script language="javascript" type="text/javascript">
		function showRow(row)
		{
		var x=row.cells;
		document.getElementById("fID").value = x[0].innerHTML;
		document.getElementById("fName").value = x[1].innerHTML;
		document.getElementById("depature").value = x[2].innerHTML;
		document.getElementById("destination").value = x[3].innerHTML;
		document.getElementById("dDate").value = x[4].innerHTML;
		document.getElementById("AmountOfSeats").value = x[5].innerHTML;
		document.getElementById("AmountOfSeats").value = x[6].innerHTML;
		}
	</script>
	
	<style>
		table { 
			font-size: 15px;
			color: teal;
			margin: auto;
			background: rgba(255, 255, 255, 0.75);
			font-family: Helvetica, Arial, sans-serif;
		}
		
		td, th {  
			border: 1px solid transparent; /* No more visible border */
			height: 30px; 
			transition: all 0.3s;  /* Simple transition for hover effect */
		}

		th {  
			background: #33FFDA;  /* Darken header a bit */
			font-weight: bold;
		}
		
		td {  
			
			text-align: center;
		}
		
		table tr:not(:first-child){
			cursor: pointer;transition: all .25s ease-in-out;
        }
		
        table tr:not(:first-child):hover {
			background-color: #ddd; color: orange;
			}

		
		p {
			font-size: 18px;
			color: blue;
		}
		
		/* Gradient transparent - color - transparent */
		hr {
			border: 0;
			height: 3px;
			background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
		}
		
		.inner-container{
			background: rgba(255, 255, 255, 0.75);
			border-radius: 10px;
			padding-left: 20px;
			padding-right: 20px;
			width: 80%;
			height: 500px; 
			margin: auto;
		}
		
		.inner-container1{
			background: rgba(255, 255, 255, 0.75);
			border-radius: 10px;
			padding: 20px;
			width: 60%;
			height: 450px; 
			margin: auto;
		}
		
		h6 {
			text-align: center;
			color: blue; 
			font-size: 25px;
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
		
	</style>
</head>
<body background="assets/images/home.jpg" >
	
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" role="navigation">
	    <div class="container">
	        <h3>FLIGHT OPTION</h3>
	        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
	            &#9776;
	        </button>
	        <div class="collapse navbar-collapse" id="exCollapsingNavbar">
	            <ul class="nav navbar-nav flex-row justify-content-between ml-auto">
	                <li class="nav-item">
	                    <button type="button" class="btn btn-outline-primary">
							<a href="index.php" class="nav-link">Return to Home</a>
						</button>
	                </li>
	            </ul>
	        </div>
	    </div>
	</nav>
	<br><br> <br><br><br>
	
	<!-- form starts here -->
	<form action="" method="POST">
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
        </div>
		<br><br>
      </div>
	</form>
	<br><br>
	
	<div style="margin: 0px;">
		<?php
			//validates oneway trip flight search
			if($trip != "" && $trip = "oneway"){
				if($depCit != "" && $desCity != "" && $dDate!= "") 
				{
					try {
						//database connection
						include("connection.php");
						
						//search parameters
						$string1 = "select flight_cost.flightID,flightName,depatureCity,destinationCity,depatureDate,AmountOfSeats,cost";
						//join parameters
						$string2 = "join flight_cost on flight.flightID = flight_cost.flightID";
						//where parameters
						$string3 = "depatureCity='$depCit' and destinationCity='$desCity' and depatureDate='$dDate'";
								
						//search database for matchig flights
						$query = "$string1 from flight $string2 where $string3";					
						$stmt = $conn->prepare($query);
						$stmt->bindParam('depatureCity', $depCit, PDO::PARAM_STR);
						$stmt->bindValue('destination', $desCity, PDO::PARAM_STR);
						$stmt->bindValue('depatureDate', $dDate, PDO::PARAM_STR);
						$stmt->execute();
						$count = $stmt->rowCount();
						$row   = $stmt->fetch(PDO::FETCH_ASSOC);
						  
						//validates if matchig flight was found
						if($count > 0 && !empty($row)) 
						{
							/******************** Display available flights***********************/
							$fl_msg = "<h6> CHOOSE YOUR FLIGHT OPTION...!</h6>";
							echo "<br>";
							echo "<hr>";
							echo $fl_msg;
							echo "<hr>";
								
							//table header here
							echo "<table id='tbl' class='table-sm'>";
								echo "<tr>";
									echo "<th>FLIGHT ID</th>"; 
									echo "<th>FLIGHT NAME</th>"; 
									echo "<th>DEPATURE CITY</th>";
									echo "<th>DESTINATION CITY</th>";
									echo "<th>DEPATUREDATE</th>";
									echo "<th>AMOUNTOFSEATS</th>";
									echo "<th>COST</th>";
									
								echo "</tr>";
								
								while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
								{					
									//out record from database								
									echo "<tr onclick='javascript:showRow(this);'>";
										echo "<td>" . $row['flightID'] . "</td>";
										echo "<td>" . $row['flightName'] . "</td>";
										echo "<td>" . $row['depatureCity']. "</td>";
										echo "<td>" . $row['destinationCity']. "</td>";
										echo "<td>" . $row['depatureDate']. "</td>";
										echo "<td>" . $row['AmountOfSeats']. "</td>";
										echo "<td>" . $row['cost']. "</td>";
										
									echo "</tr>";
									} //end while
								echo "</table>";
								
								// Free result set
								unset($result);
								
						} // end if
						else
						{
							$msg = '<label style="color:red; font-size: 25px; margin: 0px;">No flights are available for that date...!</label>';
						} //end else
										
					//close database connection
					$conn = null;
					
					} //end try
					catch (PDOException $e) 
					{
						$msg = "Error : ".$e->getMessage();
					} //end catch
				}  //end if
			}	//end if
			//validates round trip flight search
			else if ($trip != "" && $trip = "round trip") 
			{
				if($depCit != "" && $desCity != "" && $dDate != "" && $rDate != ""  )
				{
					//round trip flight search
					try {
						//database connection
						include("connection.php");
						
						//search parameters
						$string1 = "select flight_cost.flightID,flightName,depatureCity,destinationCity,depatureDate,returnDate,AmountOfSeats,cost";
						//join parameters
						$string2 = "join flight_cost on flight.flightID = flight_cost.flightID";
						//where parameters
						$string3 = "depatureCity='$depCit' and destinationCity='$desCity' and depatureDate='$dDate' and returnDate ='rDate'";
								
						//search database for matchig flights
						$query = "$string1 from flight $string2 where $string3";					
						$stmt = $conn->prepare($query);
						$stmt->bindParam('depatureCity', $depCit, PDO::PARAM_STR);
						$stmt->bindValue('destination', $desCity, PDO::PARAM_STR);
						$stmt->bindValue('depatureDate', $dDate, PDO::PARAM_STR);
						$stmt->bindValue('returnDate', $rDate, PDO::PARAM_STR);
						$stmt->execute();
						$count = $stmt->rowCount();
						$row   = $stmt->fetch(PDO::FETCH_ASSOC);
						  
						//validates if matchig flight was found
						if($count > 0 && !empty($row)) 
						{
							/******************** Display available flights***********************/
							$fl_msg = "<h6> CHOOSE YOUR FLIGHT OPTION...!</h6>";
							echo "<br>";
							echo "<hr>";
							echo $fl_msg;
							echo "<hr>";
								
							//table header here
							echo "<table id='tbl' class='table-sm'>";
								echo "<tr>";
									echo "<th>FLIGHT ID</th>"; 
									echo "<th>FLIGHT NAME</th>"; 
									echo "<th>DEPATURE CITY</th>";
									echo "<th>DESTINATION CITY</th>";
									echo "<th>DEPATUREDATE</th>";
									echo "<th>RETURNDATE</th>";
									echo "<th>AMOUNTOFSEATS</th>";
									echo "<th>COST</th>";
									echo "</tr>";
								
								while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
								{					
									//out record from database								
									echo "<tr onclick='javascript:showRow(this);'>>";
										echo "<td>" . $row['flightID'] . "</td>";
										echo "<td>" . $row['flightName'] . "</td>";
										echo "<td>" . $row['depatureCity']. "</td>";
										echo "<td>" . $row['destinationCity']. "</td>";
										echo "<td>" . $row['depatureDate']. "</td>";
										echo "<td>" . $row['returnDate']. "</td>";
										echo "<td>" . $row['AmountOfSeats']. "</td>";
										echo "<td>" . $row['cost']. "</td>";
									echo "</tr>";
									} //end while
							echo "</table>";
								
							// Free result set
							unset($result);
							
						} //else if
						else
						{
							$msg = '<label style="color:red">No flights are available for that date...!</label>';
						} //end else
										
							//close database connection
							$conn = null;
					} //end try
					catch (PDOException $e) 
					{
						$msg = "Error : ".$e->getMessage();
					} //end catch
						
				} //end if
			} //end else if
			else 
			{
				$msg = '<label style="color:red">You MUST enter your fligh details first...!</label>';
			} //end else	
					
			echo"<br>";
			echo $msg;
			/*
			if($_SERVER["REQUEST_METHOD"] == "POST")
			{
				if(isset($_POST['confirmBtn']))
				{
					header("location:payment.php");
				}
			}
			*/
		?>
	</div>
	
	
	<br><br>
	<!-- form starts here -->
	<div class="inner-container1">
	<hr>
	<h5> CONFIRM FLIGHT DETAILS <h5>
	<hr>
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
				DEPART FROM <input type="text" id="depature" class="form-control" name="depature">
			</div>
			<div class="col-6">
				DEPART TO <input type="text" id="destination" class="form-control" name="destination">
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
				<button type="submit" class="btn btn-primary" name="confirmBtn">Confirm</button>
		</div>
	</form>
	</div>
	
	<!---------------------------------------- script for table row values ---------------------------------->
    
   <script>
		(function () {
			if (window.addEventListener) {
				window.addEventListener('load', run, false);
			} else if (window.attachEvent) {
				window.attachEvent('onload', run);
			}

		function run() {
			var t = document.getElementById('tble');
			t.onclick = function (event) {
            event = event || window.event; //IE8
            var target = event.target || event.srcElement;
            while (target && target.nodeName != 'TR') { // find TR
                target = target.parentElement;
            }
            //if (!target) { return; } //tr should be always found
            var cells = target.cells; //cell collection 
            //var cells = target.getElementsByTagName('td'); //alternative
            if (!cells.length || target.parentNode.nodeName == 'THEAD') {
                return;
            } //end if
			
            var f1 = document.getElementById('fID');
			var f2 = document.getElementById('fName');
			var f3 = document.getElementById('depature');
			var f4 = document.getElementById('destination');
			var f5 = document.getElementById('dDate');
			var f6 = document.getElementById('AmountOfSeats');
			var f7 = document.getElementById('cost');
			
			f1.value = cells[0].innerHTML;
			f2.value = cells[1].innerHTML;
			f3.value = cells[2].innerHTML;
			f4.value = cells[3].innerHTML;
			f5.value = cells[4].innerHTML;
			f6.value = cells[5].innerHTML;
			f7.value = cells[6].innerHTML;
            //console.log(target.nodeName, event);
			};
		}

		})();
	</script>

	<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------> 
	<!-- jQuery first, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/js/bootstrap.js"></script>
	<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------> 
	
</body>
</html>
