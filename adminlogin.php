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
		          <form class="form-signin">
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

	if($_SERVER["REQUEST_METHOD"] == "POST"){

	$adminId = $_POST['adminId'];
	$adminPassword = $_POST['adminPassword'];

	$cleanID = cleanInputs($adminId);
	$cleanPassword = cleanInputs($adminPassword);


}


}	

?>