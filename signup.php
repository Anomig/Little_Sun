<?php
	if(!empty($_POST)){
		$conn = new mysqli("localhost", "root", "root", "little_sun");
		
		//get data from POST
		$email = $_POST['email'];
		$salt = "ugvleoisnsgmoiezthiubgvnemoibnligrjdibn";
		// $password = md5($_POST['password'].$salt);
		$password = $_POST['password'];


		//hash password with bcrypt
		$options = [
			'cost' => 12
		];

		$password = password_hash($password, PASSWORD_DEFAULT, $options);

		//send the data to the users table in the database
		$query = "insert into users (email, password) VALUES ('$email', '$password')"; //altijd eerst in sql testen, zodat query zeker werkt, daarna aanpassen, values met quotes want anders geen quotes bij sql
		$result = $conn->query($query);
		echo $result;

		session_start(); //cookie PHP_SESSIONID= 987654321
		$_SESSION['loggedin'] = true;
		header("location: index.php");
	}
	//connectie checken
/* 	if($conn->connect_errno){ //-> = bij objecten, errno = connection error nummer
		echo "nope";
	}
	else{
		echo "yep";
	} */

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>IMDFlix</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="netflixLogin">
		<div class="form form--login">
			<form action="" method="post">
				<h2 form__title>Sign Up</h2>

				<?php if(isset($error)): ?>
				<div class="form__error">
					<p>
						Sorry, we can't log you in with that email address and password. Can you try again?
					</p>
				</div>
				<?php endif ?>

				<div class="form__field">
					<label for="Email">Email</label>
					<input type="text" name="email">
				</div>
				<div class="form__field">
					<label for="Password">Password</label>
					<input type="password" name="password">
				</div>

				<div class="form__field">
					<input type="submit" value="Sign Up" class="btn btn--primary">	
				</div>
			</form>
		</div>
	</div>
</body>
</html>