<?php
    session_start();
    //$AdminName = $_SESSION['admin_name'];
    //LOGOUT
    if(isset($_POST['logout'])){
        //unset($AdminName);
        header("location:index.php");
    }

    $dsn = 'mysql:host=localhost;dbname=airlines_db';
    $username = 'root';
    $password = '';

    try{
        // Connect To MySQL Database
        $con = new PDO($dsn,$username,$password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con2 = new PDO($dsn,$username,$password);
        $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (Exception $ex) { 
        echo 'Not Connected '.$ex->getMessage();
    }
    $email = "";
    $fname = "";
    $lname = "";
    $age = "";
    $address = "";
    $creditCardNumber = "";
    $password = "";

    $emailErr = "";
    $fnameErr = $lnameErr = $passwdErr = "";
    $ageErr = $addressErr = $ccNumErr = "";


    $flightid = "";
    $flightName = "";
    $depatureCity = "";
    $destinationCity = "";
    $flightCost = "";

    $flightidErr = $flightNameErr = $depatureCityErr = "";
    $destinationCityErr = $depatureDateErr = $returnDateErr = "";
    $AmountOfSeatsErr = $flightCostErr = "";


    function sanitize_data($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //Variables For Customer Table
        $cus_email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $cus_age = $_POST['age'];
        $cus_address = $_POST['address'];
        $cus_password = $_POST['password'];
        $cus_creditCardNum = $_POST['creditCardNumber'];
    
        //email validation
        if(empty($cus_email)){ 
            $emailErr = '<div class="alert alert-danger small" role="alert">
            Please Enter Email
          </div>'; 
        }
        else if(FILTER_VAR($cus_email,FILTER_VALIDATE_EMAIL))
        {
            $cus_email = $cus_email;
        }
        else{
            $emailErr = '<div class="alert alert-danger small" role="alert">
            Invalid Email Format
          </div>'; 
        }  
        
        //address validation
        if(empty($cus_address)){
            $addressErr = '<div class="alert alert-danger small" role="alert">
            Please Enter Address
          </div>'; 
        }else{
             $cus_address = $cus_address;
        }   
        if(empty($firstname)){
            $fnameErr = '<div class="alert alert-danger small" role="alert">
            Please Enter First Name
          </div>'; 
        }else if(preg_match("/^([A-Za-z-])?/",$firstname)){
                $firstname = $firstname;
                $firstname = sanitize_data($firstname);
        }else{
            $fnameErr = '<div class="alert alert-danger small" role="alert">
            Please Enter First Name
          </div>'; 
        }
        
        //lastname validation
        if(empty($lastname)){
            $lnameErr = '<div class="alert alert-danger small" role="alert">
            Please Enter Last Name
          </div>'; 
        }else if (preg_match("/^([A-Za-z])?/",$lastname )){
            $lastname = sanitize_data($lastname);
        }else{
            $lnameErr = '<div class="alert alert-danger small" role="alert">
            Please Enter Last Name
          </div>';  
        }   
    }

    //Search And Display Data 
    if(isset($_POST['search'])){
        if(empty($cus_email))
        {
            echo 'Enter The User email To Search';
            $fnameErr = $lnameErr = "";
            $ageErr = $addressErr = "";
        }else{
            $searchStmt = $con->prepare('SELECT userName,firstName,lastName,age,mailAddress  FROM customer WHERE username = :username');
            $searchStmt->execute(array(':username'=> $cus_email));
            
            if($searchStmt){
                $user = $searchStmt->fetch();
                if(empty($user)){
                    echo 'No Data For This Customer';
                    $emailErr = "";
                    $fnameErr = $lnameErr = "";
                    $ageErr = $addressErr = "";
                }
                $fnameErr = $lnameErr = "";
                $ageErr = $addressErr = "";
                
                $email = $user[0];
                $fname = $user[1];
                $lname = $user[2];
                $age   = $user[3];
                $address = $user[4];
            }
        }
    }

    //START FROM HERE

    // Insert Data Into Customer Table
    if(isset($_POST['insert'])){
        if(empty($cus_email) || empty($firstname) || empty($lastname) || empty($cus_age) || empty($cus_address) || empty($cus_password) || empty($cus_creditCardNum)){
            echo 'Enter The User Data To Insert';
        }else{
            $insertStmt = $con->prepare('INSERT INTO customer (username,firstName,lastName,age,mailAddress, credit_card_Num) VALUES(:email,:fname,:lname,:age,:mailaddress, :creditCardNum)');
            $insertStmt2 = $con2->prepare('INSERT INTO customer_login (userName, password) VALUES (:email,:cus_pass)');
            $insertStmt->execute(array(
                ':email'=> $cus_email,
                ':fname'=> $firstname,
                ':lname'=> $lastname,
                ':age'=> $cus_age,
                ':mailaddress'=> $cus_address,
                ':creditCardNum'=> $cus_creditCardNum
            )) ;
            $insertStmt2->execute(array(
                ':email'=> $cus_email,
                ':cus_pass'=> $cus_password
            )) ;
            if($insertStmt )
            {
                echo 'Data Inserted';
            }
            if($insertStmt2){

            }
        }
    }
    
    if(isset($_GET['insertFlight'])){

        //Variables For Flight Table
        $flight_ID = $_GET['flightID'];
        $flight_Name = $_GET['flightName'];
        $depart_City = $_GET['depatureCity'];
        $destination_City = $_GET['destinationCity'];
        $departure_Date = $_GET['depatureDate'];
        $return_Date = $_GET['returnDate'];
        $numberOfSeats = $_GET['AmountOfSeats'];
        $flight_Cost = $_GET['flightCost'];


        if(empty($flight_ID) || empty($flight_Name) || empty($depart_City) || empty($destination_City) || empty($departure_Date) || empty($return_Date) || empty($numberOfSeats || empty($flight_Cost))){
            echo 'Enter The User Data To Insert';
        }else{
            $insertStmt = $con->prepare('INSERT INTO flight(flightID, flightName, depatureCity, destinationCity, depatureDate, returnDate, AmountOfSeats) VALUES (:flightID, :flightName, :departCity, :destinationCity, :departDate, :returnDate, :numberSeats)');
            $insertStmt2 = $con2->prepare('INSERT INTO flight_cost(flightID, cost) VALUES (:flightID, :flightCost)');
            $insertStmt->execute(array(
                ':flightID'=> $flight_ID,
                ':flightName'=> $flight_Name,
                ':departCity'=> $depart_City,
                ':destinationCity'=> $destination_City,
                ':departDate'=> $departure_Date,
                ':returnDate'=> $return_Date,
                ':numberSeats'=> $numberOfSeats
            )) ;
            $insertStmt2->execute(array(
                ':flightID'=> $flight_ID,
                ':flightCost'=> $flight_Cost
            )) ;
            if($insertStmt )
            {
                echo 'Data Inserted';
            }
            if($insertStmt2){

            }
        }
    }

    //Update Data From Customer Table
    if(isset($_POST['update'])){
        $updateStmt = $con->prepare('UPDATE customer SET username = :email, firstName = :fname, lastName = :lname ,age = :age, mailAddress = :mailaddress, credit_card_Num = :creditCardNum WHERE username = :email');
        $updateStmt2 = $con2->prepare('UPDATE customer_login SET username = :email, password = :cus_pass WHERE username = :email');
        $updateStmt->execute(array(
            ':email'=> $cus_email,
            ':fname'=> $firstname,
            ':lname'=> $lastname,
            ':age'=> $cus_age,
            ':mailaddress'=> $cus_address,
            ':creditCardNum'=> $cus_creditCardNum
        ));
        $updateStmt2->execute(array(
            ':email'=> $cus_email,
            ':cus_pass'=> $cus_password
        )) ;
        if($updateStmt)
        {
            echo 'Data Updated';
        }
        if($updateStmt2)
        {
        }
    }

    if(isset($_GET['updateFlight'])){

        //Variables For Flight Table
        $flight_ID = $_GET['flightID'];
        $flight_Name = $_GET['flightName'];
        $depart_City = $_GET['depatureCity'];
        $destination_City = $_GET['destinationCity'];
        $departure_Date = $_GET['depatureDate'];
        $return_Date = $_GET['returnDate'];
        $numberOfSeats = $_GET['AmountOfSeats'];
        $flight_Cost = $_GET['flightCost'];


        $updateStmt = $con->prepare('UPDATE `flight` SET flightID = :flightID, flightName = :flightName, depatureCity = :departCity, destinationCity = :destinationCity, depatureDate = :departDate, returnDate = :returnDate, AmountOfSeats = :numberSeats WHERE flightID = :flightID');
        $updateStmt2 = $con2->prepare('UPDATE `flight_cost` SET flightID = :flightID, cost = :flightCost WHERE flightID = :flightID');
        $updateStmt->execute(array(
            ':flightID'=> $flight_ID,
            ':flightName'=> $flight_Name,
            ':departCity'=> $depart_City,
            ':destinationCity'=> $destination_City,
            ':departDate'=> $departure_Date,
            ':returnDate'=> $return_Date,
            ':numberSeats'=> $numberOfSeats
        ));
        $updateStmt2->execute(array(
            ':flightID'=> $flight_ID,
            ':flightCost'=> $flight_Cost
        )) ;
        if($updateStmt)
        {
            echo 'Data Updated';
        }
        if($updateStmt2)
        {
        }
    }


    // Delete Data From Customer Table
    if(isset($_POST['delete']))
    {
        if(empty($cus_email))
        {
            echo 'Enter The User email To Delete';
            $fnameErr = $lnameErr = "";
            $ageErr = $addressErr = "";
        }  else {
            $stmt = $con->prepare('DELETE FROM customer_login WHERE username = :email');
            $stmt->execute(array(
                ':email'=> $cus_email
            ));

            
            $deleteStmt = $con->prepare('DELETE FROM customer WHERE username = :email');
            $deleteStmt2 = $con->prepare('DELETE FROM customer_login WHERE username = :email');
            $deleteStmt->execute(array(
                        ':email'=> $cus_email
            ));
            $deleteStmt2->execute(array(
                ':email'=> $cus_email
            ));
            
            if($deleteStmt and $stmt)
            {
                    echo 'User Deleted';
                    $fnameErr = $lnameErr = "";
                    $ageErr = $addressErr = "";

            }
            if($deleteStmt2 and $stmt)
            {
            }
            
        }
    }

    if(isset($_GET['deleteFlight']))
    {

        //Variables For Flight Table
        $flight_ID = $_GET['flightID'];
        $flight_Name = $_GET['flightName'];
        $depart_City = $_GET['depatureCity'];
        $destination_City = $_GET['destinationCity'];
        $departure_Date = $_GET['depatureDate'];
        $return_Date = $_GET['returnDate'];
        $numberOfSeats = $_GET['AmountOfSeats'];
        $flight_Cost = $_GET['flightCost'];

        if(empty($flight_ID))
        {
            echo 'Enter The Flight ID To Delete';
            $fnameErr = $lnameErr = "";
            $ageErr = $addressErr = "";
        }  else {
            $stmt = $con->prepare('DELETE FROM flight_cost WHERE flightID = :flightID');
            $stmt->execute(array(
                ':flightID'=> $flight_ID
            ));

            
            $deleteStmt = $con->prepare('DELETE FROM flight WHERE flightID = :flightID');
            $deleteStmt2 = $con->prepare('DELETE FROM flight_cost WHERE flightID = :flightID');
            $deleteStmt->execute(array(
                ':flightID'=> $flight_ID
            ));
            $deleteStmt2->execute(array(
                ':flightID'=> $flight_ID
            ));
            
            if($deleteStmt and $stmt)
            {
                    echo 'User Deleted';
                    $fnameErr = $lnameErr = "";
                    $ageErr = $addressErr = "";

            }
            if($deleteStmt2 and $stmt)
            {
            }
            
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="assets/style.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/style.css">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" role="navigation">
	    <div class="container">
	        <a class="navbar-brand" href="#">Admin Dashboard</a>
	        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
	            &#9776;
	        </button>
	        <div class="collapse navbar-collapse" id="exCollapsingNavbar">
	            <ul class="nav navbar-nav flex-row justify-content-between ml-auto">
	                <li class="nav-item">
	                    <button type="button" class="btn btn-outline-primary">Log Out</button>
	                </li>
	            </ul>
	        </div>
	    </div>
	</nav>

    <div class="main-container" style="padding-top: 8%">

<?php

echo "<div class='container border col-6'>";
echo "<table class='table-sm table-bordered table-striped'>";
echo "<caption>List Of Current Customers</caption>";
echo "<tr><th>Email</th><th>First Name</th><th>Last Name</th><th>Age</th><th>Address</th><th>CreditCard Number</th></tr>";

class TableRows extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td>" . parent::current(). "</td>";
    }

    function beginChildren() { 
        echo "<tr>"; 
    } 

    function endChildren() { 
        echo "</tr>" . "\n";
    } 
} 
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
	$dbName = "airlines_db"; 

try {
	$conn = new PDO("mysql:host=$servername;dbname=$dbName",$dbUsername,$dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT username,firstName,lastName,age,mailAddress, credit_card_Num FROM customer "); 
    $stmt->execute();


    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
        echo $v;
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
echo "<br>";
echo "</div>";
echo "<br>";
?>
        <div class="container" style="margin-left:22%;"> 
            <form class="col-8 border form-control-small" action="adminDashboard.php" method="POST">
                <legend>Customer Data</legend>
            <div class="form-row">
                <div class="col-4">
                    <input type="text" class="form-control" placeholder="First Name" name="firstname" value="<?php echo $fname;?>">
                    <span><?php echo $fnameErr?></span>
                </div>
                <div class="col-4">
                <input type="text" class="form-control" placeholder="Last Name" name="lastname" value="<?php echo $lname;?>">
                    <span><?php echo $lnameErr?></span>
                </div>
                <div class="col-4">
                    <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $email;?>">
                    <span><?php echo $emailErr?></span>
                </div>
		    </div>
            <br>
            <div class="form-row row">
                <div class="col-4">
                    <input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo $password;?>">
                    <?php echo $passwdErr; ?>
                </div>
                <div class="col-4">
                    <input type="number" class="form-control" placeholder="Age" name="age" min="1" value="<?php echo $age;?>">
                    <?php echo $ageErr; ?>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" placeholder="Credit Card Number" name="creditCardNumber">
                    <?php echo $ccNumErr; ?>
                </div>
		    </div>
            <br>
		    <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Address" name="address" >
                    <?php echo $addressErr; ?>
                </div>
		    </div>
            <br>
            <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary" name="insert">Create</button>
            <button type="submit" class="btn btn-success" name="update">Update</button>
            <button type="submit" class="btn btn-danger" name="delete">Delete</button>
            <button type="submit" class="btn btn-secondary" name="Search">Search</button>
		    </div>
            </form>
        </div>
        <div>
        <br><br>


<?php

echo "<div class='container border col-8' style='margin-left: 22%;'>";
echo "<table class='table-sm table-bordered table-striped'>";
echo "<caption>List Of Flights</caption>";
echo "<tr><th>Flight ID</th><th>Flight Name</th><th>Depart From</th><th>Arrive At</th><th>Depart Date</th><th>Return Date</th><th>Number Of Seats</th><th>Cost</th></tr>";
    class TableRows2 extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td>" . parent::current(). "</td>";
    }

    function beginChildren() { 
        echo "<tr>"; 
    } 

    function endChildren() { 
        echo "</tr>" . "\n";
    } 
} 
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
	$dbName = "airlines_db"; 

try {
	$conn = new PDO("mysql:host=$servername;dbname=$dbName",$dbUsername,$dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$stmt = $conn->prepare("SELECT flightID, flightName, depatureCity, destinationCity, depatureDate, returnDate, AmountOfSeats FROM flight"); 
    $stmt = $conn->prepare("SELECT flight.flightID, flight.flightName, flight.depatureCity, flight.destinationCity, flight.depatureDate, flight.returnDate, flight.AmountOfSeats, flight_cost.cost FROM flight INNER JOIN flight_cost ON flight.flightID = flight_cost.flightID");
    $stmt->execute();


    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
        echo $v;
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
echo "<br>";
echo "</div>";
echo "<br>";
?>

            <div class="container" style="margin-left:22%;"> 
            <form class="col-8 border form-control-small" action="adminDashboard.php" method="GET">
                <legend>Flight Data</legend>
            <div class="form-row">
                <div class="col-4">
                    <input type="text" class="form-control" placeholder="Fligh ID" name="flightID" value="<?php echo $flightid;?>">
                    <span><?php echo $flightidErr?></span>
                </div>
                <div class="col-4">
                <input type="text" class="form-control" placeholder="Flight Name" name="flightName" value="<?php echo $flightName;?>">
                    <span><?php echo $flightNameErr?></span>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" name="depatureCity" placeholder="Departure City" value="<?php echo $depatureCity;?>">
                    <span><?php echo $depatureCityErr?></span>
                </div>
		    </div>
            <br>
            <div class="form-row row">
                <div class="col-4">
                    <input type="text" class="form-control" name="destinationCity" placeholder="Destination City" value="<?php echo $destinationCity;?>">
                    <?php echo $destinationCityErr; ?>
                </div>
                <div class="col-4">
                    <input type="date" class="form-control" placeholder="Departure Date" name="depatureDate" min="1" value="<?php echo $depatureDate;?>">
                    <?php echo $depatureDateErr; ?>
                </div>
                <div class="col-4">
                    <input type="date" class="form-control" placeholder="Return Date" name="returnDate" value="<?php echo $returnDate;?>">
                    <?php echo $returnDateErr; ?>
                </div>
		    </div>
            <br>
		    <div class="form-row">
                <div class="col-6">
                    <input type="number" class="form-control" placeholder="Amount Of Seats" name="AmountOfSeats" value="<?php echo $AmountOfSeats;?>">
                    <?php echo $AmountOfSeatsErr; ?>
                </div>
                <div class="col-6">
                    <input type="number" class="form-control" placeholder="Cost" name="flightCost" value="<?php echo $flightCost;?>">
                    <?php echo $flightCostErr; ?>
                </div>
		    </div>
            <br>
            <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary" name="insertFlight">Create</button>
            <button type="submit" class="btn btn-success" name="updateFlight">Update</button>
            <button type="submit" class="btn btn-danger" name="deleteFlight">Delete</button>
            <button type="submit" class="btn btn-secondary" name="SearchFlight">Search</button>
		    </div>
            </form>
        </div>
        <div>
        <br><br>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</body>
</html>