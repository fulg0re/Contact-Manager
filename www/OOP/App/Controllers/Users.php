<?php

namespace App\Controllers;

session_start();

use \Core\View;
use \App\Models\User;

class Users extends Controller
{

	public function indexAction()
	{
		$this->getViewParams();

		View::render('Users/index.php', $this->renderParams);
	}

	public function loginAction()
	{
		
		$regExp = "/^http:.+\/$/i";
		if (preg_match($regExp, $this->getLastUrl(), $matches)){
			$loginMethodParams = [
				'username' => $_POST['username'], 	//@todo add to $_SESIONS...
				'password' =>$_POST['password']
			];

			$temp = $this->modelObj->login($this->modelObj, $loginMethodParams);
		}

		if ($temp['result'] == true){
			$_SESSION['logined'] = true;
			$this->redirect("/contacts/posts");
		}else{
			unset($temp['result']);
			$_SESSION['params'] = $temp;
			$this->redirect("/");
		};
		
	}

}
