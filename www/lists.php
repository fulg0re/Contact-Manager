<?php

session_start();

if (!$_SESSION['LoggedIn']){
    redirect("index.php");
}

include_once("includes/functions.php");
include_once("includes/forms.php");

if(isset($_POST['buttonAdd']))
{
	redirect("edit.php");
}

if(isset($_GET['deleteId']))
{
	deleteRow($_GET['deleteId']);
	redirect("lists.php");
}

displayContactForm();
