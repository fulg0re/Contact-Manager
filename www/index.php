<?php

include_once('includes/session.php');       // session_start(); and error_reporting(E_ALL);
include_once('includes/functions.php');

isset($_SESSION['LoggedIn']) ? redirect("contacts.php") : null;

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $_POST['username'] = $_SESSION['username'];
    $_POST['password'] = $_SESSION['password'];
    $_POST['msg'] = $_SESSION['msg'];
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['msg']);
};

?>

<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/LoginForm</title>
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
        <!-- error part -->
		<div class='err'><h3>
                <?php echo (isset($_POST['msg'])) ? $_POST['msg'] : null;?></h3>
        </div>
		<h3>Login</h3>
		<form action="controller.php" method="post">
			<div class="field">
				<label for="username">UserName</label>
					<input type="text" name="username" id="username" class="rightInput"
                           value="<?php echo (isset($_POST['username'])) ? $_POST['username'] : "";?>" /></br>
				<label for="password">Password</label>
					<input type="password" name="password" id="password" class="rightInput"
                           value="<?php echo (isset($_POST['password'])) ? $_POST['password'] : "";?>" /></br>
			</div>
			
			<input type="submit" name="tryToLogin" value="Login" /></br>
		</form>
	</body>
</html>