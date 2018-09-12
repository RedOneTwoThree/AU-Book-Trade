<?php if (!isset($_SESSION)) session_start();


if (!$_SESSION['logged_in']) {
	header('Location: index.php');
}


if(isset($_GET['rate'],$_GET['rating'],$_GET['type'])){
	$rate = (int)$_GET['rate'];
	$rating = (int)$_GET['rating'];
	$type = (string)$_GET['type'];

	if (in_array($rating, [1,2,3,4,5])){
		include_once 'includes/dbh.php';
		global $con;

		if($type == 'b'){

			$product = mysqli_query($con, "SELECT * FROM product WHERE product_id = '$rate' AND sold =1");

			$productarray = mysqli_fetch_array($product);

			$user_id = $productarray['requester_id'];

			$set_rating = mysqli_query($con, "INSERT INTO user_rating (product_id,user_id,rating) VALUES ({$rate},{$user_id},{$rating})");

			header('Location: dashboard.php?area=sold');



		} else {

			$product = mysqli_query($con, "SELECT * FROM product WHERE product_id = '$rate' AND sold =1");

			$productarray = mysqli_fetch_array($product);

			$user_id = $productarray['seller_id'];

			$set_rating = mysqli_query($con, "INSERT INTO user_rating (product_id,user_id,rating) VALUES ({$rate},{$user_id},{$rating})");

			header('Location: dashboard.php?area=myhistory');





		}
	}
}

