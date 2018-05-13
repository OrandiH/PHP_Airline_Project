<?php
 session_start();
    $username = "";
    $fname = "";
    $lname = "";
    $age   = "";

    $user= $_SESSION['user'];
    $servername = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
    $dbName = "Airlines_DB";

    
	$pdo = new PDO("mysql:host=$servername;dbname=$dbName",$dbUsername,$dbPassword);
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
	$sql = 'SELECT * FROM admin WHERE username = :username';
		
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['username'=> $user]);
    $users = $stmt->fetchAll(); 
    
    $username = $users[0]-> username;
	$fname = $users[0]-> firstname;
    $lname = $users[0]-> lastname;
    $age = $users[0]-> age;


  if($_POST)
  {
      $user1 = $_POST['username'];
      $firstname = $_POST['fname'];
      $lastname= $_POST['lname'];
      $age = $_POST['age'];

      if(empty($user1) || empty($firstname) || empty($lastname) || empty($age))
      {
        echo '<script>alert("check data to be update");window.location="updateadmin.php" </script>';
      }  
      else {

      $updateStmt = $pdo->prepare('UPDATE admin SET username = :email, firstname = :fname, lastname = :lname ,age = :age WHERE username = :email');
    
      $updateStmt->execute(array(
                  ':email'=>$user1 ,
                  ':fname'=> $firstname,
                  ':lname'=> $lastname,
                  ':age'  => $age
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
            AGE:<input type = "text" name = "age" required="" min="18" max = "129" value ="<?php echo $age ?>"> 
            <input type="submit" name="update" value="Update">
        </form>
        <button type="button" class="btn btn-outline-primary" onClick="document.location.href='adminDashboard.php'">Back</button>
    </body>

<html>


