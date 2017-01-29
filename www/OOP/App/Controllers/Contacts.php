<?php

namespace App\Controllers;

include_once('../App/config.php');

//session_start();

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
		$sortBy = (isset($_GET['sortBy'])) ? $_GET['sortBy'] : '';
		$sortTurn = (isset($_GET['sortTurn'])) ? $_GET['sortTurn'] : '';
		$activePage = (isset($_GET['activePage'])) ? $_GET['activePage'] : 1;

		$this->prepareTableData($sortBy, $sortTurn, $activePage);

		View::render('Contacts/selection.php', $this->renderParams);
	}

	public function indexAction()
	{
		$sortBy = (isset($_GET['sortBy'])) ? $_GET['sortBy'] : 'id';
		$sortTurn = (isset($_GET['sortTurn'])) ? $_GET['sortTurn'] : 'ASC';
		$activePage = (isset($_GET['activePage'])) ? $_GET['activePage'] : 1;

		$this->prepareTableData($sortBy, $sortTurn, $activePage);

		View::render('Contacts/index.php', $this->renderParams);
	}

	public function addAction()
	{

		if ($_SERVER['REQUEST_METHOD'] == 'POST'){

			$temp = $this->modelObj->add($this->modelObj, $_POST);

			if ($temp['status'] == false){
				unset($temp['status']);

				if (isset($temp['params']) && $temp['params']['id'] == ""){
					unset($temp['params']['id']);
				};

				$this->renderParams = $temp;

				View::render('Contacts/add.php', $this->renderParams);

			}else{
				$_SESSION['message'] = $temp['message'];

				$this->redirect("/contacts");
			};

		}else{
			$this->getViewParams();

			View::render('Contacts/add.php', $this->renderParams);
		};
		
	}

	public function editAction($id)
	{

		if ($_SERVER['REQUEST_METHOD'] == 'POST'){

			$temp = $this->modelObj->edit($this->modelObj, $_POST);

			if ($temp['status'] == false){
				unset($temp['status']);

				$this->renderParams = $temp;
				
				View::render('Contacts/edit.php', $this->renderParams);
					
			}else{
				$_SESSION['message'] = $temp['message'];

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

		};
	}

	public function deleteAction($id)
	{
		$this->renderParams = $this->modelObj->deleteRecord($this->modelObj, $id);

		$params = [
			'message' => $this->renderParams['message']
		];
		
		$_SESSION['message'] = $this->renderParams['message'];

		$this->redirect("/contacts");
	}

	public function logoutAction()
	{
		$_SESSION['logined'] = false;
		unset($_SESSION['login']);
		
		$this->redirect("/");
	}

}
