<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/LoginForm</title>
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
		<div class='err'><h3><?echo $_GET['msg'];?></h3></div>
		<h3>Login</h3>
		<form action="controller.php" method="post">
			<div class="field">
				<label for="uname">UserName</label>
					<input type="text" name="uname" id="uname" class="rightInput" value="" /></br>
				<label for="pass">Password</label>
					<input type="password" name="pass" id="pass" class="rightInput" value="" /></br>
			</div>
				
			<input type="submit" name="tryToLogin" value="Login" /></br>
		</form>
	</body>
</html>