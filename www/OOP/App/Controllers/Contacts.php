<?php

namespace App\Controllers;

include_once('../App/config.php');

use \Core\View;
use App\Controllers;
use App\Models\Login;

class Contacts extends \Core\Controller
{

	public function indexAction()
	{
	}

	private function generatePassword($pass)
	{
		return sha1($pass);
	}

	public function loginAction()
	{
		$login = new Login(['host' => DB_HOST, 'user'=>DB_USER, 
            				'password'=>DB_PASSWORD, 'dbName'=>DB_NAME], 
							USERS_DB);

		$sha1Password = $this->generatePassword($_POST['password']);

		$params = [
			'fields' => '*',
			'where' => [
				'username' => $_POST['username'],
				'password' => $sha1Password
			]
		];

		if ($login->select($params)){
			View::render('Contacts/index.php');
		}else{
			View::render('Home/index.php', [
				'message' => 'Wrong username or password!!!',
				'username' => $_POST['username'],
				'password' => $_POST['password']
				]);
		};

		//echo "<pre>", var_dump($result), "</pre>";	//temporary line...
	}

	public function logoutAction()
	{
		View::render('Home/index.php');
	}

}
