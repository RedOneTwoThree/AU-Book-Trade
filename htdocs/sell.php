<?php 
if (!isset($_SESSION)) session_start();
$page_title = 'Sell';
include_once 'views/header.php';


if($_SESSION['logged_in']){

if (isset($_POST['sell-submit'])){

	try{	
		include_once 'includes/dbh.php';

	}
	catch (Exception $e){
		exit('Unable to connect: ' . $e->getMessage());

	}

	$errors = array(); 


	$title = $_POST['title'];
	$isbn = preg_replace('/\D/', '', $_POST['isbn']);
	$category = $_POST['category'];
	$description = $_POST['description'];
	$paymenttype = isset($_POST['paymenttype']) ? $_POST['paymenttype'] : 'Cash';


	$temp = $_POST['price-pound'];
	$temp2 = $_POST['price-pence'];



	$checkInt = preg_match('/^\d+$/', $temp);



	$checkInt2 = preg_match('/^\d+$/', $temp2);



	$pound = $_POST['price-pound'];
	$pence = $_POST['price-pence']/100;
	$price = $pound + $pence ; 
	$userid = $_SESSION['id'];



	$product_image = $_FILES['image']['name'];
	$product_image_tmp = $_FILES['image']['tmp_name'];
	$check = getimagesize($_FILES["image"]["tmp_name"]);


	if($title === '' || $isbn === '' || $category === '' || $description === '' || $payment_type === ''){
		$errors[] = 'All fields need to be filled in.';
	}

	if($price > 100){
		$errors[] = 'Book pirice must be under £100.';
	}

	if (strlen($title) > 60){
		$errors[] = 'The title cannot be more than 60 characters long.' ;
	}

	if (strlen($isbn) > 13){
		$errors[] = 'The ISBN number field cannot be more than 13 characters long.' ;
	}

	if($category == ''){
		$errors[] = 'Please select a category.';

	}		

	if (strlen($description) == 0 ){
		$errors[] = 'You must enter a description of the book' ;
	}

	if($check == false){
		$errors[] = 'File uploaded is not a valid image file.' ; 
	}

	if($paymenttype == ''){
		$errors[] = 'Please select a payment type.';

	}

	if($pound < 0 || $pence < 0 ){
		$errors[] = 'Can not sell items for negative price';
	}

	if($checkInt != 1 || $checkInt2 != 1){
		$errors[] = 'Values in the price field is not valid';
	}




	if (count($errors) !== 0){
		echo '<p>Sorry, one or more errors occured with your form:</p>';
		echo '<ul>';
		foreach ($errors as $error) {
			echo '<li>'.$error.'</li>';
		}
		echo '</ul>';
		echo '<hr/>';
	} else {

		$query = $db->prepare("INSERT INTO product (isbn, product_title, product_desc, product_img, product_cat, product_price, payment_type, seller_id) VALUES ('$isbn','$title','$description','$product_image','$category','$price','$paymenttype','$userid')")->execute();
		move_uploaded_file($product_image_tmp,"img/sale/$product_image" );
		echo '<script>alert("Thank you for posting!")</script>';
		echo '<script> window.open("sell.php", "_self") </script>';
	}
	


}

function getCatsForSell(){

	global $con; 
	$get_cats = 'SELECT * FROM category';
	$run_cats = mysqli_query($con, $get_cats);

	while ($row_cats=mysqli_fetch_array($run_cats)){
		$cat_id = $row_cats['cat_id'];
		$cat_title = $row_cats['cat_title'];
		echo '<option value="'.$cat_id.'">'.$cat_title.'</option>'; 
	}
}


?>	

<h2 align="center">Sell</h2>


<form action="sell.php" method="post" id="sell_form" enctype="multipart/form-data">
	<fieldset>

		<div id="long-field">

			<label for="title">Book Title:</label>
			<input type="text" name="title"  maxlength="100"  />

			<br />

			<label for="isbn">ISBN:</label>
			<input type="text" name="isbn" maxlength="14" size="14" />
			<br />

			<label for="category">Category:</label><br/>
			<select name="category" >
				<option value="" selected="">-Select Category-</option>
				<?php getCatsForSell(); ?> 

			</select>

			<br/>

			<label for="description">Description:</label>
			<br/>

			<textarea name="description"></textarea>

			<br />



			<label for="image">Upload image of the book:</label><br/>

			<input type="file" name="image" id="fileToUpload"  />

			<br/>

		</div>


		<div id="short-field">


			<label for="paymenttype">Payment Method:</label><br/>
			<select name="paymenttype" >
				<option value="Cash">Cash</option>
				<option disabled="">PayPal</option>
				<option disabled="">Both</option>

			</select>


			<br />


			<label for="price">Price <i>(Max £100)</i>: £</label>

			<input type="text" name="price-pound" maxlength="3" size="3"/>.<input type="text" name="price-pence" maxlength="2" size="2"/>
		</div>

		<br/>


		<input type="submit" name="sell-submit" value="Post" />


	</fieldset>

</form>

<?php }else{echo '<script>window.location.replace("index.php");</script>'; } ?>

<br/>
<br/>



<?php include_once 'views/footer.php'; ?>