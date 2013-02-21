#!/usr/local/bin/php

<html>
<head>
<title>Member's Area</title>
</head>
<body>

<?php 

session_start();

echo "<a href='home.php'>Home</a>";
echo "<a href='member.php'>Member's Area</a>";

if(!isset($_SESSION["loggedinuser"]))
{
	echo "<br>This is only accessible to members";
	exit;
}

echo "<a href='logout.php'>Logout</a>";

?>

<br>
<br>This is the Traffish Member's area<br>


</body>
</html>