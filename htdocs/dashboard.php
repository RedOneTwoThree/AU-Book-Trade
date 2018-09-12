<?php 
if (!isset($_SESSION)) session_start();
$page_title = 'Account';
include_once 'views/header.php';

$useremail = $_SESSION['email'];
$_SESSION['logged_in'];
$_SESSION['name'];
$_SESSION['id'];

if($_SESSION['logged_in']){

	?>

	<?php if($_GET['area'] == "purchaserequested"){ ?>

	<h2>Purchase Requested</h2>
	<table id="dashboard">
		<tr>
			<th>Book Cover</th>
			<th>Title</th>
			<th>Requester</th>
			<th>Accept</th>
			<th>Decline</th>
		</tr>

		<?php
		include_once 'includes/dbh.php';
		global $con;

		$userid = $_SESSION['id'];

		$get_product = "SELECT * FROM product WHERE seller_id = '$userid' AND pending = 1 AND sold = 0";
		$run_product = mysqli_query($con, $get_product);
		$queryResult = mysqli_num_rows($run_product);

		if ($queryResult > 0){

			while($row_product = mysqli_fetch_array($run_product)){
				$product_id = $row_product['product_id'];
				$product_title = $row_product['product_title'];
				$product_img = $row_product['product_img'];
				$product_upload_date = $row_product['upload_date'];
				$product_price = $row_product['product_price'];
				$product_payment_type = $row_product['payment_type'];
				$product_desc = $row_product['product_desc'];
				$seller_id = $row_product['seller_id'];
				$requester_id = $row_product['requester_id'];

				$get_requester = "SELECT * FROM users WHERE userid = '$requester_id'";
				$run_requester = mysqli_query($con, $get_requester);

				$row_requester = mysqli_fetch_array($run_requester);

				
				$firstname = $row_requester['firstname'];
				$lastname = $row_requester['lastname'];
				$email = $row_requester['email'];
				$username = $row_requester['username'];

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

				echo 
				'<tr>
				<td><img src="img/sale/'.$product_img.'" class="image"/></td>
				<td><strong>'.$product_title.'</strong><br/>£'.$product_price.'</td>
				<td>
				Username: '.$username.'<br/>
				Email: '.$email.'<br/>
				Rating: '.$averageRating.' ('.$count.')<br/>
				</td>
				<td><a href="requestdecision.php?pro='.$product_id.'&type=a">Accept</a></td>
				<td><a href="requestdecision.php?pro='.$product_id.'&type=d">Decline</a></td>
				</tr>';
			}
		}else { echo '<tr><td colspan="5" align="center">There are no purchase requests at the moment!</td></tr>';}

		?>

	</table>

	<?php } ?>


	<?php if($_GET['area'] == "mylisting"){ ?>
	<h2>My Current Listings</h2>

	<table id="dashboard">
		<tr>
			<th>Book Cover</th>
			<th>Title</th>
			<th>Price</th>
			<th>Upload Date</th>
			<th>Remove</th>
		</tr>
		<?php
		include_once 'includes/dbh.php';
		global $con;

		$userid = $_SESSION['id'];

		$get_product = "SELECT * FROM product WHERE seller_id = '$userid' AND sold = 0 AND pending = 0";
		$run_product = mysqli_query($con, $get_product);
		$queryResult = mysqli_num_rows($run_product);

		if ($queryResult > 0){

			while($row_product = mysqli_fetch_array($run_product)){
				$product_id = $row_product['product_id'];
				$product_title = $row_product['product_title'];
				$product_img = $row_product['product_img'];
				$product_upload_date = $row_product['upload_date'];
				$product_price = $row_product['product_price'];
				$product_payment_type = $row_product['payment_type'];
				$product_desc = $row_product['product_desc'];
				$seller_id = $row_product['seller_id'];


				echo 
				'<tr>
				<td><img src="img/sale/'.$product_img.'" class="image"/></td>
				<td><strong>'.$product_title.'</strong></td>
				<td>£'.$product_price.'</td>
				<td>'.$product_upload_date.'</td>
				<td><a href="remove.php?pro='.$product_id.'">Remove</a></td>
				</tr>';
			}
		}else { echo '<tr><td colspan="5" align="center">There are no books listed for sale!</td></tr>';}

		?>
	</table>

	<?php } ?>


	<?php if($_GET['area'] == "sold"){ ?>

	<h2>Books Sold</h2>

	<table id="dashboard">
		<tr>
			<th>Book Cover</th>
			<th>Title</th>
			<th>Price</th>
			<th>Upload Date</th>
			<th>Buyer</th>
			<th>Rate Buyer</th>
		</tr>
		<?php
		include_once 'includes/dbh.php';
		global $con;

		$userid = $_SESSION['id'];

		$get_product = "SELECT * FROM product WHERE seller_id = '$userid' AND sold = 1 ";
		$run_product = mysqli_query($con, $get_product);
		$queryResult = mysqli_num_rows($run_product);

		if ($queryResult > 0){

			while($row_product = mysqli_fetch_array($run_product)){
				$product_id = $row_product['product_id'];
				$product_title = $row_product['product_title'];
				$product_img = $row_product['product_img'];
				$product_upload_date = $row_product['upload_date'];
				$product_price = $row_product['product_price'];
				$product_payment_type = $row_product['payment_type'];
				$product_desc = $row_product['product_desc'];
				$seller_id = $row_product['seller_id'];
				$requester_id = $row_product['requester_id'];

				$get_requester = "SELECT * FROM users WHERE userid = '$requester_id'";
				$run_requester = mysqli_query($con, $get_requester);

				$row_requester = mysqli_fetch_array($run_requester);

				
				$firstname = $row_requester['firstname'];
				$lastname = $row_requester['lastname'];
				$email = $row_requester['email'];
				$username = $row_requester['username'];

				$get_Rating = "SELECT * FROM user_rating WHERE user_id = $requester_id";
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


				$run_rating_check = mysqli_query($con, "SELECT * FROM user_rating WHERE product_id = '$product_id' AND user_id = '$requester_id'");
				$check = mysqli_num_rows($run_rating_check);




				if($check > 0){

					echo '<tr>
					<td><img src="img/sale/'.$product_img.'" class="image"/></td>
					<td><strong>'.$product_title.'</strong></td>
					<td>£'.$product_price.'</td>
					<td>'.$product_upload_date.'</td>
					<td>
					Username: '.$username.'<br/>
					Email: '.$email.'<br/>
					Rating: '.$averageRating.' ('.$count.')
					</td>
					<td>Submitted</td>
					</tr>';



				}else {
					echo 
					'<tr>
					<td><img src="img/sale/'.$product_img.'" class="image"/></td>
					<td><strong>'.$product_title.'</strong></td>
					<td>£'.$product_price.'</td>
					<td>'.$product_upload_date.'</td>
					<td>
					Username: '.$username.'<br/>
					Email: '.$email.'<br/>
					Rating: '.$averageRating.' ('.$count.')
					</td>
					<td><a href="rate.php?product='.$product_id.'&rating=1&type=b">1</a><a  href="rate.php?rate='.$product_id.'&rating=2&type=b">2</a><a href="rate.php?rate='.$product_id.'&rating=3&type=b">3</a><a  href="rate.php?rate='.$product_id.'&rating=4&type=b">4</a><a  href="rate.php?rate='.$product_id.'&rating=5&type=b">5</a></td>
					</tr>';

				}
			}
		}else { echo '<tr><td colspan="5" align = "center">There are no books that have been sold!</td></tr>';}

		?>
	</table>

	<?php } ?>


	<?php if($_GET['area'] == "myhistory"){ ?>

	<h2>My Purchase History</h2>

	<table id="dashboard">
		<tr>
			<th>Product ID</th>
			<th>Title</th>
			<th>Price</th>
			<th>Purchase Date</th>
			<th>Seller</th>
			<th>Rate Seller</th>
		</tr>
		<?php
		include_once 'includes/dbh.php';
		global $con;

		$userid = $_SESSION['id'];

		

		$get_product = "SELECT * FROM product WHERE requester_id = '$userid' AND sold = 1 ";
		$run_product = mysqli_query($con, $get_product);
		$queryResult = mysqli_num_rows($run_product);

		if ($queryResult > 0){

			while($row_product = mysqli_fetch_array($run_product)){
				$product_id = $row_product['product_id'];
				$product_title = $row_product['product_title'];
				$product_img = $row_product['product_img'];
				$product_price = $row_product['product_price'];
				$product_payment_type = $row_product['payment_type'];
				$seller_id = $row_product['seller_id'];
				$sold_date = $row_product['sold_date'];
				

				$userid = $_SESSION['id'];

				$get_seller = "SELECT * FROM users WHERE userid = '$seller_id'";
				$run_seller = mysqli_query($con, $get_seller);

				$row_seller= mysqli_fetch_array($run_seller);

				
				$firstname = $row_seller['firstname'];
				$lastname = $row_seller['lastname'];
				$email = $row_seller['email'];
				$username = $row_seller['username'];

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

				$run_rating_check = mysqli_query($con, "SELECT * FROM user_rating WHERE product_id = '$product_id' AND user_id = '$seller_id'");
				$check = mysqli_num_rows($run_rating_check);




				if($check > 0){

					echo 			'<tr>
					<td>'.$product_id.'</td>
					<td>'.$product_title.'</td>
					<td>£'.$product_price.'</td>
					<td>'.$sold_date.'</td>
					<td>
					Username: '.$username.'<br/>
					Email: '.$email.'<br/>
					Rating: '.$averageRating.' ('.$count.')
					</td>
					<td>Submitted</td>
					</tr>';
				} else {

					echo 
					'<tr>
					<td>'.$product_id.'</td>
					<td>'.$product_title.'</td>
					<td>£'.$product_price.'</td>
					<td>'.$sold_date.'</td>
					<td>
					Username: '.$username.'<br/>
					Email: '.$email.'<br/>
					Rating: '.$averageRating.' ('.$count.')
					</td>
					<td><a href="rate.php?product='.$product_id.'&rating=1&type=s">1</a> <a  href="rate.php?rate='.$product_id.'&rating=2&type=s">2</a> <a href="rate.php?rate='.$product_id.'&rating=3&type=s">3</a> <a  href="rate.php?rate='.$product_id.'&rating=4&type=s">4</a> <a  href="rate.php?rate='.$product_id.'&rating=5&type=s">5</a></td>
					</tr>';
				}

			}
		}else { echo '<tr><td colspan="5" align= "center">There is no purchase history!</td></tr>';}

		?>
	</table>

	<?php } ?>


	<?php if($_GET['area'] == "myrequest"){ ?>

	<h2>My Purchase Requests</h2>

	<table id="dashboard">
		<tr>
			<th>Book Cover</th>
			<th>Title</th>
			<th>Price</th>
			<th>Seller</th>
			<th>Cancel</th>
		</tr>
		<?php
		include_once 'includes/dbh.php';
		global $con;

		$userid = $_SESSION['id'];

		$get_product = "SELECT * FROM product WHERE requester_id = '$userid' AND sold = 0 AND pending = 1";
		$run_product = mysqli_query($con, $get_product);
		$queryResult = mysqli_num_rows($run_product);

		if ($queryResult > 0){

			while($row_product = mysqli_fetch_array($run_product)){
				$product_id = $row_product['product_id'];
				$product_title = $row_product['product_title'];
				$product_img = $row_product['product_img'];
				$product_upload_date = $row_product['upload_date'];
				$product_price = $row_product['product_price'];
				$product_payment_type = $row_product['payment_type'];
				$product_desc = $row_product['product_desc'];
				$seller_id = $row_product['seller_id'];
				$requester_id = $row_product['requester_id'];

				$get_seller = "SELECT * FROM users WHERE userid = '$seller_id'";
				$run_seller = mysqli_query($con, $get_seller);

				$row_seller = mysqli_fetch_array($run_seller);

				
				$firstname = $row_seller['firstname'];
				$lastname = $row_seller['lastname'];
				$email = $row_seller['email'];
				$username = $row_seller['username'];





				echo 
				'<tr>
				<td><img src="img/sale/'.$product_img.'" class="image"/></td>
				<td><strong>'.$product_title.'</strong></td>
				<td>£'.$product_price.'</td>
				<td>Username: '.$username.'<br/>Email: '.$email.' </td>
				<td><a href="cancelrequest.php?pro='.$product_id.'">Cancel</a></td>
				</tr>';
			}
		}else { echo '<tr><td colspan="5" align="center">No purchase requests have been made!</td></tr>';}

		?>
	</table>
	<?php } } else { echo '<script>window.location.replace("index.php");</script>'; }?>

	<br/>


	<?php include_once 'views/footer.php'; ?>