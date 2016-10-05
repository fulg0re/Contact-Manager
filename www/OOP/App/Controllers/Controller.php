<?php

namespace App\Controllers;

use \Core\View;

class Controller extends \Core\Controller
{

	protected function authorizationCheck()
	{
		if ($_SESSION['logined'] != true){
            $_SESSION['params'] = [
                'message' => 'You must login first!'
            ];

			$this->redirect("");
		}else{
            return true;
        }
	}

    protected function homePage($params = [])
    {
        View::render('Users/index.php', $params);
    }

    protected function mainPage($params = [])
    {
        View::render('Contacts/index.php', $params);
    }

    protected function editPage($params = [])
    {
        View::render('Contacts/edit.php', $params);
    }
}
