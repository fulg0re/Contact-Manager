<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/LoginForm</title>
		<link rel="stylesheet" href="/css/main.css">
	</head>
	<body>
        <!-- error part -->
		<div class='err'><h3>
                <?php echo (isset($message)) ? $message : null;?></h3>
        </div>
		<h3>Login</h3>
		<form action="/users/login" method="post">
			<div class="field">
				<label for="username">UserName</label>
					<input type="text" name="username" id="username" class="rightInput"
                           value="<?php echo (isset($username)) ? $username : "";?>" /></br>
				<label for="password">Password</label>
					<input type="password" name="password" id="password" class="rightInput"
                           value="<?php echo (isset($password)) ? $password : "";?>" /></br>
			</div>
			
			<input type="submit" name="tryToLogin" value="Login" /></br>
		</form>
	</body>
</html>
