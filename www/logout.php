<?php

session_start();

session_destroy();

include_once("includes/functions.php");
include_once("includes/forms.php");

redirect("index.php");