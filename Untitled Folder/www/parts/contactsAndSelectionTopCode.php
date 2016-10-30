<?php

include_once('includes/session.php');       // session_start(); and error_reporting(E_ALL);
include_once('includes/authorization.php');
include_once("includes/functions.php");
include_once("includes/config.php");

checkForMessage();

if (isset($_GET['sortBy']) && isset($_GET['sortTurn']) && isset($_GET['activePage'])){
	sortingVariables($_GET['sortBy'], $_GET['sortTurn'], $_GET['activePage']);
};

$contacts = getContacts();
if (isset($_SESSION['noContacts'])){
	$_POST['noContacts'] = "Please add contacts!";
	unset($_SESSION['noContacts']);
};
