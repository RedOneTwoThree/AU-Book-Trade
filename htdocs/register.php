<?php $page_title = 'Register'; include_once 'views/header.php'; ?>
<section id="content">

	<?php 


	if (isset($_POST['register-submit'])){

		try{	

            include_once 'includes/dbh.php';

		}
		catch (Exception $e){
			exit('Unable to connect: ' . $e->getMessage());

		}

		$errors = array();

		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$password = $_POST['password'];
		$username = substr($_POST['email'], 0, -12);
		$confirm_password = $_POST['confirm-password'];
		$email = $_POST['email'];

		$sth = $db->prepare('SELECT email FROM users WHERE email = :email');
		$sth->execute(array(':email' => $email));


		if($sth->rowCount() !== 0){
			$errors[] = 'This email has already been registered. If you are having issues please contact the administrator';
		}

		if($firstname === '' || $password === '' || $lastname === '' || $email === '' || $confirm_password === '' ){
			$errors[] = 'All fields need to be filled in.';
		}

		if (substr($email,-12) !== '@aston.ac.uk' ){
			$errors[] = 'Please enter a valid Aston University email address.';
		}
		if (strlen($firstname) > 35 ){
			$errors[] = 'Your first name cannot be more than 35 characters long.';
		}
		if (strlen($lastname) > 35 ){
			$errors[] = 'Your last name cannot be more than 35 characters long.';
		}
		if (strlen($email) > 60 ){
			$errors[] = 'Your email cannot be more than 60 characters long.';
		}
		if (strlen($password) > 40 ){
			$errors[] = 'Your password cannot be more than 40 characters long.';
		}
		if ($password !== $confirm_password){
			$errors[] = 'Password does not match.';
		}

		if (count($errors) !== 0){
			echo '<p>Sorry, one or more errors occured with your registeration: </p>';
			echo '<ul>';
			foreach ($errors as $error) {
				echo '<li>'.$error.'</li>';
			}
			echo '</ul>';
		} else {
			$query = $db->prepare("INSERT INTO users VALUES ('', :firstname, :lastname, :email, :password, :username, 0)")->execute(array(':firstname' => $firstname,':lastname' => $lastname, ':email' => $email, ':password'=> md5($password), ':username'=> $username));
			echo '<p>Thank you for registering an accunt, <strong>' .$firstname.'</strong>!</p>';
		}
		echo '<hr/>';
	}

	?>
	<h2>Register</h2>

	<form action="register.php" method="post" id="registration_form">
		<fieldset>
			<label for="firstname">First name</label>
			<input type="text" name="firstname" maxlength="30"/>

			<br />

			<label for="lastname">Last name</label>
			<input type="text" name="lastname" maxlength="30"/>

			<br />

			<label for="email">Aston University Email address</label>
			<input type="text" name="email" />

			<br />

			<label for="password">Password</label>
			<input type="password" name="password" />

			<br />

			<label for="confirm-password">Confirm Password</label>
			<input type="password" name="confirm-password" />

			<br />

			<input type="submit" name="register-submit" value="Register" />

		</fieldset>

	</form>
</section>

<?php include_once 'views/footer.php'; ?>