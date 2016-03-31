<?php

session_start();

include_once("includes/functions.php");	
/*
if (!$_SESSION['LoggedIn']){
	redirect("index.php");
}
*/
if(isset($_GET['editId'])){
	$foundedContact = getOneContact($_GET['editId']);	//look at functions...
	if ($foundedContact != false){
		redirect("edit.php");
	};
};

if(isset($_GET['deleteId'])){
	deleteRow($_GET['deleteId']);	//look at functions...
	redirect("contacts.php");
};

if(isset($_POST['tryToLogin'])){
	if (processLogin($_POST) == true){		//look at functions...
		redirect("contacts.php");
	};
	redirect("index.php?msg=Login credentials incorrect!&
						wrongLogin=".$_POST['uname']."&
						wrongPassword=".$_POST['pass']);
};

if(isset($_POST['addNewContact'])){
	redirect("edit.php?button=ADD");
};

if(isset($_POST['EditButton'])){
	if (validationProcess($_POST) == false) {        //look at functions...
		redirect("edit.php?editId=" . $_POST['id']);
	};
	if (processEditing($_POST) == true) {            //look at functions...
		redirect("contacts.php?msg=Edit was successful");
	}
	redirect("contacts.php?msg=Error editing contact...");
};

if(isset($_POST['ADDButton'])){
	if (validationProcess($_POST) == false) {        //look at functions...
		redirect("edit.php?msg=Wrong input information!&" . wrongAddContact($_POST));
	};
	if (processAddContact($_POST) == true) {        //look at functions...
		redirect("contacts.php?msg=Data was successfully added");
	}
	redirect("contacts.php?msg=Error editing contact...");
	
};