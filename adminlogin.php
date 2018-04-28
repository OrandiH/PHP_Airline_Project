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
<body class="bg-primary" style="padding: 200px;">
<div class="container adminLogin">
	<div class="row justify-content-sm-center">
		<div class="col-4">
		  <div class="card border-info">
		    <div class="card-header text-center">Admin Login</div>
		    <div class="card-body">
		      <div class="row">
		        <div class="col">
		        <form class="form-signin" action="adminlogin.php" method= "POST">
		            <input type="text" class="form-control mb-2" placeholder="UserID" name="adminId" required autofocus>
		            <input type="password" class="form-control mb-2" placeholder="Password" name="adminPassword" required>
		            <button class="btn btn-lg btn-primary btn-block mb-1" type="submit">Log in</button>
		        </label>
		        </form>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
</div>

</body>
</html>

<?php
	
	function cleanInputs($value){

	$value = trim($value);
	$value = stripcslashes($value);
	$value = htmlspecialchars($value);
	return $value;

	}

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$adminId = $_POST['adminId'];
		$adminPassword = $_POST['adminPassword'];

		$cleanID = cleanInputs($adminId);
		$cleanPassword = cleanInputs($adminPassword);

		$serverName = "localhost";
		$dbUserName = "root";
		$dbPassword = "";
		$dbName = "Airlines_db";

		try{
			$pdo = new PDO("mysql:host=$serverName;dbname=$dbName",$dbUserName,$dbPassword);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


			//Set the default PDO fetch mode to Object
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

			//Set SQL statement using named parameters

			$sql = "SELECT * FROM admin WHERE username = :adminId && password = :adminPassword";

			$stmt = $pdo->prepare($sql);
			$stmt->execute([':adminId' => $adminId,':adminPassword'=> $adminPassword]);

			$admin = $stmt->fetchAll();
			$userCount = $stmt->rowCount();

			if($userCount == 1)
			{
				$_SESSION['admin'] = (array) $admin;
				echo '<div class="alert alert-success text-center col-4" role="alert">
				  <strong>Login Successfull</strong>
				</div>';
				header("Refresh: 1; url=adminDashboard.php");
			}
			else{
				header("Refresh:2; url=login.php");
				echo "<h2>Invalid userID or password</h2>";
			}

		}catch(PDOException $e){
		 	echo $sql. "<br>" . $e->getMessage();
		}
		$stmt = null;//Close connection to db
		$pdo = null;	

	}

?>
