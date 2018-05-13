<?php
	session_start();
	//Include sql code to update and delete data from database if update button or delete button is set
	$userName = $_SESSION['users'][0]['userName']; //Get username From session
	//Check server request method and then if update button is set
	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		if(isset($_POST['update']))
		{
			//Check if address and cell nunber fields were both set
			if(isset($_POST['address']) && isset($_POST['age']))
			{
				$address = $_POST['address'];
				$age = $_POST['age'];
				//Database info
					$serverName = "localhost";
					$dbUserName = "root";
					$dbPassword = "";
					$dbName = "Airlines_DB";
			try 
			{
			$conn = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUserName, $dbPassword);
			    // set the PDO error mode to exception
			    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    $sql = "UPDATE customer SET mailAddress='$address', age='$age' WHERE userName='$userName'";
			    // Prepare statement
			    $stmt = $conn->prepare($sql);
			    // execute the query
			    $stmt->execute();
			    // echo a message to say the UPDATE succeeded
			    echo "<script> alert(".$stmt->rowCount() . " records UPDATED successfully);</script>";
   			 }
		 	catch(PDOException $e)
 	   			{
  				  echo $sql . "<br>" . $e->getMessage();
   	   			}
				$conn = null;
			}
			//Check if the address field was set
			else if(isset($_POST['address']))
			{
				$address = $_POST['address'];
					//Database info
					$serverName = "localhost";
					$dbUserName = "root";
					$dbPassword = "";
					$dbName = "Airlines_db";
			try 
			{
			$conn = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUserName, $dbPassword);
			    // set the PDO error mode to exception
			    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    $sql = "UPDATE customer SET mailAddress='$address' WHERE userName='$userName'";
			    // Prepare statement
			    $stmt = $conn->prepare($sql);
			    // execute the query
			    $stmt->execute();
			    // echo a message to say the UPDATE succeeded
                echo $stmt->rowCount()."records UPDATED successfully";
   			 }
		 	catch(PDOException $e)
 	   			{
  				  echo $sql . "<br>" . $e->getMessage();
   	   			}
				$conn = null;
			} 
			else if(isset($_POST['age'])) //Check if the age field has been set
			{
				$age = $_POST['age'];
				//Database info
					$serverName = "localhost";
					$dbUserName = "root";
					$dbPassword = "";
					$dbName = "Airlines_db";
			try 
			{
			$conn = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUserName, $dbPassword);
			    // set the PDO error mode to exception
			    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				// sql to delete a record
			    $sql = "UPDATE customer SET age='$age' WHERE userName='$userName'";
				 $stmt = $conn->prepare($sql);
			    // execute the query
			    $stmt->execute();
                // echo a message to say the UPDATE succeeded
                echo $stmt->rowCount() . " records UPDATED successfully)";
   			 }
		 	catch(PDOException $e)
 	   			{
  				  echo $sql . "<br>" . $e->getMessage();
   	   			}
				$conn = null;
			}
		}
		else if (isset($_POST['delete'])) //Check if delete button has been set
		{
			//Database info
			$serverName = "localhost";
			$dbUserName = "root";
			$dbPassword = "";
			$dbName = "Airlines_db";
			try {
			    $conn = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUserName, $dbPassword);
			    // set the PDO error mode to exception
			    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    // sql to delete a record
			    $sql = "DELETE FROM customer WHERE userName='$userName'";
			    // use exec() because no results are returned
			    $conn->exec($sql);
                echo "Record deleted successfully";
                header("Refresh:3; url=index.php");
			    }
			catch(PDOException $e)
		    {
		    echo $sql . "<br>" . $e->getMessage();
		    }
			$conn = null;
		}
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>User Profile</title>
</head>
<body>
	<form action="profile.php" method="POST">
		<fieldset>
			<legend>User Profile</legend>
			<h3>See below your user information</h3>
        <p>User name: <input type="text" name="userName" placeholder="<?php echo $_SESSION['users'][0]['userName'];?>" /></p><br/>
		<p>First Name: <input type="text" name="fName" placeholder="<?php echo $_SESSION['users'][0]['firstName'];?>" /></p><br/>
		<p>Last Name: <input type="text" name="lName" placeholder="<?php echo $_SESSION['users'][0]['lastName'];?>"/></p><br/>
		<p>Address : <input type="text" name="address" placeholder="<?php echo $_SESSION['users'][0]['mailAddress'];?>"/></p><br/>
		<p>Age: <input type="text" name="age" placeholder="<?php echo $_SESSION['users'][0]['age'];?>" /></p><br/>
		<button type="submit" name="update">Update</button> 
		<button type= "submit" name="delete">Delete</button><br/>
        <button><a href="changeUserPassword.php" target="_blank">Change Password</a></button></br/>
	</form>
	</fieldset>
</body>
</html>