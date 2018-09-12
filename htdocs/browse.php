<?php 
if (!isset($_SESSION)) session_start();
$page_title = 'Browse';
include_once 'views/header.php';


?>

<!–– Makes the whole row clickable ––>
<script>
	$(document).ready(function() {

		$('#results tr').click(function() {
			var href = $(this).find("a").attr("href");
			if(href) {
				window.location = href;
			}
		});

	});
</script>


<table id="results" align="center" width="60%">
	<tr>
		<th width="20%"></th>
		<th></th>
	</tr>



	<?php
	include_once 'includes/dbh.php';
	if ($_GET['category'] !== '0'){
		global $con;
		$get_product = "SELECT * FROM product WHERE pending = 0 AND product_cat =".$_GET['category'];
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

			echo  '<tr><td ><a href="item.php?id='.$product_id.'"><img src="img/sale/'.$product_img.'" class="image"/></a></td><td><div class = "title"><strong>'.$product_title.'</strong></div><br/><div class="price">£'.$product_price.'</td></tr><tr>';



		}
	} else {


		global $con;
		$get_product = "SELECT * FROM product WHERE pending = 0";
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

			echo  '<tr><td ><a href="item.php?id='.$product_id.'"><img src="img/sale/'.$product_img.'" class="image"/></a></td><td><div class = "title"><strong>'.$product_title.'</strong></div><br/><div class="price">£'.$product_price.'</td></tr><tr>';


		}
	}
	?>	

</table>

<?php include_once 'views/footer.php'; ?>