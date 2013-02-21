#!/usr/local/bin/php

<?php 

   $app_id = "YOUR_APP_ID";
   $app_secret = "YOUR_APP_SECRET";
   $my_url = "YOUR_LOGOUT_URL";

   session_start();
   $token = $_SESSION["access_token"];

?>



<html>
<head>
<title>Logout</title>
</head>
<body>

<a href="home.php">Home</a>
<a href="member.php">Member's Area</a>
<br>

<?php

//remove loggedin user flag
unset($_SESSION["loggedinuser"]);

//delete access token
if($token) {
	$graph_url = "https://graph.facebook.com/me/permissions?method=delete&access_token="
			. $token;

	$result = json_decode(file_get_contents($graph_url));
	if($result) {
		session_destroy();
		echo("<br>User is now logged out.");
	}
} else {
	echo("<br>User already logged out.");
}
?>

<br>
<br>Thank you for using our Test App

</body>
</html>