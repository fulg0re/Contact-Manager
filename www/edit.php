<?php

session_start();

if (!$_SESSION['LoggedIn']){
	redirect("index.php");
}else{
	include_once("includes/functions.php");
	include_once("includes/forms.php");	
};

//if(isset($_POST['buttonAdd']))
//{
//    DisplayAddForm();
//}
	{		
        if ($_POST['submitted']) {
            if (processAddContact($_POST) == true) {
				displayMassage("Data was successfully added");
            } else {
                displayMassage("Error adding data!");
			}
			echo "<div class='formDiv'>";
				displayAddForm();
			echo "</div>";
        }else{
            echo "<div class='formDiv'>";
                displayAddForm();
            echo "</div>";
        }
    };
