<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Edit</title>
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
		<?php

			include_once("includes/functions.php");
			if ($_GET['button']) {
				makePostVariables($_GET);	// look at functions...
				$_POST['button'] = "ADD";
			}else{
				$foundedContact = getOneContact($_GET['editId']);
				if ($foundedContact != false){
					makePostVariables($foundedContact);
					$_POST['button'] = "Edit";
				};
			};

		?>

		<div class='err'><h3><?php echo $_GET['msg'];?></h3></div>

		<a href='logout.php'>logout</a>

		<h3>Contact Details</h3>
		<form action="controller.php" method="post">
			<div class="field">
				<label for="first">First</label>
					<input type="text" name="first" id="first" value="<?php echo $_POST['firstname']?>" /></br>
				<label for="last">Last</label>
					<input type="text" name="last" id="last" value="<?php echo $_POST['lastname'];?>" /></br>
				<label for="email">Email</label>
					<input type="text" name="email" id="email" value="<?php echo $_POST['email'];?>" /></br>
				<label for="home">Home</label>
					<input type="radio" name="bestPhone" value="home_phone" checked>
					
					<input type="text" name="home" id="home" value="<?php echo $_POST['home_phone'];?>" /></br>
				<label for="work">Work</label>
					<input type="radio" name="bestPhone" value="work_phone"
								<?php if ($_POST['best_phone'] == "work_phone"){
									echo checked;
								}?>>
					<input type="text" name="work" id="work" value="<?php echo $_POST['work_phone'];?>" /></br>
				<label for="cell">Cell</label>
					<input type="radio" name="bestPhone" value="cell_phone"
								<?php if ($_POST['best_phone'] == "cell_phone"){
									echo checked;
								}?>>
					<input type="text" name="cell" id="cell" value="<?php echo $_POST['cell_phone'];?>" /></br>
				<label for="adress1">Adress 1</label>
					<input type="text" name="adress1" id="adress1" value="<?php echo $_POST['adress1'];?>" /></br>
				<label for="adress2">Adress 2</label>
					<input type="text" name="adress2" id="adress2" value="<?php echo $_POST['adress2'];?>" /></br>
				<label for="city">City</label>
					<input type="text" name="city" id="city" value="<?php echo $_POST['city'];?>" /></br>
				<label for="state">State</label>
					<input type="text" name="state" id="state" value="<?php echo $_POST['state'];?>" /></br>
				<label for="zip">Zip</label>
					<input type="text" name="zip" id="zip" value="<?php echo $_POST['zip'];?>" /></br>
				<label for="country">Country</label>
					<input type="text" name="country" id="country" value="<?php echo $_POST['country'];?>" /></br>
				<label for="birthday">Birthday</label>
					<input type="text" name="birthday" id="birthday" value="<?php echo $_POST['birthday'];?>" /></br>
									
					<input type="hidden" name="id" value="<?php echo $_POST['id'];?>"></br>
			</div>
				
			<input type="submit" name="<?php echo $_POST['button'];?>Button" value="<?php echo $_POST['button'];?>" /></br>
		</form>
	</body>
</html>