<?php

namespace App\Controllers;

include_once('../App/config.php');

session_start();

use \Core\View;
//use \App\Models\User;
use \App\Models\Contact;

class Contacts extends Controller
{

	//private $userModelObj = [];
	private $contactModelObj = [];
	private $renderParams = [];

	public function __construct()
	{
		/*
		$this->userModelObj = new User(
			[
				'host' => DB_HOST, 
				'user'=>DB_USER, 
				'password'=>DB_PASSWORD, 
				'dbName'=>DB_NAME
			], USERS_DB);
		*/
		$this->contactModelObj = new Contact(
			[
				'host' => DB_HOST, 
				'user'=>DB_USER, 
				'password'=>DB_PASSWORD, 
				'dbName'=>DB_NAME
			], CONTACTS_DB);
	}

	public function indexAction()
	{	//http://contactmanager.test/
	/*
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
*/
		//echo "<pre>", var_dump($result), "</pre>";	//temporary line...
	}

	public function postsAction()
	{
		if ($this->authorizationCheck()){
			$temp = [
				'sortCol' => (isset($_GET['sortBy'])) ? $_GET['sortBy'] : 'lastname',
				'sortOrd' => (isset($_GET['sortTurn'])) ? $_GET['sortTurn'] : 'DESC',
				'page' => (isset($_GET['activePage'])) ? $_GET['activePage'] : 1,
				'limit' => MAX_ON_PAGE
			];

			$result = $this->contactModelObj->getContacts($temp);

			foreach ($result as $key => $val){
				$this->renderParams[$key] = $val;
			};

			$this->mainPage($this->renderParams);
		};

		//echo "<pre>", var_dump($_GET), "</pre>";	//temporary line...
	}

	public function addAction()
	{
		if ($this->authorizationCheck()){
			if (isset($_POST['button'])){
				$_SESSION['params']['button'] = $_POST['button'];
			}
			$this->editPage();
		};
	}

	public function editAction($id)
	{
		if ($this->authorizationCheck()){
			$temp = [
				'id' => $id
			];

			$result = $this->contactModelObj->getContacts($temp);

			foreach ($result as $key => $val){
				$_SESSION['params'][$key] = $val;
			};

			$this->editPage();
		};

		//echo "<pre>", var_dump($this->renderParams), "</pre>";	//temporary line...
	}

	public function newAction($id)
	{
		if ($this->authorizationCheck()){
			$temp = $this->contactModelObj->newRecord($_POST);

			if ($temp['status'] == false){
				unset($temp['status']);
				$_SESSION['params'] = $temp;

				if (isset($temp['ADDButton'])){
					$_SESSION['params']['button'] = "ADD";
					$this->redirect("/contacts/add");
				}else{
					$this->redirect("/contacts/" . $id . "/edit");
				}
				
			}else{
				unset($temp['status']);
				$_SESSION['params'] = $temp;

				$this->redirect("/contacts/posts");
			};
		};

		//echo "<pre>", var_dump($params), "</pre>";	//temporary line...
	}

	public function deleteAction($id)
	{
		if ($this->authorizationCheck()){
			$this->renderParams = $this->contactModelObj->deleteRecord($id);

			$_SESSION['params']['message'] = $this->renderParams['message'];

			$this->redirect("/contacts/posts");
		};

		//echo "<pre>", var_dump($_GET), "</pre>";	//temporary line...
	}

	public function logoutAction()
	{
		$_SESSION['logined'] = false;
		$this->redirect("/");
	}

}
