#!/usr/local/bin/php

<html>
<head>

<title>TestApp Home Page</title>
</head>
<body>


<?php 
session_start();

echo "<a href='home.php'>Home</a>";
echo "<a href='member.php'>Member's Area</a>";

if(isset($_SESSION["loggedinuser"]))
{
	echo "<a href='logout.php'>Logout</a>";
	echo "<br>TestApp Home Page";
	exit;
}

?>

<br>
<br>

<form action="authenticatemember.php" method="post">
Username : <input type="text" name="userid">
<br>
Password : <input type="password" name="password">
<br><br>
<input type="submit" value="login">
</form>

<form action="logonwithfb.php" method="post">
<input type="submit" value="Login with Facebook">
</form>

<form action="signup.php">
<input type="submit" value="Sign Up for Traffish">
</form>
</body>
</html>