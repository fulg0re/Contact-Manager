<?php

function getOneContact($id){
	include_once ('dbConnection.php');
    $query = "SELECT * FROM contacts WHERE id = ".$id;
    $results = $conn->query($query);
    if ($results->num_rows > 0){
        return $results->fetch_array(MYSQLI_ASSOC);
	}else{
		return false;
	}
};

function deleteRow($id){
	include_once ('dbConnection.php');
	$query = "DELETE FROM contacts WHERE id=".$id;
    $result = $conn->query($query);
};

function displayMassage($msg){
    echo "<div class='err'>$msg</div>";
}

function processLogin($post){
	include_once ('dbConnection.php');

    $query = "SELECT * FROM users WHERE username = '".$post['uname']."' and password = '".sha1($post['pass'])."' Limit 1";
    $results = $conn->query($query);
    if ($results->num_rows > 0){
        $row = $results->fetch_array(MYSQLI_ASSOC);
        $_SESSION['LoggedIn'] = true;
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        return true;
    }else {
        return false;
    }
}

function processAddContact($post){
	include_once ('dbConnection.php');
	$tempFirstName = $post['first'];
	$tempLastName = $post['last'];
	$tempEmail = $post['email'];
	$tempHome = $post['home'];
	$tempWork = $post['work'];
	$tempCell = $post['cell'];
	$tempAdress1 = $post['adress1'];
	$tempAdress2 = $post['adress2'];
	$tempCity = $post['city'];
	$tempState = $post['state'];
	$tempZip = $post['zip'];
	$tempCountry = $post['country'];
	$tempBirthday = $post['birthday'];
    $query = "INSERT INTO contacts 
					(firstName, lastName, email, homePhone, workPhone, cellPhone, adress1, 
					adress2, city, state, zip, country, birthday)
			VALUES ('$tempFirstName', '$tempLastName', '$tempEmail', '$tempHome', '$tempWork',
					'$tempCell', '$tempAdress1', '$tempAdress2', '$tempCity', '$tempState',
					'$tempZip', '$tempCountry', '$tempBirthday')";
    $results = $conn->query($query);
    if (!$results->error){
        return true;
    }else {
        return false;
    }
};

function getContacts(){
	include_once ('dbConnection.php');
    $query = "SELECT * FROM contacts";

    $result = $conn->query($query);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function redirect($roadTo){
	header("location: ".$roadTo);
	exit;
}

function processEditing($post){
	include_once ('dbConnection.php');
	
	switch ($post['gender']) {
		case 1:
			$tempHomeChecked = "YES";
			$tempWorkChecked = "NO";
			$tempCellChecked = "NO";
			break;
		case 2:
			$tempHomeChecked = "NO";
			$tempWorkChecked = "YES";
			$tempCellChecked = "NO";
			break;
		case 3:
			$tempHomeChecked = "NO";
			$tempWorkChecked = "NO";
			$tempCellChecked = "YES";
			break;
	}
	$tempFirstName = $post['first'];
	$tempLastName = $post['last'];
	$tempEmail = $post['email'];
	$tempHome = $post['home'];
	$tempWork = $post['work'];
	$tempCell = $post['cell'];
	$tempAdress1 = $post['adress1'];
	$tempAdress2 = $post['adress2'];
	$tempCity = $post['city'];
	$tempState = $post['state'];
	$tempZip = $post['zip'];
	$tempCountry = $post['country'];
	$tempBirthday = $post['birthday'];
	$tempId = $post['id'];
	
    $query = "UPDATE contacts SET 
					firstName = '".$tempFirstName."',
					lastName = '".$tempLastName."',
					email = '".$tempEmail."',
					homePhone = '".$tempHome."',
					homePhoneChecked = '".$tempHomeChecked."',
					workPhone = '".$tempWork."',
					workPhoneChecked = '".$tempWorkChecked."',
					cellPhone = '".$tempCell."',
					cellPhoneChecked = '".$tempCellChecked."',
					adress1 = '".$tempAdress1."',
					adress2 = '".$tempAdress2."',
					city = '".$tempCity."',
					state = '".$tempState."',
					zip = '".$tempZip."',
					country = '".$tempCountry."',
					birthday = '".$tempBirthday."'
				WHERE id = ".$tempId;
				
    $results = $conn->query($query);
    if (!$results->error){
        return true;
    }else {
        return false;
    }
};