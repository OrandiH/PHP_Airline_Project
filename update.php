<?php
 
    $username = "";
    $fname = "";
    $lname = "";
    $age   = "";
    $address = "";

$user= $_GET['user'];
    $servername = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
    $dbName = "Airlines_DB";

    
	$pdo = new PDO("mysql:host=$servername;dbname=$dbName",$dbUsername,$dbPassword);
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
	$sql = 'SELECT * FROM customer WHERE username = :username';
		
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['username'=> $user]);
    $users = $stmt->fetchAll(); 
    
    $username = $users[0]-> userName;
	$fname = $users[0]-> firstName;
    $lname = $users[0]-> lastName;
	$address = $users[0]-> mailAddress;
    $age = $users[0]-> age;


  if($_POST)
  {
      $user1 = $_POST['username'];
      $firstname = $_POST['fname'];
      $lastname= $_POST['lname'];
      $address = $_POST['address'];
      $age = $_POST['age'];
      if(empty($user1) || empty($firstname) || empty($lastname) || empty($age) || empty($address))
      {
         echo 'check data to be update';
      }  else {

      $updateStmt = $pdo->prepare('UPDATE customer SET username = :email, firstName = :fname, lastName = :lname ,age = :age, mailAddress = :mailaddress WHERE username = :email');
    
      $updateStmt->execute(array(
                  ':email'=>$user1 ,
                  ':fname'=> $firstname,
                  ':lname'=> $lastname,
                  ':age'  => $age,
                  ':mailaddress'=> $address
      ));
      if($updateStmt)
    {
            echo '<script>alert("RECORD UPDATED");window.location="adminDashboard.php" </script>';
    }
}
}

?>

<!doctype html>
<html>
    <title> </title>
    <head></head>
    <body>
        <form method = "POST">
            USERNAME:<input type = "text" name = "username" value ="<?php echo $username ?>"> 
            FIRSTNAME:<input type = "text" name = "fname" value ="<?php echo  $fname ?>"> 
            LASTNAME:<input type = "text" name = "lname" value ="<?php echo $lname ?>"> 
            ADDRESS:<input type = "text" name = "address" value ="<?php echo $address ?>"> 
            AGE:<input type = "text" name = "age" required="" min="18" max = "129" value ="<?php echo $age ?>"> 
            <input type="submit" name="update" value="Update">
        </form>
    </body>

<html>


