<?php

namespace App\Controllers;

include_once('../App/config.php');

use \Core\View;

class Contacts extends \Core\Controller
{

	private $renderParams = [];

	private function generatePassword($pass)
	{
		return sha1($pass);
	}

	public function indexAction()
	{
		$login = new \App\Models\Login(['host' => DB_HOST, 'user'=>DB_USER, 
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
			$this->postsAction();
		}else{
			$this->renderParams['message'] = 'Wrong username or password!!!';
			$this->renderParams['username'] = $_POST['username'];
			$this->renderParams['password'] = $_POST['password'];

			View::render('Home/index.php', $this->renderParams);
		};

		//echo "<pre>", var_dump($result), "</pre>";	//temporary line...
	}

	public function postsAction()
	{
		$contacts = new \App\Models\Contacts(['host' => DB_HOST, 'user'=>DB_USER, 
            				'password'=>DB_PASSWORD, 'dbName'=>DB_NAME], 
							CONTACTS_DB);

		$params = [
			'fields' => 'COUNT(*) AS countedFields'
		];

		$numberOfAllFields = $contacts->select($params)[0]['countedFields'];
			
		$params = [
			'fields' => '*',
			'sortCol' => (isset($_GET['sortBy'])) ? $_GET['sortBy'] : 'lastname',
			'sortOrd' => (isset($_GET['sortTurn'])) ? $_GET['sortTurn'] : 'DESC',
			'page' => (isset($_GET['activePage'])) ? $_GET['activePage'] : 1,
			'limit' => MAX_ON_PAGE
		];

		$this->renderParams['contacts'] = $contacts->select($params);
		$this->renderParams['numberOfAllFields'] = $numberOfAllFields;
		$this->renderParams['activePage'] = (isset($_GET['activePage'])) ? $_GET['activePage'] : 1;
		$this->renderParams['sortBy'] = (isset($_GET['sortBy'])) ? $_GET['sortBy'] : 'lastname';
		$this->renderParams['sortTurn'] = (isset($_GET['sortTurn'])) ? $_GET['sortTurn'] : 'DESC';
		$this->renderParams['maxOnPage'] = MAX_ON_PAGE;
		//echo "<pre>", var_dump($result), "</pre>";	//temporary line...

		View::render('Contacts/index.php', $this->renderParams);

		//echo "<pre>", var_dump($_GET), "</pre>";	//temporary line...
	}

	public function addAction()
	{
		$this->renderParams['button'] = "ADD";

		//echo "<pre>", var_dump($this->renderParams), "</pre>";	//temporary line...

		View::render('Edit/index.php', $this->renderParams);
	}

	public function editAction()
	{
		$contacts = new \App\Models\Contacts(['host' => DB_HOST, 'user'=>DB_USER, 
            				'password'=>DB_PASSWORD, 'dbName'=>DB_NAME], 
							CONTACTS_DB);

		$params = [
			'fields' => '*',
			'where' => [
				'id' => (isset($_GET['editId'])) ? $_GET['editId'] : ""
			]
		];

		if ($res = $contacts->select($params)){
			foreach ($res[0] as $key => $val){
				$this->renderParams[$key] = $val;
			};
		};

		$this->renderParams['button'] = "Edit";

		//echo "<pre>", var_dump($this->renderParams), "</pre>";	//temporary line...

		View::render('Edit/index.php', $this->renderParams);
	}

	public function newAction()
	{
		$contacts = new \App\Models\Contacts(['host' => DB_HOST, 'user'=>DB_USER, 
            				'password'=>DB_PASSWORD, 'dbName'=>DB_NAME], 
							CONTACTS_DB);
		
		foreach ($_POST as $key => $val){
				$this->renderParams[$key] = $val;
			};

		if (isset($_POST['EditButton'])){
			foreach ($_POST as $key => $val){
				if ($key != "EditButton" && $key != "id"){
					$params[$key] = $val;
				};
			};

			$this->renderParams['message'] = $contacts->update($params, "id=".$_POST['id']);			
		}elseif (isset($_POST['ADDButton'])){
			foreach ($_POST as $key => $val){
				if ($key != "ADDButton" && $key != "id"){
					$params[$key] = $val;
				};
			};
			
			$result = $contacts->insert($params);
			if (is_numeric($result)){
				$this->renderParams['message'] = "Inserted ".$result." record(s).";
			}else{
				$this->renderParams['message'] = $result;
				$this->addAction();
				return false;
			};
			
		};
		
		$this->postsAction();

		//echo "<pre>", var_dump($params), "</pre>";	//temporary line...
	}

	public function deleteAction()
	{
		$contacts = new \App\Models\Contacts(['host' => DB_HOST, 'user'=>DB_USER, 
            				'password'=>DB_PASSWORD, 'dbName'=>DB_NAME], 
							CONTACTS_DB);
		
		$params = [
			'id' => $_GET['deleteId']
		];

		$this->renderParams['message'] = $contacts->delete($params);

		$this->postsAction();

		//echo "<pre>", var_dump($_GET), "</pre>";	//temporary line...
	}

	public function logoutAction()
	{
		View::render('Home/index.php');
	}

}
