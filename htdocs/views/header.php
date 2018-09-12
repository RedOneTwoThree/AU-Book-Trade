<?php if (!isset($_SESSION)) session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?php echo isset($page_title) ? $page_title . ' :' : ''; ?></title>
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="css/navbar.css">

	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	<script>tinymce.init({ selector:'textarea' });</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>




	<script>
		function popup() {
			alert("You must first log in to your account.");
		}


	</script>
</head>
<body>

	<?php 
	if (isset($_POST['login-submit'])) { 

		try{
			include_once 'includes/dbh.php';

		}
		catch (Exception $e)
		{
			exit('Unable to connect: ' . $e->getMessage());
		}

		$errors = array();
		$email = trim($_POST['email']);
		$password = $_POST['password'];

		$sth = $db->prepare('SELECT email FROM users WHERE email = :email AND password = :password');
		$sth->execute(array(':email' => $email, ':password' => md5($password)));


		$sql = $db->prepare('SELECT firstname FROM users WHERE email = :email');
		$sql->execute(array(':email' => $email));
		$name = $sql->fetchColumn();

		$getid = $db->prepare('SELECT userid FROM users WHERE email = :email');
		$getid->execute(array(':email' =>$email));
		$id = $getid->fetchColumn();


		if ($sth->rowCount() === 0){
			$errors[] = 'Incorrect email and/or password.';
		}
		if ($email === '' || $password === ''){
			$errors[] = 'Fill in all fields.';

		}

		if(count($errors) !== 0 ){
			echo '<script>alert("Sorry, one or more errors occured with your login:\n';
			foreach ($errors as $error) {
				echo $error.'\n' ;
			}
			echo '")</script>';
		} else {
			$_SESSION['email'] = $email;
			$_SESSION['logged_in'] = true;
			$_SESSION['name'] = $name;
			$_SESSION['id'] = $id;

		

			header('location: index.php');
			//echo "<meta http-equiv='refresh' content='0'>";
		}
	}
	if (isset($_POST['logout'])) {
		session_unset();
		session_destroy();
		header('location: index.php');
	} 


	include_once 'includes/dbh.php';

	function getCats(){
		global $con; 
		$get_cats = 'SELECT * FROM category';
		$run_cats = mysqli_query($con, $get_cats);

		while ($row_cats=mysqli_fetch_array($run_cats)){
			$cat_id = $row_cats['cat_id'];
			$cat_title = $row_cats['cat_title'];
			$get_products = 'SELECT * FROM product WHERE pending = 0 AND product_cat = '.$cat_id;

			$run_products = mysqli_query($con, $get_products);

			if(mysqli_num_rows($run_products) != 0){


			echo '<a href="browse.php?category='.$cat_id.'">'.$cat_title. '</a>';

			}

		}
	}




	?>

<div id="container">
	<header>
		<table style= "width:100%;">
			<tr>
				<td>
					<img height= "140px" src="img/Aston_logov1.png" />
				</td>
				<td>
					<?php if (!isset($_SESSION['email'])) { ?>
					<div id="login-form">

						<form action="index.php" method="post">
							<fieldset>

								<label for="login-email">Email</label>
								<input type="text" id="login-username" name="email" />

								<br />

								<label for="login-password">Password</label>
								<input type="password" id="login-password" name="password" />

								<br />

								<input type="submit" name="login-submit" value="Log in" />
							</fieldset>
						</form>
					</div>
					<?php } else { ?>
					<div id = "login-form">
						<form action="index.php" method="post"><label><font color="black">You are logged in as <?php echo $_SESSION['name']; ?>  </font></label><input type="submit" name="logout" value="Log out" /></form><?php } ?>
					</div>
				</td>
			</tr>
		</table> 
	</header>





	<div class="navbar">
		<a href="index.php">Home</a>


		<div class="dropdown">
    <button class="dropbtn">Browse Books
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
<a href="browse.php?category=0">Explore All Catagories</a>
				<?php getCats(); ?>
    </div>
  </div> 





		<a 	<?php 

		if(!isset($_SESSION['email'])){
			echo 'href = "" onclick="popup()"';
		} else {
			echo 'href ="sell.php"';
		}

		?>

		>Sell Books</a>



		<div class="dropdown">
    <button class="dropbtn">My Account
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
    	<a <?php 

    	if(!isset($_SESSION['email'])){
    		echo 'href = "" onclick="popup()"';
    	} else {
    		echo 'href ="dashboard.php?area=myhistory"';
    	}

    	?>>My Purchase History</a>
    	<a <?php 

    	if(!isset($_SESSION['email'])){
    		echo 'href = "" onclick="popup()"';
    	} else {
    		echo 'href ="dashboard.php?area=myrequest"';
    	}

    	?>>My Purchase Requests</a>
    	<a <?php 

    	if(!isset($_SESSION['email'])){
    		echo 'href = "" onclick="popup()"';
    	} else {
    		echo 'href ="dashboard.php?area=mylisting"';
    	}

    	?>>My Current Listings</a>
    	<a <?php 

    	if(!isset($_SESSION['email'])){
    		echo 'href = "" onclick="popup()"';
    	} else {
    		echo 'href ="dashboard.php?area=purchaserequested"';
    	}

    	?>>Purchase Requested</a>


    	<a <?php 

    	if(!isset($_SESSION['email'])){
    		echo 'href = "" onclick="popup()"';
    	} else {
    		echo 'href ="dashboard.php?area=sold"';
    	}

    	?>>Books Sold</a>


    </div>
  </div> 





		<a href="help.php">Help</a>
		<?php if (!isset($_SESSION['email'])) { ?>
		<a href="register.php">Register</a>
		<?php } ?>
		<div id= "search">

			<form method= "get" action="results.php" enctype="form-data" >
				<input type="text" name="user_query" placeholder="Search for Books" />
				<input type= "submit" name="search" value="Search" />
			</form>
		</div>


	</div>

	
