<?php

session_start();

session_destroy();

include_once("includes/functions.php");

redirect("index.php");