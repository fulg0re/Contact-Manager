<?php

	if (isset($_SESSION['params'])){
		extract($_SESSION['params'], EXTR_SKIP);
		unset($_SESSION['params']);
	};

?>

<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Edit</title>
		<link rel="stylesheet" href="/css/main.css">
	</head>
	<body>
		<!-- error part -->
		<div class='err'><h3><?php echo (isset($message)) ? $message : "";?></h3></div>
		<a href='/contacts/logout'>logout</a><br><br>
		<a href='/contacts/posts'>back</a>
		<h3>Contact Details</h3>
		<form action="/contacts/new" method="post">
			<div class="field">
				<label for="firstname">FirstName*</label>
					<input type="text" name="firstname" id="firstname"
                           value="<?php	echo (isset($firstname)) ? $firstname : null;?>" /></br>
				<label for="lastname">LastName*</label>
					<input type="text" name="lastname" id="lastname"
                           value="<?php echo (isset($lastname)) ? $lastname : null;?>" /></br>
				<label for="email">Email*</label>
					<input type="text" name="email" id="email"
                           value="<?php echo (isset($email)) ? $email : null;?>" /></br>
				<label for="home_phone">HomePhone*</label>
					<input type="radio" name="best_phone" value="home_phone" checked>
					<input type="text" name="home_phone" id="home_phone"
                           value="<?php echo (isset($home_phone)) ? $home_phone : null;?>" /></br>
				<label for="work_phone">WorkPhone*</label>
					<input type="radio" name="best_phone" value="work_phone"
                        <?php echo (isset($best_phone) && $best_phone == "work_phone") ? "checked" : null;?>>
					<input type="text" name="work_phone" id="work_phone"
                           value="<?php echo (isset($work_phone)) ? $work_phone : null;?>" /></br>
				<label for="cell_phone">CellPhone*</label>
					<input type="radio" name="best_phone" value="cell_phone"
                        <?php echo (isset($best_phone) && $best_phone == "cell_phone") ? "checked" : null;?>>
					<input type="text" name="cell_phone" id="cell_phone"
                           value="<?php echo (isset($cell_phone)) ? $cell_phone : null;?>" /></br>
				<label for="adress1">Adress 1</label>
					<input type="text" name="adress1" id="adress1"
                           value="<?php echo (isset($adress1)) ? $adress1 : null;?>" /></br>
				<label for="adress2">Adress 2</label>
					<input type="text" name="adress2" id="adress2"
                           value="<?php echo (isset($adress2)) ? $adress2 : null;?>" /></br>
				<label for="city">City</label>
					<input type="text" name="city" id="city"
                           value="<?php echo (isset($city)) ? $city : null;?>" /></br>
				<label for="state">State</label>
					<input type="text" name="state" id="state"
                           value="<?php echo (isset($state)) ? $state : null;?>" /></br>
				<label for="zip">Zip</label>
					<input type="text" name="zip" id="zip"
                           value="<?php echo (isset($zip)) ? $zip : null;?>" /></br>
				<label for="country">Country</label>
					<input type="text" name="country" id="country"
                           value="<?php echo (isset($country)) ? $country : null;?>" /></br>
				<label for="birthday">Birthday*</label>
					<input type="text" name="birthday" id="birthday" placeholder="YYYY-MM-DD"
                           value="<?php echo (isset($birthday)) ? $birthday : null;?>" /></br>
                <input type="hidden" name="id" value="<?php echo (isset($id)) ? $id : null;?>"></br>
			</div>
			<input type="submit"
                   name="<?php echo (isset($button)) ? $button : null;?>Button"
                   value="<?php echo (isset($button)) ? $button : null;?>" /></br>
		</form>
	</body>
</html>
