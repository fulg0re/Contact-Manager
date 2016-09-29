<?php

namespace App\Controllers;

include_once('../App/config.php');

session_start();

use \Core\View;
use \App\Models\User;
use \App\Models\Contact;

class Contacts extends Controller
{

	private $renderParams = [];

	public function indexAction()
	{	//http://contactmanager.test/
		$regExp = "/^http:.+test\/$/i";
		if (preg_match($regExp, $_SERVER['HTTP_REFERER'], $matches)){
			$temp = User::login($_POST['username'], $_POST['password']);
		}

		if ($temp['result'] == true){
			$_SESSION['logined'] = true;
			header("location: " . SITE . "contacts/posts");
		}else{
			unset($temp['result']);
			$_SESSION['params'] = $temp;
			header("location: " . SITE);
		};

		//echo "<pre>", var_dump($result), "</pre>";	//temporary line...
	}

	public function postsAction()
	{
		$temp = [
			'sortCol' => (isset($_GET['sortBy'])) ? $_GET['sortBy'] : 'lastname',
			'sortOrd' => (isset($_GET['sortTurn'])) ? $_GET['sortTurn'] : 'DESC',
			'page' => (isset($_GET['activePage'])) ? $_GET['activePage'] : 1,
			'limit' => MAX_ON_PAGE
		];

		$result = Contact::getContacts($temp);

		foreach ($result as $key => $val){
			$this->renderParams[$key] = $val;
		};

		View::render('Contacts/index.php', $this->renderParams);

		//echo "<pre>", var_dump($_GET), "</pre>";	//temporary line...
	}

	public function addAction()
	{
		if (isset($_POST['button'])){
			$_SESSION['params']['button'] = $_POST['button'];
		}
		View::render('Edit/index.php');
	}

	public function editAction()
	{
		$temp = [
			'id' => (isset($_GET['editId'])) ? $_GET['editId'] : ""
		];

		$result = Contact::getContacts($temp);

		echo "<pre>", var_dump($result), "</pre>";	//temporary line...

		foreach ($result as $key => $val){
			$_SESSION['params'][$key] = $val;
		};

		header("location: " . SITE . "contacts/add");

		//echo "<pre>", var_dump($this->renderParams), "</pre>";	//temporary line...
	}

	public function newAction()
	{
		$temp = Contact::newRecord($_POST);

		if ($temp['status'] == false){
			unset($temp['status']);
			$_SESSION['params'] = $temp;

			if (isset($temp['ADDButton'])){
				$_SESSION['params']['button'] = "ADD";
				header("location: " . SITE . "contacts/add");
			}else{
				header("location: " . SITE . "contacts/edit");
			}
			
		}else{
			unset($temp['status']);
			$_SESSION['params'] = $temp;

			header("location: " . SITE . "contacts/posts");
		};

		//echo "<pre>", var_dump($params), "</pre>";	//temporary line...
	}

	public function deleteAction()
	{
		$this->renderParams = Contact::deleteRecord($_GET);

		$_SESSION['params']['message'] = $this->renderParams['message'];

		header("location: " . SITE . "contacts/posts");

		//echo "<pre>", var_dump($_GET), "</pre>";	//temporary line...
	}

	public function logoutAction()
	{
		unset($_SESSION);
		header("location: " . SITE);
	}

}
