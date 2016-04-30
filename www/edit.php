<?php

include_once('includes/session.php');       // session_start(); and error_reporting(E_ALL);
include_once('includes/authorization.php');
include_once("includes/functions.php");

if (isset($_SESSION['msg'])) {
	$_POST['msg'] = $_SESSION['msg'];
	unset($_SESSION['msg']);
};

if (isset($_SESSION['wrongAdd'])){
	if (isset($_SESSION['emptyInput'])){
		$_POST['msg'] = $_SESSION['emptyInput'];
		unset($_SESSION['emptyInput']);
	};
    getWrongFields($_SESSION['wrongAdd']);
};

if (isset($_SESSION['button'])) {
    $_POST['button'] = $_SESSION['button'];
    unset($_SESSION['button']);
}elseif (isset($_SESSION['editId'])){
    $_POST['editId'] = $_SESSION['editId'];
	unset($_SESSION['editId']);
    $foundedContact = getOneContact($_POST['editId']);
    if ($foundedContact != false){
        makePostVariables($foundedContact);		// look at functions...
    };
};

?>
<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Edit</title>
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
        <!-- error part -->
		<div class='err'><h3><?php echo (isset($_POST['msg'])) ? $_POST['msg'] : null;?></h3></div>
		<a href='logout.php'>logout</a><br><br>
		<a href='contacts.php'>back</a>
		<h3>Contact Details</h3>
		<form action="controller.php" method="post">
			<div class="field">
				<label for="first">First*</label>
					<input type="text" name="first" id="first"
                           value="<?php	echo (isset($_POST['firstname'])) ? $_POST['firstname'] : null;?>" /></br>
				<label for="last">Last*</label>
					<input type="text" name="last" id="last"
                           value="<?php echo (isset($_POST['lastname'])) ? $_POST['lastname'] : null;?>" /></br>
				<label for="email">Email*</label>
					<input type="text" name="email" id="email"
                           value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : null;?>" /></br>
				<label for="home">Home*</label>
					<input type="radio" name="bestPhone" value="home_phone" checked>
					<input type="text" name="home" id="home"
                           value="<?php echo (isset($_POST['home_phone'])) ? $_POST['home_phone'] : null;?>" /></br>
				<label for="work">Work*</label>
					<input type="radio" name="bestPhone" value="work_phone"
                        <?php echo (isset($_POST['best_phone']) && $_POST['best_phone'] == "work_phone") ? "checked" : null;?>>
					<input type="text" name="work" id="work"
                           value="<?php echo (isset($_POST['work_phone'])) ? $_POST['work_phone'] : null;?>" /></br>
				<label for="cell">Cell*</label>
					<input type="radio" name="bestPhone" value="cell_phone"
                        <?php echo (isset($_POST['best_phone']) && $_POST['best_phone'] == "cell_phone") ? "checked" : null;?>>
					<input type="text" name="cell" id="cell"
                           value="<?php echo (isset($_POST['cell_phone'])) ? $_POST['cell_phone'] : null;?>" /></br>
				<label for="adress1">Adress 1</label>
					<input type="text" name="adress1" id="adress1"
                           value="<?php echo (isset($_POST['adress1'])) ? $_POST['adress1'] : null;?>" /></br>
				<label for="adress2">Adress 2</label>
					<input type="text" name="adress2" id="adress2"
                           value="<?php echo (isset($_POST['adress2'])) ? $_POST['adress2'] : null;?>" /></br>
				<label for="city">City</label>
					<input type="text" name="city" id="city"
                           value="<?php echo (isset($_POST['city'])) ? $_POST['city'] : null;?>" /></br>
				<label for="state">State</label>
					<input type="text" name="state" id="state"
                           value="<?php echo (isset($_POST['state'])) ? $_POST['state'] : null;?>" /></br>
				<label for="zip">Zip</label>
					<input type="text" name="zip" id="zip"
                           value="<?php echo (isset($_POST['zip'])) ? $_POST['zip'] : null;?>" /></br>
				<label for="country">Country</label>
					<input type="text" name="country" id="country"
                           value="<?php echo (isset($_POST['country'])) ? $_POST['country'] : null;?>" /></br>
				<label for="birthday">Birthday*</label>
					<input type="text" name="birthday" id="birthday" placeholder="YYYY-MM-DD"
                           value="<?php echo (isset($_POST['birthday'])) ? $_POST['birthday'] : null;?>" /></br>
                <input type="hidden" name="id" value="<?php echo (isset($_POST['id'])) ? $_POST['id'] : null;?>"></br>
			</div>
			<input type="submit"
                   name="<?php echo (isset($_POST['button'])) ? $_POST['button'] : null;?>Button"
                   value="<?php echo (isset($_POST['button'])) ? $_POST['button'] : null;?>" /></br>
		</form>
	</body>
</html>