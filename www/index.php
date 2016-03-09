<?php
    session_start();

//    var_dump(214234);
//    var_dump("214234");
//    die();   // end of script...

    if (!$_SESSION['LoggedIn']) {
        include_once("includes/forms.php");
        include_once("includes/functions.php");

        if ($_POST['submitted']) {
            if (processLogin($_POST) == true) {
				redirect("lists.php");
            } else {
                displayErrorMassage("Login credentials incorrect!");
                echo "<div class='formDiv'>";
                    displayLoginForm();
                echo "</div>";
            }
        }else{
            echo "<div class='formDiv'>";
                displayLoginForm();
            echo "</div>";
        }
    }else{
		redirect("lists.php");
    }