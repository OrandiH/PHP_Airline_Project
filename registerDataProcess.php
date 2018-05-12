<?php

//Define variables
$errorMSG = "";
$userFirstName = $_POST['firstname'];
$userLastName = $_POST['lastname'];
$userEmail = $_POST['email'];
$userPassword = $_POST['password'];
$userAge = $_POST['age'];
$userAddress = $_POST['address'];
$userCCNum = $_POST['cardnum'];


/* FIRST NAME */
if (empty($userFirstName)) {
    $errorMSG = "<li>Firstname is required</<li>";
}
if(!preg_match("/^([A-Z]{1})([A-Za-z-])?/", $userFirstName)) {
    $errorMSG = "<li>Invalid first name</li>";
} else{
    $firstName = $userFirstName;
}

/* LAST NAME */
if(empty($userLastName)){
    $errorMSG .= "<li>Lastname is required</li>";
}
if(!preg_match("/^([A-Z]{1})([A-Za-z-])?/", $userLastName)){
    $errorMSG .= "<li>Invalid lastname</li>";
}else{
    $lastname = $userLastName;
}


/* EMAIL */
if (empty($userEmail)) {
    $errorMSG .= "<li>Email is required</li>";
} 

if(!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    $errorMSG .= "<li>Invalid email format</li>";
}else {
    $email = $userEmail;
}

/* PASSWORD */
if(empty($userPassword)){
    $errorMSG .= "<li>Password is required</li>";
} 
else if(strlen($userPassword) < 8){
    $errorMSG .= "<li>Password is too short,password must be 8 characters</li>";
} else if (strlen($userPassword) > 8) {
    $errorMSG .= "<li>Password is too long,password must be 8 characters at least</li>";
}else{
    $password = $userPassword;
}

/* AGE */
if(empty($userAge)){
    $errorMSG .= "<li>Age is required</li>";
} 

if(!filter_var($userAge,FILTER_VALIDATE_INT)){
    $errorMSG .= "<li>Age is invalid</li>";
}else{
    $age = $userAge;
}


/* ADDRESS */
if (empty($userAddress)) {
    $errorMSG .= "<li>Address is required</li>";
} 
if(!preg_match("/^[0-9a-zA-Z,. ]+/", $userAddress)){
    $errorMSG .= "<li>Address is invalid</li>";
}else{
    $address = $userAddress;
}


/* CREDIT CARD */
if (empty($userCCNum)) {
    $errorMSG .= "<li>Credit card is required</li>";
} 
if (!preg_match("/^(?:4[0-9]{12}(?:[0-9]{3})?)/",$userCCNum)){
    $errorMSG .= "Credit card isn't valid";
}else{
    $ccNum = $userCCNum;
}


if(empty($errorMSG)){
    $msg = "First Name: ".$firstName. ", Last Name: ".$lastname." Email: ".$email.", Password: ".$password.", Age:".
        $age." Address: ".$address." Credit card: ".$ccNum;
	echo json_encode(['code'=>200, 'msg'=>$msg]);
	exit;
}
    echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
    
?>
