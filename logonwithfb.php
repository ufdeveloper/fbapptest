#!/usr/local/bin/php

<html>
<head>
<title>FB Logon</title>
<?php 

   $app_id = '438225002913600';
   $app_secret = '96a297acec3026be91ac0ea05901458e';
   $my_url = 'http://cise.ufl.edu/~ssardal/fblogontest/logonwithfb.php';
   
 ?>
</head>
<body>

<?php 

   session_start();
   
   $code = $_REQUEST["code"];

	//print 'code is '.$code;

   if(empty($code)) {
   	$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
   	
   	
   	$dialog_url = "https://www.facebook.com/dialog/oauth?client_id="
   			. $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
   					. $_SESSION['state'] . "&scope=user_status";
   
   	
   	echo("<script> top.location.href='" . $dialog_url . "'</script>");
   	
   	}

	if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
     $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
       . "&client_secret=" . $app_secret . "&code=" . $code;

     //file_get_contents reads the file at the url and returns a string
     $response = file_get_contents($token_url);
     $params = null;
     parse_str($response, $params);

	$_SESSION['access_token'] = $params['access_token'];

     //$graph_url = "https://graph.facebook.com/me?fields=id,name,picture&access_token=" 
       //. $params['access_token'];
       
	$graph_url = "https://graph.facebook.com/me/checkins?access_token="
			. $params['access_token'];

     $checkins = json_decode(file_get_contents($graph_url));
     
     echo "<a href='home.php'>Home</a>";
     echo "<a href='member.php'>Member's Area</a>";
     echo "<a href='logout.php'>Logout</a>";
      
     echo "<br>";

     //set the session variable for loggeinuser
     $_SESSION["loggedinuser"] = "abcd";
     
     //checkin data
     $data = $checkins->data;
     if(count($data) > 0)
     {
     	echo "Last 5 checkins<br><br>";
     	for($i=0;$i<5;$i++)
     	{
     		//get FB page of checkin
     		$pageid = $data[$i]->place->id;
     		$fbpage_url = "https://graph.facebook.com/" .$pageid;
     		$fbpage_url_data = json_decode(file_get_contents($fbpage_url));
     		//echo "link : " .$fbpage_url_data->link;

     		echo "<a href='".$fbpage_url_data->link."'>".$data[$i]->place->name."</a>";
     		//echo $data[$i]->place->name;
     		 
     		echo "<br>";
     		 
     		//get checkin date
     		if($data[$i]->created_time)
     		{
     			$date = substr($data[$i]->created_time,0,10);
     			/*$month = substr($date,5,2);
     			$day = substr($date,8,2);
     			$year = substr($date,0,4);*/
     			echo " on " .$date;
     			
     		}
     		echo "<br>";
     		
     		if($data[$i]->place->location->street)
     		{
     		echo $data[$i]->place->location->street;
     		echo "<br>";
     		}
     		if($data[$i]->place->location->city)
     		{
     		echo $data[$i]->place->location->city;
     		echo "<br>";
     		}
     		echo "<br>";
     	}
     	echo "<br>";
     }
     else
     	echo "could not retrieve checkins";
     
     
      

     
     

   }
   else {
     echo("The state does not match. You may be a victim of CSRF.");
   }   	

 ?>

</body>
</html>