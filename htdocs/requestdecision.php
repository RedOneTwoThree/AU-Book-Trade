<?php if (!isset($_SESSION)) session_start(); 

if (!$_SESSION['logged_in']) {
  header('Location: index.php');
}

$id = $_SESSION['id'];

if(isset($_GET['pro'],$_GET['type'])){

	$product_id = (int)$_GET['pro'];

	$decision = (string)$_GET['type'];

	include_once 'includes/dbh.php';
	global $con;

	if($decision == "a"){



		$set_decision = mysqli_query($con, "UPDATE product SET sold = 1, sold_date = NOW() WHERE product_id = '$product_id' AND seller_id = '$id'");

		header('Location: dashboard.php?area=purchaserequested');



	} 


	if ($decision == "d"){

		$set_decision = mysqli_query($con, "UPDATE product SET pending = 0, requester_id = NULL WHERE product_id = '$product_id'");

		header('Location: dashboard.php?area=purchaserequested');


	}
}



