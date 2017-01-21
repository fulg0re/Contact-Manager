<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

class Users extends Controller
{

	public function indexAction()
	{
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			
			$result = $this->authAction();

			if ($result['result'] == true){
				$_SESSION['logined'] = true;
				$_SESSION['login'] = $_POST['username'];
				$this->redirect("/contacts");
			}else{
				unset($result['result']);
				$this->renderParams = $result;

				View::render('Users/index.php', $this->renderParams);
			};
			
		}else{
			$this->getViewParams();
			
			View::render('Users/index.php', $this->renderParams);
		}
		
	}

	private function authAction()
	{
		$loginMethodParams = [
			'username' => $_POST['username'],
			'password' =>$_POST['password']
		];

		return $this->modelObj->login($this->modelObj, $loginMethodParams);
	}

}
