<?php

function displayMassage($msg){
    echo "<div class='err'>$msg</div>";
}

function processLogin($post){
    //$conn = getConnection();
	include_once ('config.php');

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

function processAddContact($post){		// (firstname, lastname, email)
	include_once ('config.php');
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
    //$conn = getConnection();
	include_once ('config.php');
    $query = "SELECT * FROM contacts";

    $result = $conn->query($query);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function redirect($roadTo){
	header("location: ".$roadTo);
	exit;
}