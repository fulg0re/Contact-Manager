<?php

namespace App\Controllers;

include_once('../App/config.php');

session_start();

use \Core\View;
use \App\Models\Contact;

class Contacts extends Controller
{
	private function prepareTableData($sortBy, $sortTurn, $activePage)
	{
		$temp = [
			'sortCol' => $sortBy,
			'sortOrd' => $sortTurn,
			'page' => $activePage,
			'limit' => MAX_ON_PAGE
		];

		$result = $this->modelObj->getContacts($this->modelObj, $temp);

		foreach ($result as $key => $val){
			$this->renderParams[$key] = $val;
		};

		$this->getViewParams();		
	}

	public function selectionAction()
	{
		$sortBy = (isset($_GET['sortBy'])) ? $_GET['sortBy'] : 'lastname';
		$sortTurn = (isset($_GET['sortTurn'])) ? $_GET['sortTurn'] : 'DESC';
		$activePage = (isset($_GET['activePage'])) ? $_GET['activePage'] : 1;

		$this->prepareTableData($sortBy, $sortTurn, $activePage);

		View::render('Contacts/selection.php', $this->renderParams);
	}

	public function indexAction()
	{
		$sortBy = (isset($_GET['sortBy'])) ? $_GET['sortBy'] : 'lastname';
		$sortTurn = (isset($_GET['sortTurn'])) ? $_GET['sortTurn'] : 'DESC';
		$activePage = (isset($_GET['activePage'])) ? $_GET['activePage'] : 1;

		$this->prepareTableData($sortBy, $sortTurn, $activePage);

		View::render('Contacts/index.php', $this->renderParams);

		//echo "<pre>", var_dump($_GET), "</pre>";	//temporary line...
	}

	public function addAction()
	{
		if (isset($_POST['ADDButton'])){
			$temp = $this->modelObj->newRecord($this->modelObj, $_POST);

			if ($temp['status'] == false){			
				unset($temp['status']);

				$_SESSION['params'] = $temp;
				$_SESSION['params']['button'] = "ADD";
				if ($_SESSION['params']['id'] == ""){
					unset($_SESSION['params']['id']);
				};

				$this->redirect("/contacts/add");
				
			}else{
				unset($temp['status']);
				$_SESSION['params'] = $temp;

				$this->redirect("/contacts");
			};
		}else{
			if (isset($_POST['button'])){
				$this->renderParams['button'] = $_POST['button'];
			}else{
				$this->renderParams['button'] = 'ADD';
			};

			$this->getViewParams();

			View::render('Contacts/edit.php', $this->renderParams);
		}
	}

	public function editAction($id)
	{

		if (isset($_POST['EditButton'])){
			
			$temp = $this->modelObj->newRecord($this->modelObj, $_POST);

			if ($temp['status'] == false){
				unset($temp['status']);

				$_SESSION['params'] = $temp;
				$_SESSION['params']['button'] = "Edit";
				$this->redirect("/contacts/edit/" . $temp['id']);
			}else{
				unset($temp['status']);
				$_SESSION['params'] = $temp;

				$this->redirect("/contacts");
			};
			
		}else{
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

		
	}

	public function deleteAction($id)
	{
		$this->renderParams = $this->modelObj->deleteRecord($this->modelObj, $id);

		$_SESSION['params']['message'] = $this->renderParams['message'];

		$this->redirect("/contacts");

		//echo "<pre>", var_dump($_GET), "</pre>";	//temporary line...
	}

	public function logoutAction()
	{
		$_SESSION['logined'] = false;
		$this->redirect("/");
	}

}
