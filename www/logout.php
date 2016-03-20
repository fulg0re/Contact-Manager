<?php

include_once("controller.php");
include_once("includes/functions.php");

session_destroy();

redirect("index.php");