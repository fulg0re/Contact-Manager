<?php

session_start();

if (!$_SESSION['LoggedIn']){
	redirect("index.php");
}

include_once("includes/functions.php");
include_once("includes/forms.php");	

if ($_POST['submitted']) {
	if (processAddContact($_POST) == true) {
		displayMassage("Data was successfully added");
	} else {
		displayMassage("Error adding data!");
	}
	echo "<div class='formDiv'>";
		displayAddForm();
	echo "</div>";
}else{
	echo "<div class='formDiv'>";
		displayAddForm();
	echo "</div>";
};



if(isset($_GET['editId']))
{
	$foundedContact = getOneContact($_GET['editId']);
	if ($foundedContact != false){		
		$tempFirstName = $foundedContact['firstName'];
		$tempLastName = $foundedContact['lastName'];
		$tempEmail = $foundedContact['email'];
		$tempHome = $foundedContact['homePhone'];
		$tempWork = $foundedContact['workPhone'];
		$tempCell = $foundedContact['cellPhone'];
		$tempAdress1 = $foundedContact['adress1'];
		$tempAdress2 = $foundedContact['adress2'];
		$tempCity = $foundedContact['city'];
		$tempState = $foundedContact['state'];
		$tempZip = $foundedContact['zip'];
		$tempCountry = $foundedContact['country'];
		$tempBirthday = $foundedContact['birthday'];
		/*
		redirect('edit.php?
				firstName=".$tempFirstName."
				
				');
		*/
	}
}














