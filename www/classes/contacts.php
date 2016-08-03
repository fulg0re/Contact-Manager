<?php

include_once('table.php');

class Contacts extends Table
{		
	protected function allFields()
	{
		return [
			"id", "firstname", "lastname",
			"email", "home_phone", "work_phone",
			"cell_phone", "best_phone", "adress1",
			"adress2", "city", "state",
			"zip", "country", "birthday"];
	}
	
	protected function getSortColArray()	// used by method `select`...
	{
		return ['lastname', 'firstname'];
	}

	protected function getSortOrdArray()	// used by method `select`...
	{
		return ['ASC', 'DESC'];
	}

	protected function getOffset($data)	// used by method `select`...
	{
		if (!isset($data['page']) || $data['page'] <= 1){
			return 0;
		};
		$offset = ($data['page']*$data['limit'])-$data['limit'];
				
		$allContacts = $this->selectCount();
		
		// check URL variable "activePage" if correct...getOffset
		if ($offset > $allContacts){
			return 0;
		};
		
		return $offset;
	}
	
	protected function selectValidation($data)	// used by method `select`...
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
		if (!in_array($data['sortOrd'], $this->getSortOrdArray())) {
			$data['sortOrd'] = "ASC";
		};
		
		return $data;
	}
}


function getInsertUpdateData(){		// temporary function...
	$array = array(
		"firstname" => "baaaar",
		"lastname" => "foo",
		"email" => "foo",
		"home_phone" => "foo",
		"work_phone" => "foo",
		"cell_phone" => "foow",
		"best_phone" => "foo",
		"adress1" => "foo",
		"adress2" => "foo",
		"city" => "foo",
		"state" => "foo",
		"zip" => "foo",
		"country" => "foo",
		"birthday" => "foo",
	);
	return $array;
};

function getSelectData(){
	$data = array(
		'fields' => '*',
		
		'sortCol' => 'lastname',
		'sortOrd' => 'DESC',
		'page' => 1,
		'limit' => 5,
		
		'where' => [
			'OR' => [
				'AND' => [
					'id' => 46,
					'lastname' => 'foo'
				],
				'OR' => [
					'id' => 41,
					'lastname' => 'foo'
				],
				/*
				'NOT' => [
					'id' => 37
				]
				*/
			]
		],
		
		'lololo' => 'qweqwe'
	);
	return $data;
};

function getDeleteData(){
	$data= [
		'AND' => [
			'id' => 36
		]
	];
	return $data;
};

function makewhereObj(){
	$temp = [
		'OR' => [
			'OR' =>[
				'AND' => [
					'id' => 5,
					'zip' => 12314
				],
				'OR' => [
					'id' => 6,
					'zip' => 23424
				]
			],
			'AND' =>[
				'id' => 2,
				'firstname' => 'bar'
			],
			'NOT' =>[
				'id' => 20,
				'id2' => 21
			],
		]
	];
	
	return $temp;
};

$testClass = new Contacts(['host'=>'localhost', 'user'=>'root', 'password'=>'123', 'dbName'=>'contact_manager'], 'contacts');

//$testClass->delete(getDeleteData());		//working...
//$testClass->insert(getInsertUpdateData());		//working...
//$testClass->update(getInsertUpdateData(), "id=32");		//working...
/*
$r = $testClass->selectCount();		//working...
echo "<pre>", var_dump($r), "</pre>";	//temporary line...
*/
$testClass->select(getSelectData());		//working...

//echo "<pre>", var_dump($result), "</pre>";	//temporary line...

/*
$resss = $testClass->temp(makewhereObj());		//working...
echo "<pre>", var_dump($resss), "</pre>";	//temporary line...
*/








