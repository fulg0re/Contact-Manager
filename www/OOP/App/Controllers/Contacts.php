<?php

namespace App\Controllers;

include_once('../App/config.php');

use \Core\View;
use \App\Models\User;
use \App\Models\Contact;

class Contacts extends \Core\Controller
{

	private $renderParams = [];

	public function indexAction()
	{	//http://contactmanager.test/
		$regExp = "/^http:.+test\/$/i";
		if (preg_match($regExp, $_SERVER['HTTP_REFERER'], $matches)){
			$this->renderParams = User::login($_POST['username'], $_POST['password']);
		}

		if ($this->renderParams['result'] == true){
			$this->postsAction();
		}else{
			View::render('Home/index.php', $this->renderParams);
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
		$this->renderParams['button'] = "ADD";

		View::render('Edit/index.php', $this->renderParams);
	}

	public function editAction()
	{
		$temp = [
			'id' => (isset($_GET['editId'])) ? $_GET['editId'] : ""
		];

		$result = Contact::getContacts($temp);

		foreach ($result as $key => $val){
			$this->renderParams[$key] = $val;
		};

		View::render('Edit/index.php', $this->renderParams);

		//echo "<pre>", var_dump($this->renderParams), "</pre>";	//temporary line...
	}

	public function newAction()
	{
		$temp = Contact::newRecord($_POST);

		if ($temp['status'] == false){
			unset($temp['status']);
			$this->renderParams = $temp;

			if (isset($temp['ADDButton'])){
				$this->addAction();
			}else{
				$_GET['editId'] = $temp['id'];
				$this->editAction();
			}
		}else{
			unset($temp['status']);
			$this->renderParams = $temp;
			$this->postsAction();
		};

		//echo "<pre>", var_dump($params), "</pre>";	//temporary line...
	}

	public function deleteAction()
	{
		$this->renderParams = Contact::deleteRecord($_GET);

		$this->postsAction();

		//echo "<pre>", var_dump($_GET), "</pre>";	//temporary line...
	}

	public function logoutAction()
	{
		//$this->renderParams['beck'] = true;
		View::render('Home/index.php', $this->renderParams);
	}

}
