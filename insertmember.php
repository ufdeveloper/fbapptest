#!/usr/local/bin/php

<html>
<head>


<title>Inserting a new member</title>
</head>
<body>

<?php

session_start();
//extract insert values from POST url
$userid = $_POST["userid"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$password = $_POST["password"];
 
//check if all fields entered by the user
if(!$userid || !$fname || !$lname || !$email || !$password)
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
$password = md5($password);
echo "<br>inserted password is " .$password;
$query = "insert into user values ('".$userid."','".$fname."','".$lname."','".$email."','".$password."')";

//execute the query
$result = mysqli_query($db, $query);

if($result)
{
	$_SESSION["loggedinuser"] = $userid;
	//echo mysqli_affected_rows($db) . " rows inserted";
	echo "Welcome to Traffish " .$fname;
}
else
	echo "could not create an entry";

mysqli_close($db);
?>

<form action="member.php">
<input type="submit" value="Go to Member's area">
</form>

</body>
</html>