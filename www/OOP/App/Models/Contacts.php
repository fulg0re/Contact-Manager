<?php

namespace App\Models;

class Contacts  extends \Core\Core\Table
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
					'message' => 'Email field is required!'
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

		$contacts = new \App\Models\Contacts(['host' => DB_HOST, 'user'=>DB_USER, 
            				'password'=>DB_PASSWORD, 'dbName'=>DB_NAME], 
							CONTACTS_DB);

		$params = [
			'fields' => 'COUNT(*) AS countedFields'
		];

		$allContacts = $contacts->select($params)[0]['countedFields'];
		
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
			$data['sortCol'] = "lastname";
		};
	
		// check URL variable "sortTurn" if correct...
		if (!in_array($data['sortOrd'], [\Core\Core\Table::$asc, \Core\Core\Table::$desc])) {
			$data['sortOrd'] = "ASC";
		};
		
		return $data;
    }
    

}