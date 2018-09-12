<?php

//include_once 'includes/dbh.php';
	$db = new PDO('mysql:host=localhost;dbname=astonbooktrade', 'root', 'root');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_PERSISTENT, true);

	$con = mysqli_connect('localhost','root','root','astonbooktrade');



