<?php

function validationProcess($post){
	if ($post['first'] == "" || $post['last'] == "" || $post['email'] == "" || $post['home'] == "" ||
	$post['work'] == "" || $post['cell'] == "" || $post['adress1'] == "" || $post['adress2'] == "" ||
	$post['city'] == "" || $post['state'] == "" || $post['zip'] == "" || $post['country'] == "" ||
	$post['birthday'] == "")
		return false;
	return true;
};

function wrongAddEditContact($post){
	if ($post['ADDButton']){
		$button = "ADD";
	}else $button = "Edit";
	switch ($post['phoneChecker']) {
		case 1:
			$tempHomePhone = "true";
			$tempWorkPhone = "false";
			$tempCellPhone = "false";
			break;
		case 2:
			$tempHomePhone = "false";
			$tempWorkPhone = "true";
			$tempCellPhone = "false";
			break;
		case 3:
			$tempHomePhone = "false";
			$tempWorkPhone = "false";
			$tempCellPhone = "true";
			break;
	};
	return $temp = "firstName=".$post['first']."&
		lastName=".$post['last']."&
		email=".$post['email']."&
		homePhone=".$post['home']."&
		homePhoneChecked=".$tempHomePhone."&
		workPhone=".$post['work']."&
		workPhoneChecked=".$tempWorkPhone."&
		cellPhone=".$post['cell']."&
		cellPhoneChecked=".$tempCellPhone."&
		adress1=".$post['adress1']."&
		adress2=".$post['adress2']."&
		city=".$post['city']."&
		state=".$post['state']."&
		zip=".$post['zip']."&
		country=".$post['country']."&
		birthday=".$post['birthday']."&
		id=".$post['id']."&
		button=".$button; 
};

function getOneContact($id){
	include_once ('dbConnection.php');
    $query = "SELECT * FROM contacts WHERE id = ".$id;
    $results = $conn->query($query);
    if ($results->num_rows > 0)
        return $results->fetch_array(MYSQLI_ASSOC);
	return false;
};

function deleteRow($id){
	include_once ('dbConnection.php');
	$query = "DELETE FROM contacts WHERE id=".$id;
    $result = $conn->query($query);
};

function displayMassage($msg){
    echo "<div class='err'>$msg</div>";
};

function passwordGeneretor($pass){
	return sha1($pass);
};

function processLogin($post){
	include_once ('dbConnection.php');
    $query = "SELECT * FROM users WHERE username = '".$post['uname']."' and password = '".passwordGeneretor($post['pass'])."' Limit 1";
    $results = $conn->query($query);
    if ($results->num_rows <= 0)
		return false;
	$row = $results->fetch_array(MYSQLI_ASSOC);
	$_SESSION['LoggedIn'] = true;
	$_SESSION['id'] = $row['id'];
	$_SESSION['username'] = $row['username'];
	return true;
};

function processAddContact($post){
	include_once ('dbConnection.php');
	switch ($post['phoneChecker']) {
		case 1:
			$tempHomeChecked = "true";
			$tempWorkChecked = "false";
			$tempCellChecked = "false";
			break;
		case 2:
			$tempHomeChecked = "false";
			$tempWorkChecked = "true";
			$tempCellChecked = "false";
			break;
		case 3:
			$tempHomeChecked = "false";
			$tempWorkChecked = "false";
			$tempCellChecked = "true";
			break;
	};
    $query = "INSERT INTO contacts 
					(firstName, lastName, email, homePhone, homePhoneChecked, workPhone, workPhoneChecked, 
					cellPhone, cellPhoneChecked, adress1, adress2, city, state, zip, country, birthday)
			VALUES ('".$post['first']."', '".$post['last']."', '".$post['email']."',
					'".$post['home']."', '".$tempHomeChecked."', '".$post['work']."',
					'".$tempWorkChecked."', '".$post['cell']."', '".$tempCellChecked."',
					'".$post['adress1']."', '".$post['adress2']."','".$post['city']."',
					'".$post['state']."', '".$post['zip']."', '".$post['country']."',
					'".$post['birthday']."')";
    $results = $conn->query($query);
    if (!$results->error)
        return true;
    return false;
};

function getContacts(){
	include_once ('dbConnection.php');
    $query = "SELECT * FROM contacts";
    $result = $conn->query($query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
};

function redirect($roadTo){
	header("location: ".$roadTo);
	exit;
};

function processEditing($post){
	include_once ('dbConnection.php');	
	switch ($post['phoneChecker']) {
		case 1:
			$tempHomeChecked = "true";
			$tempWorkChecked = "false";
			$tempCellChecked = "false";
			break;
		case 2:
			$tempHomeChecked = "false";
			$tempWorkChecked = "true";
			$tempCellChecked = "false";
			break;
		case 3:
			$tempHomeChecked = "false";
			$tempWorkChecked = "false";
			$tempCellChecked = "true";
			break;
	};	
    $query = "UPDATE contacts SET 
					firstName = '".$post['first']."',
					lastName = '".$post['last']."',
					email = '".$post['email']."',
					homePhone = '".$post['home']."',
					homePhoneChecked = '".$tempHomeChecked."',
					workPhone = '".$post['work']."',
					workPhoneChecked = '".$tempWorkChecked."',
					cellPhone = '".$post['cell']."',
					cellPhoneChecked = '".$tempCellChecked."',
					adress1 = '".$post['adress1']."',
					adress2 = '".$post['adress2']."',
					city = '".$post['city']."',
					state = '".$post['state']."',
					zip = '".$post['zip']."',
					country = '".$post['country']."',
					birthday = '".$post['birthday']."'
				WHERE id = ".$post['id'];				
    $results = $conn->query($query);
    if (!$results->error)
        return true;
    return false;
};