<?php
	function getRoute($id = null){
		if (!isset($id)){
			return "/contacts/add";
		}else{
			return "/contacts/edit/" . $id;
		};
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Edit</title>

		<?php require_once '../App/Views/Elements/head.php' ?>

	</head>
	<body>
		<div id='body-div'>

			<?php var_dump($id); ?>

			<?php require_once '../App/Views/Elements/header.php' ?>

			<!-- message part (Elements/message.php) -->
			<?php require_once '../App/Views/Elements/message.php' ?>
			
			<div id="edit-form">
				<form id="form2" 
					action="<?php echo getRoute($id); ?>" method="post">
					<div id="field">
						<p id="edit-title">Information</p>
						<label for="firstname">FirstName*</label>
							<input class="input" type="text" name="firstname" id="firstname"
								maxlength="15"
								value="<?php	echo (isset($firstname)) ? $firstname : null;?>" /></br>
						<label for="lastname">LastName*</label>
							<input class="input" type="text" name="lastname" id="lastname"
								maxlength="15"
								value="<?php echo (isset($lastname)) ? $lastname : null;?>" /></br>
						<label for="email">Email*</label>
							<input class="input" type="text" name="email" id="email"
								value="<?php echo (isset($email)) ? $email : null;?>" /></br>
						<label for="home_phone">HomePhone*</label>
							<input class="input-radio" type="radio" name="best_phone" value="home_phone" checked>
							<input class="input" type="text" name="home_phone" id="home_phone"
								value="<?php echo (isset($home_phone)) ? $home_phone : null;?>" /></br>
						<label for="work_phone">WorkPhone*</label>
							<input class="input-radio" type="radio" name="best_phone" value="work_phone"
								<?php echo (isset($best_phone) && $best_phone == "work_phone") ? "checked" : null;?>>
							<input class="input" type="text" name="work_phone" id="work_phone"
								value="<?php echo (isset($work_phone)) ? $work_phone : null;?>" /></br>
						<label for="cell_phone">CellPhone*</label>
							<input class="input-radio" type="radio" name="best_phone" value="cell_phone"
								<?php echo (isset($best_phone) && $best_phone == "cell_phone") ? "checked" : null;?>>
							<input class="input" type="text" name="cell_phone" id="cell_phone"
								value="<?php echo (isset($cell_phone)) ? $cell_phone : null;?>" /></br>
						<label for="adress1">Adress 1</label>
							<input class="input" type="text" name="adress1" id="adress1"
								value="<?php echo (isset($adress1)) ? $adress1 : null;?>" /></br>
						<label for="adress2">Adress 2</label>
							<input class="input" type="text" name="adress2" id="adress2"
								value="<?php echo (isset($adress2)) ? $adress2 : null;?>" /></br>
						<label for="city">City</label>
							<input class="input" type="text" name="city" id="city"
								value="<?php echo (isset($city)) ? $city : null;?>" /></br>
						<label for="state">State</label>
							<input class="input" type="text" name="state" id="state"
								value="<?php echo (isset($state)) ? $state : null;?>" /></br>
						<label for="zip">Zip</label>
							<input class="input" type="text" name="zip" id="zip"
								value="<?php echo (isset($zip)) ? $zip : null;?>" /></br>
						<label for="country">Country</label>
							<input class="input" type="text" name="country" id="country"
								value="<?php echo (isset($country)) ? $country : null;?>" /></br>
						<label for="birthday">Birthday*</label>
							<input class="input" type="text" name="birthday" id="birthday" placeholder="YYYY-MM-DD"
								value="<?php echo (isset($birthday)) ? $birthday : null;?>" /></br>
						<input type="hidden" name="id" value="<?php echo (isset($id)) ? $id : null;?>"></br>
					</div>

					<div onClick="document.forms['form2'].submit();" 
						name="<?php echo (isset($button)) ? $button : null;?>Button" 
						id="button-submit">

						<img src="/images/login.png" id="login-button-img"/>
						<p id="login-button-p"><?php echo (isset($button)) ? $button : null;?></p>
					</div> 
					<input type="hidden" 
							name="<?php echo (isset($button)) ? $button : null;?>Button"
							value="<?php echo (isset($button)) ? $button : null;?>"></br>
				</form>
			</div>

			<?php require_once '../App/Views/Elements/footer.php' ?>
		</div>
	</body>
</html>
