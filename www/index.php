<?php
    session_start();

//    var_dump(214234);
//    var_dump("214234");
//    die();   // end of script...

    if (!$_SESSION['LoggedIn']) {
        include_once("includes/forms.php");
        include_once("includes/functions.php");

        if ($_POST['submitted']) {
            if (ProcessLogin($_POST) == true) {
                header("location: lists.php");
            } else {
                include_once("./includes/header.php");
                DisplayErrorMassage("Login credentials incorrect!");
                echo "<div class='formDiv'>";
                    DisplayLoginForm();
                echo "</div>";
            }
        }else{
            include_once("./includes/header.php");
            echo "<div class='formDiv'>";
                DisplayLoginForm();
            echo "</div>";
        }
    }else{
        header("location: lists.php");
    }