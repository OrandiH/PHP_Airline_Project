<!doctype html>
<html>
	<head>
		<title>Customer - Change Password</title>
	</head>
	<body>
        <fieldset>
        <legend><h2>Change Password</h2></legend>
		<form method = "POST" action = "changeUserPassword.php" >
			<p>Old Password</p>
			<input type="password" name="Password" placeholder="Old password">
			<p>New Password</p>
			<input type="password" name="Password1" placeholder="New password">
			<p>Confirm New Password</p>
			<input type="password" name="Password2" placeholder="Confirm new password"><br/><br/>
			<input type="submit" name="submitBtn" value="CHANGE PASSWORD">
		</form>
        </fieldset>
	</body>
</html>
 
<?php
include('db.php');
session_start();
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(isset($_POST['submitBtn']))
    {
        $OLDPassword = $_POST['Password'];
        $NEWPassword = $_POST['Password1'];
        $CONPassword = $_POST['Password2'];
        
        $userName = $_SESSION['users'][0]['userName'];
        $hash_Password = md5($NEWPassword);

        //Database info
        $serverName = "localhost";
        $dbUserName = "root";
        $dbPassword = "";
        $dbName = "Airlines_DB";
            
        try{
            
            //set SQL statement using named parameters
            $stmt = $DBcon->prepare("SELECT * FROM customer WHERE userName = :username");
			$stmt->bindparam(':username', $userName);
			$stmt->execute();//This is key
            $users = $stmt->fetchAll(); 
            $PW = $users[0]['password'];
            $OLDPassword = md5($OLDPassword);
            
            if($OLDPassword == $PW){
                if($CONPassword == $NEWPassword){
                $sql = "UPDATE customer SET password = :Password WHERE userName = :username";
                $stmt = $DBcon->prepare($sql);
                $stmt->bindparam(':username', $userName);
                $stmt->bindparam(':Password', $hash_Password);
                $stmt->execute();
                echo "<h3> PASSWORD SUCCESFULLY CHANGE </h3>";
                header("Refresh:3; url=index.php");
                
                }
                else{
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
        $DBcon = null;
    }

}

?>