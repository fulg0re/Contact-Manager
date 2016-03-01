<?php

session_start();

if (!$_SESSION['LoggedIn']){
    header("location: index.php");
}

include_once("includes/functions.php");
include_once("includes/views.php");
include_once("includes/header.php");
include_once("includes/forms.php");

//if(isset($_POST['buttonAdd']))
//{
//    DisplayAddForm();
//}

DisplayAddForm();
