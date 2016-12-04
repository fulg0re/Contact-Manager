<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Login</title>

		<?php require_once '../App/Views/Elements/head.php' ?>

	</head>
	<body>
		<div id='body-div'>
			<?php require_once '../App/Views/Elements/header.php' ?>

			<!-- message part (Elements/message.php) -->
			<?php require_once '../App/Views/Elements/message.php' ?>

			<div id="login-form">
				<p id="auth-label">Authorisation</p>
				<form id="form" action="/users/login" method="post">
					<div class="field">
						<label for="username" class="login-form-label">Login:</label>
							<input type="text" name="username" id="username" class="login-form-input"
								value="<?php echo (isset($username)) ? $username : "";?>" /></br>
						<label for="password" class="login-form-label">Password:</label>
							<input type="password" name="password" id="password" class="login-form-input"
								value="<?php echo (isset($password)) ? $password : "";?>" /></br>
					</div>

					<div onClick="document.forms['form'].submit();" name="tryToLogin" id="login-button">  
						<img id="login-button-img"/>
						<p id="login-button-p">Login</p>
					</div> 				
				</form>
			</div>

			<?php require_once '../App/Views/Elements/footer.php' ?>
		</div>
	</body>
</html>
