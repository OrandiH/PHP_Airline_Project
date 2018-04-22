<!doctype html>
<html>
	<head>
		<title>ADMIN</title>
	</head>
	<body>
		<h2>Change Password</h2>
		<form  method = "post" action = "ChangePassword.php" >
			<p>Old Password</p>
			<input type="text" name="Password" placeholder="••••••">
			<p>New Password</p>
			<input type="password" name="Password1" placeholder="••••••">
			<p>Confirm New Password</p>
			<input type="password" name="Password2" placeholder="••••••">
			<input type="submit" name="" value="CHANGE PASSWORD">
		</form>
	</body>
</html>
 

<?php
//this page could be a modal on admin splash page
session_start();
if(!empty($_POST))
{   
	$NEWPassword = $_POST['Password1'];
	$OLDPassword = $_POST['Password'];
	$CONPassword = $_POST['Password2'];
	$email = $_SESSION['email'];
	//echo $_SESSION['admin_name'];
	
		
	$servername = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "airlines_db"; 
		
	$NEWPassword = password_hash($NEWPassword, PASSWORD_BCRYPT);
		
		
		
	try{
		$pdo = new PDO("mysql:host=$servername;dbname=$dbName",$dbUsername,$dbPassword);
		//set the PDO error mode to exception
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
		//set the default PDO fetch mode to Object
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
	
		
		//set SQL statement using named parameters
		$sql = 'Select* FROM admin WHERE username = :email';
		//echo $sql;
				
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['email'=> $email]);
		$users = $stmt->fetchAll(); 
		
		$PW = $users[0]-> password;
		
		if(password_verify($OLDPassword, $PW)){
			if(password_verify($CONPassword, $NEWPassword)){
			$sql = "UPDATE admin SET password = :Password WHERE username = :email";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(
                    ':Password'=> $NEWPassword,
                    ':email'=> $email,));
			//print "<h3> PASSWORD SUCCESFULLY CHANGE </h3>";
			header('Location:adminlogin.php');
		}
		Else{
				echo "Your new and Retype Password does not match !!!";
		}
		}
		else{
			echo"Your old password is wrong !!!";
		}
			
	}
	
	catch(PDOException $e)
	{
		echo $sql."<br />". $e->getMessage();
	}
		
	$stmt = null;
	$pdo = null;
}else{
	header('location:ChangePassword.php');
}
	 

?>