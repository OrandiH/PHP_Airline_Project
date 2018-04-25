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
	 
	<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css">
	
	<style>
		table {  
		color: teal;
		font-family: Helvetica, Arial, sans-serif;
		width: 1050px; 
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
						<li class="nav-item"><a href="index.php" class="nav-link">View Profile</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
	<br><br>
	
	<div style="text-align: center">
	<?php
			//calculate discount if user exist
			function processDiscount($payment)
			{
				$discount = $payment * 0.2;
				return $discount;
			} //end processDiscount	
				
			//local variables
			$depCit = $desCity = $dDate = $msg = "";
			
			//set values 
			$depCit = $_SESSION['depatureCity'];
			$desCity = $_SESSION['destination'];
			$dDate =  $_SESSION['depatureDate'];
			
			
			
			if($depCit != "" && $desCity != "" && $desCity != "") 
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
								echo "<td> <button type='button float-right' class='btn btn-primary' id='selectBtn'>Select</button> </td>";
								
							echo "</tr>";
							} //end while
						echo "</table>";
						
						// Free result set
						unset($result);
						
						//header("location:MyProfile.php");
					} // end if
					else
					{
						$msg = '<label style="color:red">No flights are available for that date...!</label>';
					} //end else
								
					//close database connection
					$conn = null;
				} 
				catch (PDOException $e) 
				{
					$msg = "Error : ".$e->getMessage();
				} //end catch
			}  //end if
			else 
			{
				$msg = '<label style="color:red">You MUST enter fligh details first...!</label>';
			} //end else	
				
			echo"<br>";
			echo $msg;
	?>
	<div>
	<br><br>
	<!-- form starts here -->
	<form action="flight.php" method="POST">
		<div class="container" style="width: 100%; background-color: ivory;">
			<h2 style="text-align: center">CITIES<h2>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<br />

					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
						<ul class="carousel-indicators">
							<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
							<li data-target="#carousel-example-generic" data-slide-to="1"></li>
							<li data-target="#carousel-example-generic" data-slide-to="2"></li>
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
							<img src="img/ny.jpg" alt="New York" width="100%" height="350px">
							<div class="carousel-caption">
								<h3>New York</h3>
								<p>We love the Big Apple!</p>
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
<?php 
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST['registerBtn'])){
			header("location:index.php");
		}
	}
	?>
	
	<!---------------------------------------- script for table row values ---------------------------------->
	<script>
    
        var table = document.getElementById('table');
                
        for(var i = 1; i < table.rows.length; i++)
        {
            table.rows[i].onclick = function()
            {
                //rIndex = this.rowIndex;
                document.getElementById("fname").value = this.cells[0].innerHTML;
                document.getElementById("lname").value = this.cells[1].innerHTML;
                document.getElementById("age").value = this.cells[2].innerHTML;
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
