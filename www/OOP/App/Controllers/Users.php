<?php

namespace App\Controllers;

session_start();

use \Core\View;
use \App\Models\User;

class Users extends Controller
{

	private $userModelObj = [];

	public function __construct()
	{
		$this->userModelObj = new User(
			[
				'host' => DB_HOST, 
				'user'=>DB_USER, 
				'password'=>DB_PASSWORD, 
				'dbName'=>DB_NAME
			], USERS_DB);
	}

	public function indexAction()
	{
		$this->homePage();
	}

	public function loginAction()
	{
		$regExp = "/^http:.+test\/$/i";
		if (preg_match($regExp, $this->getLastUrl(), $matches)){
			$loginMethodParams = [
				'username' => $_POST['username'], 
				'password' =>$_POST['password']
			];

			$temp = $this->userModelObj->login($loginMethodParams);
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
