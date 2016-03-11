<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Edit</title>
	</head>
	<body>
		<div class='err'><h3><?echo $_GET['msg'];?></h3></div>
		
		<a href='logout.php'>logout</a>
		
		<h3>Contact Details</h3>
		<form action="controller.php" method="post">
			<label for="first">First</label>
				<input type="text" name="first" id="first" value="<?echo $_GET['firstName'];?>" /></br>
			<label for="last">Last</label>
				<input type="text" name="last" id="last" value="<?echo $_GET['lastName'];?>" /></br>
			<label for="email">Email</label>
				<input type="text" name="email" id="email" value="<?echo $_GET['email'];?>" /></br>
			<label for="home">Home</label>
				<input type="radio" name="homeRadioB" value="">
				<input type="text" name="home" id="home" value="<?echo $_GET['homePhone'];?>" /></br>
			<label for="work">Work</label>
				<input type="radio" name="workRadioB" value="">
				<input type="text" name="work" id="work" value="<?echo $_GET['workPhone'];?>" /></br>
			<label for="cell">Cell</label>
				<input type="radio" name="cellRadioB" value="">
				<input type="text" name="cell" id="cell" value="<?echo $_GET['cellPhone'];?>" /></br>
			<label for="adress1">Adress 1</label>
				<input type="text" name="adress1" id="adress1" value="<?echo $_GET['adress1'];?>" /></br>
			<label for="adress2">Adress 2</label>
				<input type="text" name="adress2" id="adress2" value="<?echo $_GET['adress2'];?>" /></br>
			<label for="city">City</label>
				<input type="text" name="city" id="city" value="<?echo $_GET['city'];?>" /></br>
			<label for="state">State</label>
				<input type="text" name="state" id="state" value="<?echo $_GET['state'];?>" /></br>
			<label for="zip">Zip</label>
				<input type="text" name="zip" id="zip" value="<?echo $_GET['zip'];?>" /></br>
			<label for="country">Country</label>
				<input type="text" name="country" id="country" value="<?echo $_GET['country'];?>" /></br>
			<label for="birthday">Birthday</label>
				<input type="text" name="birthday" id="birthday" value="<?echo $_GET['birthday'];?>" /></br>
				
				<input type="hidden" name="id" value="<?echo $_GET['id'];?>"></br>
				
			<input type="submit" name="<?echo $_GET['button'];?>Button" value="<?echo $_GET['button'];?>" /></br>
		</form>
	</body>
</html>