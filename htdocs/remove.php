<?php if (!isset($_SESSION)) session_start();

if($_SESSION['logged_in']){

	$id = $_SESSION['id'];

	if(isset($_GET['pro'])){

		$product_id = (int)$_GET['pro'];


		include_once 'includes/dbh.php';
		
		global $con;



		$remove = mysqli_query($con, "DELETE FROM product WHERE product_id = '$product_id' AND seller_id = '$id'");

		header('Location: dashboard.php?area=mylisting');


	}
} else { header('Location: index.php'); }



