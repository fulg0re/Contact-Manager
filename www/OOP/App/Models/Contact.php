<?php

namespace App\Models;

class Contact  extends Model
{
	public $fields = [
				'firstname' => [
					'required' => true,
					'message' => 'Firstname field is required!'
				],
				'lastname' => [
					'required' => true,
					'message' => 'Lastname field is required!'
				],
				'email' => [
					'required' => true,
					'message' => 'Email field is required!',
					'rule' => FILTER_VALIDATE_EMAIL,
					'ruleMessage' => 'Wrong \"email\" format!!!'
				],
				'phone' => [
					'isNotEmpty' => [
						'rule' => 'one',	// 'one', 'all'
						'phoneNames' => [
							'home_phone' => '',
							'work_phone' => '',
							'cell_phone' => ''
						],
						'message' => 'Please enter etleast one phone number!!!'
					],
					'best_phone' => [
						'rule' => 'compare',
						'message' => 'Selected phone number is empty!!!',
					]
				],
				'best_phone' => [
					'required' => true,
					'message' => 'Please choose "best phone number"!!!'
				],
				'birthday' => [
					'required' => true,
					'message' => 'Birthday field is required!'
				]
			];
	
	protected function allFields()
    {
		return [
			"id", "firstname", "lastname",
			"email", "home_phone", "work_phone",
			"cell_phone", "best_phone", "adress1",
			"adress2", "city", "state",
			"zip", "country", "birthday"];
    }
	
	protected function getSortColArray()
    {
		return ['lastname', 'firstname'];
    }
	protected function getOffset($data)
    {
		if (!isset($data['page']) || $data['page'] <= 1){
			return 0;
		};
		$offset = ($data['page']*$data['limit'])-$data['limit'];

		$params = [
			'fields' => 'COUNT(*) AS countedFields'
		];

		$allContacts = $this->modelPointObj->select($params)[0]['countedFields'];
		
		// check URL variable "activePage" if correct...getOffset
		if ($offset > $allContacts){
			return 0;
		};
		
		return $offset;
    }
	
	protected function selectValidation($data)
    {
		// seting default data...
		if (!isset($data['sortCol']) 
			|| !isset($data['sortOrd']) 
			|| !isset($data['page']) 
			|| !isset($data['limit'])){
		
			$data['sortCol'] = "id";
			$data['sortOrd'] = "ASC";
			$data['page'] = 1;
			$data['limit'] = 5;
		};
		
		// check URL variable "sortBy" if correct...
		if (!in_array($data['sortCol'], $this->getSortColArray())) {
			$data['sortCol'] = "id";
		};
	
		// check URL variable "sortTurn" if correct...
		if (!in_array($data['sortOrd'], [\Core\Models\Table::$asc, \Core\Models\Table::$desc])) {
			$data['sortOrd'] = "ASC";
		};
		
		return $data;
    }

	public function getContactsAction($params)
	{
		// START - if new to get one contact only...
		if (isset($params['id'])){
			$queryParams = [
				'fields' => '*',
				'where' => [
					'id' => $params['id']
				]
			];

			if ($temp = $this->modelPointObj->select($queryParams)){
				foreach ($temp[0] as $key => $val){
					$result[$key] = $val;
				};
			};

			$result['button'] = "Edit";

			return $result;
		};
		// END - if new to get one contact only...

		$queryParams = [
			'fields' => 'COUNT(*) AS countedFields'
		];

		$numberOfAllFields = $this->modelPointObj->select($queryParams)[0]['countedFields'];
			
		$queryParams = [
			'fields' => '*'
		];

		$queryParams += $params;

		$result = [
			'contacts' => $this->modelPointObj->select($queryParams),
			'numberOfAllFields' => $numberOfAllFields,
			'activePage' => $params['page'],
			'sortBy' => $params['sortCol'],
			'sortTurn' => $params['sortOrd'],
			'maxOnPage' => $params['limit']
		];

		return $result;		
	}

	public function newRecordAction($params)
	{
		foreach ($params as $key => $val){
			$result[$key] = $val;
		};

		$result['status'] = false;

		if (isset($params['EditButton'])){
			$queryParams = [
				'fields' => '*',
				'where' => [
					'id' => $params['id']
				]
			];

			if ($temp = $this->modelPointObj->select($queryParams)){
				$noMatch = 0;
				foreach ($temp[0] as $key => $val){
					if ($val != $params[$key]){
						$noMatch++;
					}
				};

				if ($noMatch == 0){
					$result['matched'] = true;
					$result['message'] = "Record(s) has not been changed!";
				}else{
					$result['matched'] = false;

					foreach ($params as $key => $val){
						if ($key != "EditButton" && $key != "id"){
							$queryParams[$key] = $val;
						};
					};

					$res = $this->modelPointObj->update($queryParams, "id=".$params['id']);
					if (is_numeric($res)){
						$result['message'] = "Updated ".$res." record(s).";	// all good...
					}else{
						$result['message'] = $res;	// error updateing contact...
						return $result;
					};
				}
			};
		}elseif (isset($params['ADDButton'])){
			foreach ($params as $key => $val){
				if ($key != "ADDButton" && $key != "id"){
					$queryParams[$key] = $val;
				};
			};

			$res = $this->modelPointObj->insert($queryParams);
			if (is_numeric($res)){
				$result['message'] = "Inserted ".$res." record(s).";	// all good...
			}else{
				$result['message'] = $res; // error inserting contact...
				return $result;
			};
		};

		$result['status'] = true;
		return $result;
		
	}

	public function deleteRecordAction($id)
	{
		$queryParams = [
			'id' => $id
		];

		//echo "<pre>", var_dump($queryParams), "</pre>";	//temporary line...

		$result['message'] = $this->modelPointObj->delete($queryParams);

		return $result;
	}

}