#!/usr/local/bin/php

<html>
<head>
<title>Member Authentication</title>
</head>
<body>

<a href="home.php">Home</a>
<a href="member.php">Member's Area</a>
<br>
<br>

<?php
session_start();

//extract insert values from POST url
@ $userid = $_POST["userid"];
@ $password = $_POST["password"];

//check if all fields entered by the user
if(!$userid || !$password)
{
	echo "please enter all the fields";
	exit;
}

//connect to the DB
$db = mysqli_connect("localhost:3306","root","");

//check for connection errors
if(mysqli_connect_errno())
{
	echo "Could not connect to database";
	exit;
}

//database connection established, carry out further operations

//specify which database to use
mysqli_select_db($db,"traffish_test");

//construct the query
$query = "select * from user where userid='".$userid."'";

//execute the query
$result = mysqli_query($db, $query);

$num_rows = mysqli_affected_rows($db);
//echo "number of rows read : " .$num_rows;

if($num_rows)
{
	//fetch row
	$row = mysqli_fetch_assoc($result);
	
	//check if password matches
	if(md5($password) == $row["password"])
	{
		echo "Welcome " .$row["fname"]. " " .$row["lname"];
		$_SESSION["loggedinuser"] = $userid;
	}
	else
		echo "Password does not match. Try again";
	
}
else
	echo "user not registered";

mysqli_close($db);

?>

</body>
</html>