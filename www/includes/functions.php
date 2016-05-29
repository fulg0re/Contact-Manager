<?php
//echo "<pre>", var_dump($allFields[$i]), "</pre>";

include_once ('config.php');

//******************************************************************************
function allContactsFields(){
	return ["id", "firstname", "lastname",
			"email", "home_phone", "work_phone",
			"cell_phone", "best_phone", "adress1",
			"adress2", "city", "state",
			"zip", "country", "birthday"];
};

function requiredContactsFields(){
	return ["firstname", "lastname", "email", "birthday"];
};

function turnSide($sortTurn){
    return ($sortTurn == "DESC") ? "ASC" : "DESC";
};

//used at contacts.php...
function inputImage(){
    return ($_POST['sortTurn'] == "DESC") ? IMG_SORT_BY_DESC : IMG_SORT_BY_ASC;
};

//used at edit.php...
function makePostVariables($data){
	$allFields = allContactsFields();
	$i = 0;
	while($i < count($allFields)){
		$_POST[$allFields[$i]] = $data[$allFields[$i]];
		$i++;
	};
    $_POST['button'] = "Edit";
};

//used at controller.php
function validationProcess($post){
	$requiredFields = requiredContactsFields();

	//fields validation(check for empty fields)...
	foreach ($requiredFields as $i) {
		if (empty($post[$i])){
            $_SESSION['emptyInput'] = "Please enter \"".$i."\"!!!";
			return false;
		};
	};

	// email validation...
    if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['emptyInput'] = "Wrong \"email\" format!!!";
        return false;
    };

	// phone validation...
	if (empty($post['home_phone']) 
		&& empty($post['work_phone']) 
		&& empty($post['cell_phone'])){
	    
	    $_SESSION['emptyInput'] = "Please enter etleast one phone number!!!";
		return false;
	};

	return true;
};

//used at controller.php...
function wrongAddContact($post){
	$allFields = allContactsFields();

    isset($post['ADDButton']) 
    	? $_SESSION['wrongAdd']['button'] = "ADD" 
    	: $_SESSION['wrongAdd']['button'] = "Edit";

	$i = 0;
	while($i < count($allFields)){
		$_SESSION['wrongAdd'][$allFields[$i]] = $post[$allFields[$i]];
		$i++;
	};
};

function getWrongFields($session){
	$allFields = allContactsFields();

    $_POST['button'] = $session['button'];

	$i = 0;
	while($i < count($allFields)){
		$_POST[$allFields[$i]] = $session[$allFields[$i]];
		$i++;
	};

    unset($_SESSION['wrongAdd']);
};

//used at edit.php...
function getOneContact($id){
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
};

//used at controller.php...
function deleteRow($id){
	include_once ('dbConnection.php');
	$stmt = $conn->prepare("DELETE FROM ".CONTACTS_DB." WHERE id=?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->close();
};

//userd at functions.php >> processLogin()...
function generatePassword($pass){
	return sha1($pass);
};

//used at controller.php...
function processLogin($post){
	include_once ('dbConnection.php');

	$stmt = $conn->prepare("SELECT * FROM ".USERS_DB
							." WHERE username = ? and password = ? Limit 1");
							
	$stmt->bind_param("ss",
			$post['username'], generatePassword($post['password']));

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
};

function makeAddContactQuery($contact){
	$result = " (";
	$allFields = allContactsFields();
	$i = 1;	// we do not nead an "id" field for this(look to config.php)...
	while($i < count($allFields)){
		$result .= $allFields[$i];
		if ($i < count($allFields) - 1){
			$result .= ", ";
		};
		$i++;
	};
	$result .= ") VALUES (";
	$i = 1;	// we do not nead an "id" field for this(look to config.php)...
	while($i < count($allFields)){
		$result .= "'";
		$result .= $contact[$allFields[$i]];
		if ($i < count($allFields) - 1){
			$result .= "', ";
		}else{
			$result .= "'";
		};
		$i++;
	};
	$result .= ")";
	return $result;
};

//used at controller.php...
function processAddContact($post){
	include_once ('dbConnection.php');

	$stmt = $conn->prepare("INSERT INTO ".CONTACTS_DB
							.makeAddContactQuery($post));

	if ($stmt->execute()) {
		$stmt->close();
		return true;
	}else{
		$stmt->close();
		return false;
	};
};

function getSortByArrayForCheck(){
	return ['lastname', 'firstname'];
};

function getSortTurnArrayForCheck(){
	return ['ASC', 'DESC'];
};

function inputValidation($offset){

	// check URL variable "sortBy" if correct...	
	if (!in_array($_POST['sortBy'], getSortByArrayForCheck())) {
		$_POST['sortBy'] = "lastname";
	};
	
	// check URL variable "sortTurn" if correct...
	if (!in_array($_POST['sortTurn'], getSortTurnArrayForCheck())) {
		$_POST['sortTurn'] = "ASC";
	};
	
	// check URL variable "activePage" if correct...
	if ($offset > $_POST['numberOfContacts']){
		$_POST['activePage'] = 1;
		return 0;
	}else{
		return $offset;
	};
};

//used at contacts.php...
function getContacts(){

	include_once ('dbConnection.php');

	if (!isset($_POST['sortBy']) 
		|| !isset($_POST['sortTurn']) 
		|| !isset($_POST['activePage'])){
		
		$_POST['sortBy'] = "lastname";
		$_POST['sortTurn'] = "ASC";
		$_POST['activePage'] = 1;
	};

	$stmt = $conn->prepare("SELECT COUNT(*) AS allContacts FROM ".CONTACTS_DB);

	$stmt->execute();
  
	$stmt->bind_result($allContacts); 
 
	if ($stmt->fetch()){
		$temp['allContacts'] = $allContacts;
	};

	$stmt->close();

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

	$stmt = $conn->prepare("SELECT * FROM ".CONTACTS_DB
				." ORDER BY ".$_POST['sortBy']." ".$_POST['sortTurn']
				." LIMIT ".$offset.", ".$offsetTo);

	$stmt->execute();

	$res = $stmt->get_result();

	if ($res->num_rows > 0){
		$i = 0;
		while ($row = $res->fetch_assoc()){
			$result[$i] = $row;
			$i++;
		};
		$stmt->close();
		return $result;
	};

	$stmt->close();
};

function redirect($roadTo){
	header("location: ".$roadTo);
	exit;
};

//used at controller.php...
function processEditing($post){
	include_once ('dbConnection.php');

	$stmt = $conn->prepare("UPDATE ".CONTACTS_DB." SET "
					."firstname=?, lastname=?, email=?, "
					."home_phone=?, work_phone=?, cell_phone=?, "
					."best_phone=?, adress1=?, adress2=?, city=?, "
					."state=?, zip=?, country=?, birthday=? "
					."WHERE id= ?");

	$stmt->bind_param("sssssssssssssss", 
			$post['firstname'], $post['lastname'], $post['email'],
			$post['home_phone'], $post['work_phone'], $post['cell_phone'],
			$post['best_phone'], $post['adress1'], $post['adress2'],
			$post['city'], $post['state'], $post['zip'], $post['country'],
			$post['birthday'], $post['id']);

	$stmt->execute();

	$stmt->close();

	return true;
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
