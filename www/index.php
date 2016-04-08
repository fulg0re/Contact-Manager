<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/LoginForm</title>
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
		<?php error_reporting(E_ALL);?>	 <!--check for errors...-->

		<div class='err'><h3><?php
								if (isset($_GET['msg'])){
									echo $_GET['msg'];
								};?></h3></div>
		<h3>Login</h3>
		<form action="controller.php" method="post">
			<div class="field">
				<label for="uname">UserName</label>
					<input type="text" name="uname" id="uname" 
									class="rightInput" value="<?php
																if (isset($_GET['wrongLogin'])){
																	echo $_GET['wrongLogin'];
																};?>" /></br>
				<label for="pass">Password</label>
					<input type="password" name="pass" id="pass" 
									class="rightInput" value="<?php
																if (isset($_GET['wrongPassword'])){
																	echo $_GET['wrongPassword'];
																};?>" /></br>
			</div>
			
			<input type="submit" name="tryToLogin" value="Login" /></br>
		</form>
	</body>
</html>