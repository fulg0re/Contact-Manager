<?php

include_once('functions.php');

if (!$_SESSION['LoggedIn']){
    redirect("index.php");
};