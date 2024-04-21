<?php
	//echo time(); aantal seconden sinds 1 jan 1970

	//echo md5("joris"); naam hashen

	function canLogin($pEmail, $pPassword){ // functie weet niks van wat jij buiten de functie aan het doen hebt
		$conn = new mysqli("localhost", "root", "root", "little_sun");
		$pEmail = $conn->real_escape_string($pEmail);
		$sql = "SELECT password FROM users WHERE email = '$pEmail'"; //hebben we hash van users
		$result = $conn->query($sql);
		$user = $result->fetch_assoc(); //fetch_assoc --> associatieve array
		if(password_verify($pPassword, $user['password'])){ //password_verify = omgekeerde van hash
			return true;
		}
		else{
			return false;
		}
	}
	

	if(!empty($_POST)){
		$email = $_POST['email']; //kijken bij form field input 
		$password = $_POST['password'];

		if (canLogin ($email, $password)){
			session_start(); //session gebeurt op server, cookie op browser
			$_SESSION['loggedin'] = true;
			/* $salt = "0L9K8J7H6G5F4!è!!#;;;";
			$cookieVal = $email . "," . md5($email.$salt); //salt is iets da bijgevoegd word waardoor ej niet weet wat het is
			setcookie("loggedin", " ", time()+60*60*24*30); // tijd nu + 60sec( = 1 min)*60( = 1 uur)* 24(= 1 dag)*30(= 1 maand), cookie zorgt dat je niet niet in je search naar index.php kan gaan zonder in te loggen */
			header("location: index.php");
		}
		else{
			$error = true;

		}
	}

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
				<h2 form__title>Sign In</h2>

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
					<input type="submit" value="Sign in" class="btn btn--primary">	
					<input type="checkbox" id="rememberMe"><label for="rememberMe" class="label__inline">Remember me</label>
				</div>
			</form>
		</div>
	</div>
</body>
</html>