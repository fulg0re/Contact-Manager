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
	$tempBestPhone = $post['bestPhone'];
	return $temp = "firstname=".$post['first']."&
		lastname=".$post['last']."&
		email=".$post['email']."&
		home_phone=".$post['home']."&
		work_phone=".$post['work']."&
		cell_phone=".$post['cell']."&
		best_phone=".$tempBestPhone."&
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

function generatePassword($pass){
	return sha1($pass);
};

function processLogin($post){
	include_once ('dbConnection.php');
    $query = "SELECT * FROM users WHERE username = '".$post['uname']."' and password = '".generatePassword($post['pass'])."' Limit 1";
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
	$tempBestPhone = $post['bestPhone'];
    $query = "INSERT INTO contacts 
					(firstname, lastname, email, home_phone, work_phone, cell_phone, best_phone,
					adress1, adress2, city, state, zip, country, birthday)
			VALUES ('".$post['first']."', '".$post['last']."', '".$post['email']."',
					'".$post['home']."', '".$post['work']."', '".$post['cell']."',
					'".$tempBestPhone."', '".$post['adress1']."', '".$post['adress2']."',
					'".$post['city']."', '".$post['state']."', '".$post['zip']."',
					'".$post['country']."',	'".$post['birthday']."')";
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
	$tempBestPhone = $post['bestPhone'];
    $query = "UPDATE contacts SET 
					firstname = '".$post['first']."',
					lastname = '".$post['last']."',
					email = '".$post['email']."',
					home_phone = '".$post['home']."',
					work_phone = '".$post['work']."',
					cell_phone = '".$post['cell']."',
					best_phone = '".$tempBestPhone."',
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