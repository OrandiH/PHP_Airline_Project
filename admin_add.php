<!doctype html>
<html>
	<head>
		<title>ADD Staff</title
	</head>
	<body>
			<h2>Add New Staff</h2>
			<form  method = "post" action = "admin_add.php" >
				<p>Email</p>
				<input type="text" name="email" placeholder="Enter Email" required = "">
				<p>Password</p>
				<input type="password" name="Password" placeholder="••••••" required = "">
				<p>FirstName</p>
				<input type="text" name="firstname" placeholder="Enter firstname" required = "">
				<p>LastName</p>
				<input type="text" name="lastname" placeholder="Enter last name" required = "">
				<p>Age</p>
				<input type="number" name="age" placeholder="Enter Age" required = ""> 
				<input type="submit" name="" value="ADD">
			</form>
		
	</body>
</html>
	 
<?php
	 if($_SERVER["REQUEST_METHOD"]== "POST")
	 {
		$email = $_POST['email'];
		$Password = $_POST['Password'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$age = $_POST['age'];
		
		
		$servername = "localhost";
		$dbUsername = "root";
		$dbPassword = "";
		$dbName = "Airlines_DB";
		
		$storedPassword = password_hash($Password, PASSWORD_BCRYPT);
		
		try{
			$conn = new PDO("mysql:host=$servername;dbname=$dbName",$dbUsername,$dbPassword);
			$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO admin(username,password,firstName,lastName,age) VALUES ('$email','$storedPassword','$firstname','$lastname','$age')";
			$conn->exec($sql);
			echo"New record created successfully";
			header("Refresh: 1; url=adminlogin.php");
		}
		catch(PDOException $e)
		{
			echo $sql."<br>". $e->getMessage();
		}
		$conn = null;
	 }

?>  