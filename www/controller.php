<?php

include_once('includes/session.php');       // session_start(); and error_reporting(E_ALL);

include_once("includes/functions.php");
/*
if(isset($_GET['editId'])){
	$foundedContact = getOneContact($_GET['editId']);	//look at functions...
	if ($foundedContact != false){
		redirect("edit.php");
	};
};
*/
if(isset($_GET['deleteId'])){
	deleteRow($_GET['deleteId']);	//look at functions...
	redirect("contacts.php");
};

if(isset($_GET['editId'])){
	$_SESSION['editId'] = $_GET['editId'];	//look at functions...
	redirect("edit.php");
};

if(isset($_POST['tryToLogin'])){
	if (processLogin($_POST) == true){		//look at functions...
		redirect("contacts.php");
	};
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];
	$_SESSION['msg'] = "Wrong login or password!";
	redirect("index.php");
};

if(isset($_POST['addNewContact'])){
	$_SESSION['button'] = "ADD";
	redirect("edit.php");
};

if(isset($_POST['EditButton'])){
	if (validationProcess($_POST) == false) {        //look at functions...
		$_SESSION['editId'] = $_POST['id'];
		wrongAddContact($_POST);
		redirect("edit.php");
	};
	if (processEditing($_POST) == true) {            //look at functions...
		$_SESSION['msg'] = "Edit was successful";
		redirect("contacts.php");
	};
	$_SESSION['msg'] = "Error editing contact...";
	redirect("contacts.php");
};

if(isset($_POST['ADDButton'])){
	if (validationProcess($_POST) == false) {        //look at functions...
		wrongAddContact($_POST);
		redirect("edit.php");
	};
	if (processAddContact($_POST) == true) {        //look at functions...
		$_SESSION['msg'] = "Data was successfully added";
		redirect("contacts.php");
	};
	$_SESSION['msg'] = "Error editing contact...";
	redirect("contacts.php");
	
};

if(isset($_GET['checkbox'])){
		var_dump($_GET['checkbox']);
};
