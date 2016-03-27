<?php

session_start();

include_once("includes/functions.php");	
/*
if (!$_SESSION['LoggedIn']){
	redirect("index.php");
}
*/
if(isset($_GET['editId']))
{
	$foundedContact = getOneContact($_GET['editId']);
	if ($foundedContact != false){
		//writeToCookie($foundedContact);
		redirect("edit.php");
		/*
		redirect("edit.php?
			firstname=".$foundedContact['firstname']."&
			lastname=".$foundedContact['lastname']."&
			email=".$foundedContact['email']."&
			home_phone=".$foundedContact['home_phone']."&
			work_phone=".$foundedContact['work_phone']."&
			cell_phone=".$foundedContact['cell_phone']."&
			best_phone=".$foundedContact['best_phone']."&
			adress1=".$foundedContact['adress1']."&
			adress2=".$foundedContact['adress2']."&
			city=".$foundedContact['city']."&
			state=".$foundedContact['state']."&
			zip=".$foundedContact['zip']."&
			country=".$foundedContact['country']."&
			birthday=".$foundedContact['birthday']."&
			id=".$foundedContact['id']."&
			button=Edit"
		);*/
	};
};

if(isset($_GET['deleteId']))
{
	deleteRow($_GET['deleteId']);
	redirect("contacts.php");
};

if(isset($_POST['tryToLogin']))
{
	if (processLogin($_POST) == true)
		redirect("contacts.php");
	redirect("index.php?msg=Login credentials incorrect!&
						wrongLogin=".$_POST['uname']."&
						wrongPassword=".$_POST['pass']);
};

if(isset($_POST['addNewContact']))
{
	redirect("edit.php?button=ADD");
};

if(isset($_POST['EditButton']))
{
	if (validationProcess($_POST) == false)
		redirect("edit.php?msg=Wrong input information!&".wrongAddEditContact($_POST));
	if (processEditing($_POST) == true)
		redirect("contacts.php?msg=Edit was successful");
	redirect("contacts.php?msg=Error editing contact...");
};

if(isset($_POST['ADDButton']))
{
	if (validationProcess($_POST) == false)
		redirect("edit.php?msg=Wrong input information!&".wrongAddEditContact($_POST));
	if (processAddContact($_POST) == true)
		redirect("contacts.php?msg=Data was successfully added");
	displayMassage("Error adding data!");
	
};