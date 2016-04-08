<?php

function turnSide($sortTurn){
	if ($sortTurn == "DESC"){
		echo "ASC";
	}else{
		echo "DESC";
	};
};

function inputImage(){	//used at contacts.php...
	include_once ('config.php');
	if ($_POST['sortTurn'] == "DESC"){
		echo "<img src='".IMG_SORT_BY_DESC."' />";
	}else{
		echo "<img src='".IMG_SORT_BY_ASC."' />";
	};
};

function makePostVariables($data){		//used at edit.php...
	if (isset($data['firstname']) && isset($data['lastname']) && isset($data['email']) && isset($data['home_phone']) &&
		isset($data['work_phone']) && isset($data['cell_phone']) && isset($data['best_phone']) && isset($data['adress1']) &&
		isset($data['adress2']) && isset($data['city']) && isset($data['state']) && isset($data['zip']) &&
		isset($data['country']) && isset($data['birthday']) && isset($data['id'])){
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
};

function validationProcess($post){		//used at controller.php
	$arrayForCheck = array($post['first'], $post['last'], $post['email'], $post['birthday']);

	foreach ($arrayForCheck as $i) {
		if (empty($i)){
			return false;
		};
	};

	if (empty($post['home']) && empty($post['work']) && empty($post['cell'])){	// phone validation...
		return false;
	};

	if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {	// email validation...
		return false;
	};

	return true;
};

function wrongAddContact($post){		//used at controller.php...
	if ($post['ADDButton']){
		$button = "ADD";
	}else $button = "Edit";
	$tempBestPhone = $post['bestPhone'];
	return $temp = "firstname=".$post['first']."&lastname=".$post['last']."&email=".$post['email']."&home_phone="
		.$post['home']."&work_phone=".$post['work']."&cell_phone=".$post['cell']."&best_phone="
		.$tempBestPhone."&adress1=".$post['adress1']."&adress2=".$post['adress2']."&city=".$post['city']."&state="
		.$post['state']."&zip=".$post['zip']."&country=".$post['country']."&birthday=".$post['birthday']."&id="
		.$post['id']."&button=".$button;
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

function getContacts(){		//used at contacts.php...
	include_once ('dbConnection.php');
	include_once ('config.php');

	if (!isset($_POST['sortBy'])){
		$_POST['sortBy'] = "lastname";
		$_POST['sortTurn'] = "ASC";
		$_POST['activePage'] = 1;
	};

	$temp = mysqli_fetch_array($conn->query("SELECT COUNT(*) AS allContacts FROM contacts"));
	$_POST['numberOfContacts'] = $temp['allContacts'];

	$offset = ($_POST['activePage']*MAX_ON_PAGE)-MAX_ON_PAGE;
	$offsetTo = MAX_ON_PAGE;
	if ($_POST['activePage'] < 1) {
		$offset = 0;
	};
	$query = "SELECT * FROM contacts ORDER BY ".$_POST['sortBy']." ".$_POST['sortTurn']." LIMIT ".$offset.", ".$offsetTo;
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