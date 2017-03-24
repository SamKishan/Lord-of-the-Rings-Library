<?php
	include_once("/var/www/html/hw8/header.php");
	echo "
		<br><br><br><br><br><br>
		<body background=\"bg.jpg\">
		<form method=\"post\" action =/hw8/add.php>
		<center>
		Enter username:
		
		<input type=\"text\" name=\"post_uname\">
		<br>
		Enter password:
		
		<input type=\"password\" name=\"post_upass\">
		<br>
		Enter Email:
		<input type=\"text\" name=\"post_uemail\">
		<input type=\"hidden\" name=\"s\" value=4>
		<br>
		<input type=\"Submit\" name=\"Submit\" value=\"Submit\">
		</center>
		";
//	echo "<br><br><br> Note: If already authenticated hit Submit and proceed";
?>	
