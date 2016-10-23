<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Login</title>

		<?php require_once '../App/Views/Elements/head.php' ?>

	</head>
	<body>
		<?php require_once '../App/Views/Elements/header.php' ?>

		<!-- message part (Elements/message.php) -->
		<?php require_once '../App/Views/Elements/message.php' ?>

		<div id="login-form">
			<p id="auth-label">Authorisation</p>
			<form action="/users/login" method="post">
				<div class="field">
					<label for="username" class="login-form-label">Login</label>
						<input type="text" name="username" id="username" class="login-form-input"
							value="<?php echo (isset($username)) ? $username : "";?>" /></br>
					<label for="password" class="login-form-label">Password</label>
						<input type="password" name="password" id="password" class="login-form-input"
							value="<?php echo (isset($password)) ? $password : "";?>" /></br>
				</div>					
				<input type="submit" id="login-button" name="tryToLogin" value="Login" /></br>
			</form>
		</div>

		<?php require_once '../App/Views/Elements/footer.php' ?>
	</body>
</html>
