<?php

function makePostVariables($data){		//used at edit.php...
	$_POST['firstname'] = $data['firstname'];
	$_POST['lastname'] = $data['lastname'];
	$_POST['email'] = $data['email'];
	$_POST['home_phone'] = $data['home_phone'];
	$_POST['work_phone'] = $data['work_phone'];
	$_POST['cell_phone'] = $data['cell_phone'];
	$_POST['best_phone'] = $data['best_phone'];
	$_POST['adress1'] = $data['adress1'];
	$_POST['adress2'] = $data['adress2'];
	$_POST['city'] = $data['city'];
	$_POST['state'] = $data['state'];
	$_POST['zip'] = $data['zip'];
	$_POST['country'] = $data['country'];
	$_POST['birthday'] = $data['birthday'];
	$_POST['id'] = $data['id'];
};

function validationProcess($post){		//used at controller.php
	if ($post['first'] == "" || $post['last'] == "" || $post['email'] == "" || $post['birthday'] == "" ||
		$post['home'] == "" || $post['work'] == "" || $post['cell'] == ""){
		return false;
	}
	return true;
};

function wrongAddContact($post){		//used at controller.php...
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

function getOneContact($id){		//used at edit.php...
	include_once ('dbConnection.php');
    $query = "SELECT * FROM contacts WHERE id = ".$id;
    $results = $conn->query($query);
    if ($results->num_rows > 0){
		return $results->fetch_array(MYSQLI_ASSOC);
	}
	return false;
};

function deleteRow($id){		//used at controller.php...
	include_once ('dbConnection.php');
	$query = "DELETE FROM contacts WHERE id=".$id;
    $result = $conn->query($query);
};

function generatePassword($pass){		//userd at functions.php >> processLogin()...
	return sha1($pass);
};

function processLogin($post){		//used at controller.php...
	include_once ('dbConnection.php');
    $query = "SELECT * FROM users WHERE username = '".$post['uname']."' and password = '".generatePassword($post['pass'])."' Limit 1";
    $results = $conn->query($query);
    if ($results->num_rows <= 0){
		return false;
	}
	$row = $results->fetch_array(MYSQLI_ASSOC);
	$_SESSION['LoggedIn'] = true;
	$_SESSION['id'] = $row['id'];
	$_SESSION['username'] = $row['username'];
	return true;
};

function processAddContact($post){		//used at controller.php...
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
    if (!$results->error){
		return true;
	}
    return false;
};

function getContacts($activePage){		//used at contacts.php...
	include_once ('dbConnection.php');
	include_once ('config.php');
	$_POST['numberOfContacts'] = count(mysqli_fetch_all($conn->query("SELECT * FROM contacts"), MYSQLI_ASSOC));

	$limitFrom = ($activePage*MAX_ON_PAGE)-MAX_ON_PAGE;
	$limitTo = MAX_ON_PAGE;
	if ($activePage < 1){
		$query = "SELECT * FROM contacts LIMIT 0, ". $limitTo;
	}else{
		$query = "SELECT * FROM contacts LIMIT ".$limitFrom.", ".$limitTo;
	};
    $result = $conn->query($query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
};

function redirect($roadTo){
	header("location: ".$roadTo);
	exit;
};

function processEditing($post){		//used at controller.php...
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
    if (!$results->error){
		return true;
	}
    return false;
};