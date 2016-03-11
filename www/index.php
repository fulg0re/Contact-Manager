<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/LoginForm</title>
	</head>
	<body>
		<div class='err'><h3><?echo $_GET['msg'];?></h3></div>
		<h3>Login</h3>
		<form action="controller.php" method="post">
			<label for="uname">UserName</label>
				<input type="text" name="uname" id="uname" value="" /></br>
			<label for="pass">Password</label>
				<input type="password" name="pass" id="pass" value="" /></br>

			<input type="submit" name="tryToLogin" value="Login" /></br>
		</form>
	</body>
</html>