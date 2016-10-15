<?php

namespace App\Controllers;

include_once('../App/config.php');

session_start();

use \Core\View;
use \App\Models\Contact;

class Contacts extends Controller
{

	public function postsAction()
	{
		$temp = [
			'sortCol' => (isset($_GET['sortBy'])) ? $_GET['sortBy'] : 'lastname',
			'sortOrd' => (isset($_GET['sortTurn'])) ? $_GET['sortTurn'] : 'DESC',
			'page' => (isset($_GET['activePage'])) ? $_GET['activePage'] : 1,
			'limit' => MAX_ON_PAGE
		];

		$result = $this->modelObj->getContacts($this->modelObj, $temp);

		foreach ($result as $key => $val){
			$this->renderParams[$key] = $val;
		};

		$this->getViewParams();
		View::render('Contacts/index.php', $this->renderParams);	//!!!

		//echo "<pre>", var_dump($_GET), "</pre>";	//temporary line...
	}

	public function addAction()
	{
		if (isset($_POST['button'])){
			$this->renderParams['button'] = $_POST['button'];
		}else{
			$this->renderParams['button'] = 'ADD';
		};

		$this->getViewParams();

		View::render('Contacts/edit.php', $this->renderParams);
	}

	public function editAction($id)
	{
		$temp = [
			'id' => $id
		];

		$result = $this->modelObj->getContacts($this->modelObj, $temp);

		foreach ($result as $key => $val){
			$this->renderParams[$key] = $val;
		};

		$this->getViewParams();

		View::render('Contacts/edit.php', $this->renderParams);

		//echo "<pre>", var_dump($this->renderParams), "</pre>";	//temporary line...
	}

	public function newAction($id)
	{
		$temp = $this->modelObj->newRecord($this->modelObj, $_POST);

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

		//echo "<pre>", var_dump($params), "</pre>";	//temporary line...
	}

	public function deleteAction($id)
	{
		$this->renderParams = $this->modelObj->deleteRecord($this->modelObj, $id);

		$_SESSION['params']['message'] = $this->renderParams['message'];

		$this->redirect("/contacts/posts");

		//echo "<pre>", var_dump($_GET), "</pre>";	//temporary line...
	}

	public function logoutAction()
	{
		$_SESSION['logined'] = false;
		$this->redirect("/");
	}

}
