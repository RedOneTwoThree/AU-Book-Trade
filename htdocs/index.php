<?php 
$page_title = 'AU Book Market';
include_once 'views/header.php';


include_once 'includes/dbh.php';

function getPro(){
	global $con;

	$get_product = "SELECT * FROM product WHERE pending = 0 ORDER BY RAND() LIMIT 0,5";
	$run_product = mysqli_query($con, $get_product); 

	while($row_product=mysqli_fetch_array($run_product)){
		$product_id = $row_product['product_id'];
		$product_title = $row_product['product_title'];
		$product_img = $row_product['product_img'];
		$product_upload_date = $row_product['upload_date'];
		$product_price = $row_product['product_price'];
		$product_payment_type = $row_product['payment_type'];


        if(!isset($_SESSION['email'])){
					echo '<div class="slide"><div class="container"><a href="" onclick="popup()">
        		<img src="img/sale/'.$product_img.'" class="image"/>
        		<div class="overlay">£'.$product_price.'</div></a></div>
        	</div>';
				} else {
					echo '<div class="slide"><div class="container"><a href="item.php?id='.$product_id.'">
        		<img src="img/sale/'.$product_img.'" class="image"/>
        		<div class="overlay">£'.$product_price.'</div></a></div>
        	</div>';
				}


        


	}
}


?>	



	<div id="landing">

        <h1>Welcome to Aston University Book Trade</h1>

        <p>Aston Book Trade, a secure website that allows students to buy and sell their books.</p>

        <h2 align="center">Check out these books on sale!</h2>

        <div id="carousel" align="center">

        	<?php getPro(); ?>

        </div>

        

    </div>

    <br/>
    <br/>
     <br/>
    <br/>



<?php include_once 'views/footer.php'; ?>