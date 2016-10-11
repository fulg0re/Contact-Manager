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

		$this->homePage($this->renderParams);
	}

	public function loginAction()
	{
		
		$regExp = "/^http:.+test\/$/i";
		if (preg_match($regExp, $this->getLastUrl(), $matches)){
			$loginMethodParams = [
				'username' => $_POST['username'], 
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
