<?php

session_start();

include_once("includes/functions.php");	
/*
if (!$_SESSION['LoggedIn']){
	redirect("index.html");
}
*/
if(isset($_GET['editId']))
{
	$foundedContact = getOneContact($_GET['editId']);
	if ($foundedContact != false){
		redirect("edit.php?
				firstName=".$foundedContact['firstName']."
				&lastName=".$foundedContact['lastName']."
				&email=".$foundedContact['email']."
				&homePhone=".$foundedContact['homePhone']."
				&workPhone=".$foundedContact['workPhone']."
				&cellPhone=".$foundedContact['cellPhone']."
				&adress1=".$foundedContact['adress1']."
				&adress2=".$foundedContact['adress2']."
				&city=".$foundedContact['city']."
				&state=".$foundedContact['state']."
				&zip=".$foundedContact['zip']."
				&country=".$foundedContact['country']."
				&birthday=".$foundedContact['birthday']."
				&id=".$foundedContact['id']."
				&button=Edit"
				);

	};
};

if(isset($_GET['deleteId']))
{
	deleteRow($_GET['deleteId']);
	redirect("contacts.php");
}

if(isset($_POST['tryToLogin']))
{
	if (processLogin($_POST) == true) {
		redirect("contacts.php");
	} else {
		redirect("index.php?msg=Login credentials incorrect!");
	}
};

if(isset($_POST['addNewContact']))
{
	redirect("edit.php?button=ADD");
};

if(isset($_POST['EditButton']))
{
	if (processEditing($_POST) == true) {
		redirect("contacts.php?msg=Edit was successful");
	} else {
		redirect("contacts.php?msg=Error editing contact...");
	}
};

if(isset($_POST['ADDButton']))
{
	if (processAddContact($_POST) == true) {
		redirect("contacts.php?msg=Data was successfully added");
	} else {
		displayMassage("Error adding data!");
	}
	
};

if (!$_SESSION['LoggedIn']) {
		redirect("index.html");
	}