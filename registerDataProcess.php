<?php
include('db.php');
//This file receives data from index page via AJAX
//Define variables
$errorMSG = "";
$userFirstName = $_POST['firstname'];
$userLastName = $_POST['lastname'];
$userEmail = $_POST['email'];
$userPassword = $_POST['password']; 
$userAge = $_POST['age'];
$userAddress = $_POST['address'];
$userCCNum = $_POST['cardnum'];


//Function to clean inputs received from form
function cleanInputs($value){
    $value = trim($value);
    $value = stripcslashes($value);
    $value = htmlspecialchars($value);
    return $value;
}	

//Variables to store hashed values
$hash_password = "";
$hash_creditNum = "";

//First level of sanitation here
$cleanFirstName = cleanInputs($userFirstName);
$cleanLastName = cleanInputs($userLastName);
$cleanEmail = cleanInputs($userEmail);
$cleanPassword = cleanInputs($userPassword);
$cleanAge = cleanInputs($userAge);
$cleanAddress = cleanInputs($userAddress);
$cleanCCNum = cleanInputs($userCCNum);

//Hash values
$hash_creditNum = md5($cleanCCNum);
$hash_password = md5($cleanPassword);
/* FIRST NAME */
if (empty($cleanFirstName)) {
    $errorMSG = "<li>Firstname is required</<li>";
}
if(!preg_match("/^([A-Z]{1})([A-Za-z-])?/", $cleanFirstName)) {
    $errorMSG = "<li>Invalid first name</li>";
} else{
    $firstName = $cleanFirstName;
}

/* LAST NAME */
if(empty($cleanLastName)){
    $errorMSG .= "<li>Lastname is required</li>";
}
if(!preg_match("/^([A-Z]{1})([A-Za-z-])?/", $cleanLastName)){
    $errorMSG .= "<li>Invalid lastname</li>";
}else{
    $lastname = $cleanLastName;
}

/* EMAIL */
if (empty($cleanEmail)) {
    $errorMSG .= "<li>Email is required</li>";
} 

if(!filter_var($cleanEmail, FILTER_VALIDATE_EMAIL)) {
    $errorMSG .= "<li>Invalid email format</li>";
}else {
    $email = $cleanEmail;
}

/* PASSWORD */
if(empty($cleanPassword)){
    $errorMSG .= "<li>Password is required</li>";
} 
else if(strlen($cleanPassword) < 8){
    $errorMSG .= "<li>Password is too short,password must be 8 characters</li>";
} else if (strlen($cleanPassword) > 8) {
    $errorMSG .= "<li>Password is too long,password must be 8 characters at least</li>";
}else{
    $password = $cleanPassword;
}

/* AGE */
if(empty($cleanAge)){
    $errorMSG .= "<li>Age is required</li>";
} 

if(!filter_var($cleanAge,FILTER_VALIDATE_INT)){
    $errorMSG .= "<li>Age is invalid</li>";
}else{
    $age = $cleanAge;
}


/* ADDRESS */
if (empty($cleanAddress)) {
    $errorMSG .= "<li>Address is required</li>";
} 
if(!preg_match("/^[0-9a-zA-Z,. ]+/", $cleanAddress)){
    $errorMSG .= "<li>Address is invalid</li>";
}else{
    $address = $cleanAddress;
}


/* CREDIT CARD */
if (empty($cleanCCNum)) {
    $errorMSG .= "<li>Credit card is required</li>";
} 
if (!preg_match("/^(?:4[0-9]{12}(?:[0-9]{3})?)/",$cleanCCNum)){
    $errorMSG .= "<li>Credit card isn't valid</li>";
}else{
    $ccNum = $cleanCCNum;
}


if(empty($errorMSG)){
    $stmt = $DBcon->prepare("INSERT INTO customer (userName,firstName,lastName,age,mailAddress,credit_card_Num, password) VALUES 
    (:email,:firstName,:lastname,:age,:address,:hash_creditNum, :password)");

    $stmt->bindparam(':email', $email);
    $stmt->bindparam(':firstName', $firstName);
    $stmt->bindparam(':lastname', $lastname);
    $stmt->bindparam(':age', $age);
    $stmt->bindparam(':address', $address);
    $stmt->bindparam(':hash_creditNum', $hash_creditNum);
    $stmt->bindparam(':password', $hash_password);

    if($stmt->execute()){
        $res = "Data inserted successfully";
        echo json_encode(['code'=>200, 'msg'=>$res]);
    }
    else{
        $res = "Error";
        echo json_encode(['code'=>200, 'msg'=>$res]);
    }

    exit;
}

echo json_encode(['code'=>404, 'msg'=>$errorMSG]);


    
?>
