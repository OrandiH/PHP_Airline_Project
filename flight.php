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

	 
	<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css">
	
	<style>
		table { 
			font-size: 15px;
			color: teal;
			font-family: Helvetica, Arial, sans-serif;
			width: 100%; 
			border-collapse: 
			collapse; border-spacing: 0; 
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
			background: #FAFAFA;
			text-align: center;
		}

		/* Cells in even rows (2,4,6...) are one color */        
		tr:nth-child(even) td { background: #F1F1F1; }   

		/* Cells in odd rows (1,3,5...) are another (excludes header cells)  */        
		tr:nth-child(odd) td { background: #FEFEFE; }  

		tr td:hover { background: #666; color: yellow; }  
		/* Hover cell effect! */
		
		p {
			font-size: 18px;
			color: blue;
		}
		.a{
			padding: 15px 32px;
			text-align: center;
			font-size: 16px;
		}
	</style>
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
						<li class="nav-item"><a href="index.php" class="nav-link">Return to Home</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
	<br><br> <br><br><br><br>
	
	<!-- form starts here -->
	<form action="flight.php" method="POST">
		<div class="container" style="width: 100%; height: 500px;; background-color: ivory;">
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
				//calculate discount if user exist
				function processDiscount($payment)
				{
					$discount = $payment * 0.2;
					return $discount;
				} //end processDiscount	
					
				//local variables
				$depCit = $desCity = $dDate = $msg = $trip = $var = "";
				
				//set values  
				//$trip = $_SESSION['book_info']['tripType'];
				$depCit = $_SESSION['book_info']['departure'];
				$desCity = $_SESSION['book_info']['arrival'];
				$dDate =  $_SESSION['book_info']['departDate'];
				$rDate =  $_SESSION['book_info']['returnDate'];
				
				//oneway trip flight search
				if($depCit != "" && $desCity != "" && $dDate!= "") 
				{
					try {
						//database connection
						include("connection.php");
						
						//search database for user
						$query = "select * from flight where depatureCity='$depCit' and destinationCity='$desCity' and depatureDate='$dDate'";					
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
							$fl_msg = "<label style='color: blue'> CHOOSE YOUR FLIGHT OPTION...!</label>";
							echo "<br>";
							echo $fl_msg;
							
							//table header here
							echo "<table>";
								echo "<tr>";
									echo "<th>FLIGHT ID</th>"; 
									echo "<th>FLIGHT NAME</th>"; 
									echo "<th>DEPATURE CITY</th>";
									echo "<th>DESTINATION CITY</th>";
									echo "<th>DEPATUREDATE</th>";
									echo "<th>AMOUNTOFSEATS</th>";
									echo "<th>OPTION</th>";
								echo "</tr>";
							
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
							{					
								//out record from database								
								echo "<tr>";
									echo "<td>" . $row['flightID'] . "</td>";
									echo "<td>" . $row['flightName'] . "</td>";
									echo "<td>" . $row['depatureCity']. "</td>";
									echo "<td>" . $row['destinationCity']. "</td>";
									echo "<td>" . $row['depatureDate']. "</td>";
									echo "<td>" . $row['AmountOfSeats']. "</td>";
									echo "<td> <button type='submit' class='btn btn-primary' href='index.php' name='selectBtn'>Select</button> </td>";									
								echo "</tr>";
								} //end while
							echo "</table>";
							
							// Free result set
							unset($result);
							
							if(isset($_GET['selectBtn'])){
								//$var = $_SESSION['val'];
								header("location:index.php");
							}
						} // end if
						else
						{
							$msg = '<label style="color:red">No matchig flights are available...!</label>';
						} //end else
									
						//close database connection
						$conn = null;
					} 
					catch (PDOException $e) 
					{
						$msg = "Error : ".$e->getMessage();
					} //end catch
				}  //end if
				else if ($depCit != "" && $desCity != "" && $dDate != "" && $rDate != ""  )
				{
					//round trip flight search
					try {
						//database connection
						include("connection.php");
						
						//search database for user
						$query = "select * from flight where depatureCity='$depCit' and destinationCity='$desCity' and depatureDate='$dDate' and returnDate ='rDate'";					
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
							$fl_msg = "<label style='color: blue'> CHOOSE YOUR FLIGHT OPTION...!</label>";
							echo "<br>";
							echo $fl_msg;
							
							//table header here
							echo "<table>";
								echo "<tr>";
									echo "<th>FLIGHT ID</th>"; 
									echo "<th>FLIGHT NAME</th>"; 
									echo "<th>DEPATURE CITY</th>";
									echo "<th>DESTINATION CITY</th>";
									echo "<th>DEPATUREDATE</th>";
									echo "<th>RETURNDATE</th>";
									echo "<th>AMOUNTOFSEATS</th>";
									echo "<th>OPTION</th>";
								echo "</tr>";
							
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
							{					
								//out record from database								
								echo "<tr>";
									echo "<td>" . $row['flightID'] . "</td>";
									echo "<td>" . $row['flightName'] . "</td>";
									echo "<td>" . $row['depatureCity']. "</td>";
									echo "<td>" . $row['destinationCity']. "</td>";
									echo "<td>" . $row['depatureDate']. "</td>";
									echo "<td>" . $row['returnDate']. "</td>";
									echo "<td>" . $row['AmountOfSeats']. "</td>";
									echo "<td> <button type='submit' class='btn btn-primary' href='index.php' name='selectBtn'>Select</button> </td>";	
									
								echo "</tr>";
								} //end while
							echo "</table>";
							
							// Free result set
							unset($result);
							
							if(isset($_GET['selectBtn'])){
								//$var = $_SESSION['val'];
								header("location:index.php");
							}
						} // end if
						else
						{
							$msg = '<label style="color:red">No matchig flights are available...!</label>';
						} //end else
									
						//close database connection
						$conn = null;
					} 
					catch (PDOException $e) 
					{
						$msg = "Error : ".$e->getMessage();
					} //end catch
					
				} //end else if
				else 
				{
					$msg = '<label style="color:red">You MUST enter your fligh details first...!</label>';
				} //end else	
					
				echo"<br>";
				echo $msg;
					
		?>
	</div>

	<!---------------------------------------- script for table row values ---------------------------------->
	<script>
    
        var table = document.getElementById('table');
                
        for(var i = 1; i < table.rows.length; i++)
        {
            table.rows[i].onclick = function()
            {
                //rIndex = this.rowIndex;
                document.getElementById("flightID").value = this.cells[0].innerHTML;
                document.getElementById("flightName").value = this.cells[1].innerHTML;
                document.getElementById("depatureCity").value = this.cells[2].innerHTML;
				document.getElementById("destinationCity").value = this.cells[3].innerHTML;
                document.getElementById("destinationCity").value = this.cells[4].innerHTML;
                document.getElementById("depatureDate").value = this.cells[5].innerHTML;
				document.getElementById("returnDate").value = this.cells[6].innerHTML;
                };
				
        } //end for
		
    </script>

	<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------> 
	<!-- jQuery first, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/js/bootstrap.js"></script>
	<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------> 
	
</body>
</html>
