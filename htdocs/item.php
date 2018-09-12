<?php if (!isset($_SESSION)) session_start();
$page_title = 'Item: ';
include_once 'views/header.php';

include_once 'includes/dbh.php';



if (isset($_GET['id'])){
	$product_id = $_GET['id'];

	$get_product = "SELECT * FROM product WHERE product_id = '$product_id'";
	$run_product = mysqli_query($con, $get_product);

	while($row_product = mysqli_fetch_array($run_product)){
		$product_id = $row_product['product_id'];
		$product_title = $row_product['product_title'];
		$product_img = $row_product['product_img'];
		$product_upload_date = $row_product['upload_date'];
		$product_price = $row_product['product_price'];
		$product_payment_type = $row_product['payment_type'];
		$product_desc = $row_product['product_desc'];
		$seller_id = $row_product['seller_id'];
		$request_sent = $row_product['pending'];



		$get_Rating = "SELECT * FROM user_rating WHERE user_id = $seller_id";
		$run_Rating = mysqli_query($con, $get_Rating);

		$sum = 0;
		$count = 0; 

		while($row_rating = mysqli_fetch_array($run_Rating)){

			$rating = $row_rating['rating'];

			$sum += $rating;
			$count += 1;
		}

		if($count != 0){

			$averageRating = round( $sum/$count, 1, PHP_ROUND_HALF_UP); 

		} else { $averageRating = 'No Ratings';}

		


		$get_user = "SELECT * FROM users WHERE userid = '$seller_id' ";
		$run_user = mysqli_query($con, $get_user);
		while($row_user = mysqli_fetch_array($run_user)){
			$username = $row_user['username'];
			$user_email = $row_user['email'];

			
		}

	}
}



if (isset($_POST['request_submit'])){

	try{	

		include_once 'includes/dbh.php';
	}
	catch (Exception $e){
		exit('Unable to connect: ' . $e->getMessage());

	}

	if($_SESSION['id'] != $seller_id){

		$query = $db->prepare("UPDATE product SET pending = 1, requester_id = :session_id WHERE product_id = :product_id")->execute(array(':product_id' => $product_id, ':session_id' => $_SESSION['id']));

		echo '<script>alert("The purchase request has been sent to the seller. Please wait for the seller to get in contact with you to discuss payment and collection.");</script>';

		echo "<meta http-equiv='refresh' content='0'>";
	} else {
		echo '<script>alert("The purchase request has not been sent as it seems like you are the seller.");</script>';
	}

}

?>

<div id="product">
	<div id="title">
		<h1 class="page-title" ><?php echo $product_title; ?></h1> 
	</div>
	<div id="single-line">



		<div id="detail">
			<h2>£<?php echo $product_price; ?></h2>
			<form action=<?php echo '"item.php?id='.$product_id.'"';?> method="post">
				<?php if($_SESSION['id'] != ''){  ?>

				<input type="submit" name="request_submit" <?php if($request_sent == 1){ echo 'value="Purchase Request Sent" disabled';} else { echo 'value="Send Purchase Request"';}?> >
				<?php }else { ?>
				<p>Please login to send a purchase request</p>
				<?php } ?>

			</form>
			<h4>Posted:</h4><?php echo $product_upload_date; ?>
			<h3>Description</h3>
			<p><?php echo $product_desc; ?></p>	
			<div id="contact" >
				<p><strong>Seller: </strong><?php echo $username; ?><br/>Rating = <?php echo $averageRating; ?> (<?php echo $count; ?>)</p>

				<a <?php echo 'href="mailto:'.$user_email.'?Subject=AU%20Book%20Trade%20-%20Product%20ID:%20'.$product_id.'%20-%20Book:%20'.$product_title.'%20-%20Query"'; ?> >Contact Seller</a>


			</div>

		</div>
		<div id="item-image">
			<?php echo '<img src="img/sale/'.$product_img.'" class="image"/>';  ?>
		</div>

	</div>


</div>

<br/>
<br/>

<?php include_once 'views/footer.php'; ?>
