<?php if (!isset($_SESSION)) session_start();

if($_SESSION['logged_in']){

	$id = $_SESSION['id'];

	if(isset($_GET['pro'])){

		$product_id = (int)$_GET['pro'];


		include_once 'includes/dbh.php';
		global $con;



		$cancel = mysqli_query($con, "UPDATE product SET pending = 0, requester_id = NULL WHERE product_id = '$product_id' AND requester_id = '$id'");

		header('Location: dashboard.php?area=myrequest');


	}
}



