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
    
} catch (Exception $ex) {
    
    echo 'Not Connected '.$ex->getMessage();
    
}
$email = "";
$fname = "";
$lname = "";
$age = "";
$address = "";

$emailErr = "";
$fnameErr = $lnameErr = "";
$ageErr = $addressErr = "";

function sanitize_data($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}



if($_SERVER["REQUEST_METHOD"] == "POST"){
$cus_email = $_POST['email'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$cus_age = $_POST['age'];
$cus_address = $_POST['address'];
  
//email validation
	if(empty($cus_email)){
		$emailErr = " * EMAIL IS REQUIRED"; 
	}
	else if(FILTER_VAR($cus_email,FILTER_VALIDATE_EMAIL))
	{
		$cus_email = $cus_email;
	}
	else{
		$emailErr = " * INVAILD FORMAT";
	}  
	
	//address validation
		if(empty($cus_address)){
			$addressErr = " * ADDRESS IS REQUIRED"; 
		}else{
			$cus_address = $cus_address;
		}	
	if(empty($firstname)){
		$fnameErr = " * FIRST NAME IS REQUIRED"; 
		}
		else if(preg_match("/^([A-Za-z-])?/",$firstname)){
			$firstname = $firstname;
			$firstname = sanitize_data($firstname);
		}else
		{
			$fnameErr = " * INVAILD FIRST NAME , LETTERS ARE REQUIRED";
		}
	 
	 //lastname
		if(empty($lastname)){
			$lnameErr = " * LAST NAME IS REQUIRED" ;
		}else if (preg_match("/^([A-Za-z])?/",$lastname )){
			$lastname = sanitize_data($lastname);
		}else{
		$lnameErr = " * INVAILD LAST NAME , LETTERS ARE REQUIRED";  
		}	
 
//Search And Display Data 

if(isset($_POST['search']))
{
    if(empty($cus_email))
    {
        echo 'Enter The User email To Search';
        $fnameErr = $lnameErr = "";
        $ageErr = $addressErr = "";
    }  else {
        
        $searchStmt = $con->prepare('SELECT userName,firstName,lastName,age,mailAddress  FROM customer WHERE username = :username');
        $searchStmt->execute(array(
                    ':username'=> $cus_email
        ));
        
        if($searchStmt)
        {
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
}




// Insert Data

if(isset($_POST['insert']))
{
    if(empty($cus_email) || empty($firstname) || empty($lastname) || empty($cus_age) || empty($cus_address)    )
    {
       echo 'Enter The User Data To Insert';
    }  else {
        
        $insertStmt = $con->prepare('INSERT INTO customer (username,firstName,lastName,age,mailAddress) VALUES(:email,:fname,:lname,:age,:mailaddress)');
        $insertStmt->execute(array(
                    ':email'=> $cus_email,
                    ':fname'=> $firstname,
                    ':lname'=> $lastname,
					':age'=>$cus_age,
					':mailaddress'=>$cus_address
        )) ;
        
        if($insertStmt)
        {
                echo 'Data Inserted';
        }
        
    }
} 

//Update Data

if(isset($_POST['update']))
{
   
    
        $updateStmt = $con->prepare('UPDATE customer SET username = :email, firstName = :fname, lastName = :lname ,age = :age, mailAddress = :mailaddress WHERE username = :email');
        $updateStmt->execute(array(
                    ':email'=> $cus_email,
                    ':fname'=> $firstname,
                    ':lname'=> $lastname,
                    ':age'  => $cus_age,
					':mailaddress'=> $cus_address
        ));
        
        if($updateStmt)
        {
                echo 'Data Updated';
        }
        
    
}

// Delete Data

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
        $deleteStmt->execute(array(
                    ':email'=> $cus_email
        ));
        
        if($deleteStmt and $stmt)
        {
                echo 'User Deleted';
                $fnameErr = $lnameErr = "";
                $ageErr = $addressErr = "";

        }
        
    }
}

?>

<!doctype html>
<html>
<head>
<title> Manage Customer</title>
	<body>
                <form action="managecus.php" method="POST" >
                <table cellpadding = "5"> 
                    <tr>
					<td><input type="text" name="email" placeholder="email" value="<?php echo $email;?>"></td><td><span><?php echo $emailErr?></span></td><br><br>
                    </tr>
                    <tr>
                    <td><input type="text" name="firstname" placeholder="First Name" value="<?php echo $fname;?>"></td><td><span><?php echo $fnameErr?></span></td><br><br>
                    </tr>
                    <tr>
                    <td><input type="text" name="lastname" placeholder="Last Name" value="<?php echo $lname;?>"></td><td><span><?php echo $lnameErr?></span></td><br><br>
                    </tr>
                    <tr>
                    <td><input type="number" name="age"  min = "18" max = "75" placeholder="age" value="<?php echo $age;?>"></td><td></td><br><br>
                    </tr>
                    <tr>
                    <td><input type="text" name="address" placeholder="address" value="<?php echo $address;?>"></td><td><span><?php echo $addressErr?></span></td><br><br>
                    </tr>
                    <tr>
                    <td><input type="submit" name="insert" value="Insert">
                    <input type="submit" name="update" value="Update">
                    <input type="submit" name="delete" value="Delete">
                    <input type="submit" name="search" value="Search"></td>
                    </tr>
                </table>
                </form> 
			</br>
			</br>
	</body>
</html>

<?php
echo "<table style='border: solid 1px black;'>";
echo "<tr><th>EMAIL</th><th>FIRSTNAME</th><th>LASTNAME</th><th>AGE</th><th>ADDRESS</th></tr>";

class TableRows extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
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
    $stmt = $conn->prepare("SELECT username,firstName,lastName,age,mailAddress FROM customer "); 
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

echo "<br></br><br></br>";

?>