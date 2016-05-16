<?php

include_once ('config.php');

function turnSide($sortTurn){
    return ($sortTurn == "DESC") ? "ASC" : "DESC";
};

function inputImage(){	//used at contacts.php...
    return ($_POST['sortTurn'] == "DESC") ? IMG_SORT_BY_DESC : IMG_SORT_BY_ASC;
};

function makePostVariables($data){		//used at edit.php...
	$allFields = unserialize(ALL_CONTACTS_FIELDS);
	//var_dump(count($allFields));
	$i = 0;
	while($i < count($allFields)){
		//echo "<pre>", var_dump($allFields[$i]), "</pre>";
		$_POST[$allFields[$i]] = $data[$allFields[$i]];
		$i++;
	};
    $_POST['button'] = "Edit";
};

function validationProcess($post){		//used at controller.php
	$arrayForCheck = getRequiredFields($post);

	foreach ($arrayForCheck as $key => $i) {
		if (empty($i)){
            $_SESSION['emptyInput'] = "Please enter \"".$key."\"!!!";
			return false;
		};
	};

    if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {	// email validation...
        $_SESSION['emptyInput'] = "Wrong Email format!!!";
        return false;
    };

	if (empty($post['home_phone']) && empty($post['work_phone']) && empty($post['cell_phone'])){	// phone validation...
        $_SESSION['emptyInput'] = "Please enter etleast one phone number!!!";
		return false;
	};

	return true;
};

function wrongAddContact($post){		//used at controller.php...
	$allFields = unserialize(ALL_CONTACTS_FIELDS);

    isset($post['ADDButton']) ? $_SESSION['wrongAdd']['button'] = "ADD" : $_SESSION['wrongAdd']['button'] = "Edit";

	$i = 0;
	while($i < count($allFields)){
		$_SESSION['wrongAdd'][$allFields[$i]] = $post[$allFields[$i]];
		$i++;
	};
};

function getWrongFields($session){
	$allFields = unserialize(ALL_CONTACTS_FIELDS);

    $_POST['button'] = $session['button'];

	$i = 0;
	while($i < count($allFields)){
		$_POST[$allFields[$i]] = $session[$allFields[$i]];
		$i++;
	};

    unset($_SESSION['wrongAdd']);
};

function getOneContact($id){		//used at edit.php...
	include_once ('dbConnection.php');

	$stmt = $conn->prepare("SELECT * FROM ".CONTACTS_DB." WHERE id = ?");

	$stmt->bind_param("s", $id);

	$stmt->execute();

	$res = $stmt->get_result();

	if ($res->num_rows > 0){
		while ($row = $res->fetch_assoc()){
			foreach($row as $key => $val){
				$result[$key] = $val;
			};
		};
		$stmt->close();
		return $result;
	};

	$stmt->close();
	return false;

/*
	include_once ('dbConnection.php');
    $query = "SELECT * FROM contacts WHERE id = ".$id;
    $results = $conn->query($query);
    if ($results->num_rows > 0){
		return $results->fetch_array(MYSQLI_ASSOC);
	}
	return false;
*/
};

function deleteRow($id){		//used at controller.php...
	include_once ('dbConnection.php');
	$stmt = $conn->prepare("DELETE FROM ".CONTACTS_DB." WHERE id=?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->close();
/*
	include_once ('dbConnection.php');
	$query = "DELETE FROM contacts WHERE id=".$id;
    $result = $conn->query($query);
*/
};

function generatePassword($pass){		//userd at functions.php >> processLogin()...
	return sha1($pass);
};

function processLogin($post){		//used at controller.php...
	include_once ('dbConnection.php');

	$stmt = $conn->prepare("SELECT * FROM ".USERS_DB." WHERE username = ? and password = ? Limit 1");
	$stmt->bind_param("ss", $post['username'], generatePassword($post['password']));

	$stmt->execute();
	$stmt->bind_result($id, $login, $password);
	$stmt->fetch();

	$stmt->close();

	if (isset($login)){
		$_SESSION['LoggedIn'] = true;
		$_SESSION['id'] = $id;
		$_SESSION['username'] = $login;
		return true;
	};
	return false;
/*
    $query = "SELECT * FROM ".USERS_DB." WHERE username = '".
        $post['username']."' and password = '".generatePassword($post['password'])."' Limit 1";
    $results = $conn->query($query);
    if ($results->num_rows <= 0){
		return false;
	}
	$row = $results->fetch_array(MYSQLI_ASSOC);
	$_SESSION['LoggedIn'] = true;
	$_SESSION['id'] = $row['id'];
	$_SESSION['username'] = $row['username'];
	return true;
*/
};

function getRequiredFields($post){
	return array(
        "First Name" => $post['firstname'],
        "Last Name" => $post['lastname'],
        "Email" => $post['email'],
        "Birthday" => $post['birthday']);
};

function getOptionalFields($contact){
	return ['home_phone', 'work_phone', 'cell_phone', 'best_phone', 'adress1', 'adress2',
			'city', 'state', 'zip', 'country'];
};

function makeAddContactQuery($contact){
	return " (firstname, lastname, email, home_phone, work_phone, cell_phone, ".
             "best_phone, adress1, adress2, city, state, zip, country, birthday) ".
			"VALUES ('".$contact['firstname']."', '".$contact['lastname']."', '".$contact['email']."', '".$contact['home_phone']."', ".
					"'".$contact['work_phone']."', '".$contact['cell_phone']."', '".$contact['best_phone']."', '".$contact['adress1']."', ".
					"'".$contact['adress2']."', '".$contact['city']."', '".$contact['state']."', '".$contact['zip']."', ".
					"'".$contact['country']."', '".$contact['birthday']."')";
};

function processAddContact($post){		//used at controller.php...
	include_once ('dbConnection.php');

	$stmt = $conn->prepare("INSERT INTO ". CONTACTS_DB. makeAddContactQuery($post));

	$stmt->execute();

	$stmt->close();

/*
	include_once ('dbConnection.php');
    $query = "INSERT INTO ". CONTACTS_DB. makeAddContactQuery($post);  //getRequiredFields().") VALUES (".getOptionalFields($post).")";
    $conn->query($query);
    return !$conn->error ? true : false;
*/
};

function inputValidation($offset){
	if (($_POST['sortBy'] != "lastname") && ($_POST['sortBy'] != "firstname")){
		$_POST['sortBy'] = "lastname";
	};
	if (($_POST['sortTurn'] != "ASC") && ($_POST['sortTurn'] != "DESC")){
		$_POST['sortTurn'] = "ASC";
	};
	if ($offset > $_POST['numberOfContacts']){
		$_POST['activePage'] = 1;
		return 0;
	}else{
		return $offset;
	};
};

function getContacts(){		//used at contacts.php...

	include_once ('dbConnection.php');

	if (!isset($_POST['sortBy']) || !isset($_POST['sortTurn']) || !isset($_POST['activePage'])){
		$_POST['sortBy'] = "lastname";
		$_POST['sortTurn'] = "ASC";
		$_POST['activePage'] = 1;
	};

	$stmt = $conn->prepare("SELECT COUNT(*) AS allContacts FROM ".CONTACTS_DB);

	$stmt->execute();
  
	$stmt->bind_result($allContacts); 
 
	if ($stmt->fetch()){
		//echo "<pre>", var_dump($allContacts), "</pre>";
		$temp['allContacts'] = $allContacts;
	};

	$stmt->close();
/*
	$temp = mysqli_fetch_array($conn->query("SELECT COUNT(*) AS allContacts FROM contacts"));
*/
    if ($temp['allContacts'] <= 0){
        $_SESSION['noContacts'] = true;
    };
	$_POST['numberOfContacts'] = $temp['allContacts'];

	if ($_POST['activePage'] < 1) {
		$offset = 0;
	}else{
		$offset = ($_POST['activePage']*MAX_ON_PAGE)-MAX_ON_PAGE;		
	};
	$offsetTo = MAX_ON_PAGE;

	$offset = inputValidation($offset);

	$stmt = $conn->prepare("SELECT * FROM ".CONTACTS_DB." ORDER BY ".$_POST['sortBy']." ".$_POST['sortTurn']." LIMIT ".$offset.", ".$offsetTo);

	$stmt->execute();

	$res = $stmt->get_result();

	if ($res->num_rows > 0){
		$i = 0;
		while ($row = $res->fetch_assoc()){
			//echo "<pre>", var_dump($row), "</pre>";
			$result[$i] = $row;
			$i++;
		};
		$stmt->close();
		return $result;
	};

	$stmt->close();

/*
	$query = "SELECT * FROM contacts ORDER BY ".$_POST['sortBy']." ".$_POST['sortTurn'].
		" LIMIT ".$offset.", ".$offsetTo;
    $result = $conn->query($query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
*/

};

function redirect($roadTo){
	header("location: ".$roadTo);
	exit;
};

function processEditing($post){		//used at controller.php...
	include_once ('dbConnection.php');

	$stmt = $conn->prepare("UPDATE ".CONTACTS_DB." SET ".
								"firstname=?, lastname=?, email=?, home_phone=?, work_phone=?, cell_phone=?, ".
								"best_phone=?, adress1=?, adress2=?, city=?, state=?, zip=?, country=?, birthday=? ".
								"WHERE id= ?");

	$stmt->bind_param("sssssssssssssss", $post['firstname'], $post['lastname'], $post['email'], $post['home_phone'], $post['work_phone'],
							$post['cell_phone'], $post['best_phone'], $post['adress1'], $post['adress2'], $post['city'],
							$post['state'], $post['zip'], $post['country'], $post['birthday'], $post['id']);

	$stmt->execute();

	$stmt->close();

	return true;

/*
	$tempBestPhone = $post['best_phone'];
    $query = "UPDATE contacts SET 
					firstname = '".$post['firstname']."',
					lastname = '".$post['lastname']."',
					email = '".$post['email']."',
					home_phone = '".$post['home_phone']."',
					work_phone = '".$post['work_phone']."',
					cell_phone = '".$post['cell_phone']."',
					best_phone = '".$tempBestPhone."',
					adress1 = '".$post['adress1']."',
					adress2 = '".$post['adress2']."',
					city = '".$post['city']."',
					state = '".$post['state']."',
					zip = '".$post['zip']."',
					country = '".$post['country']."',
					birthday = '".$post['birthday']."'
				WHERE id = ".$post['id'];				
    $conn->query($query);
    return true;
*/
};

function checkForMessage(){
    if (isset($_SESSION['msg'])){
        $_POST['msg'] = $_SESSION['msg'];
        unset($_SESSION['msg']);
    };
};

function sortingVariables($sortBy, $sortTurn, $activePage){
    $_POST['sortBy'] = $sortBy;
    $_POST['sortTurn'] = $sortTurn;
    $_POST['activePage'] = $activePage;
};
