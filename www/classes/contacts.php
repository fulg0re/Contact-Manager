<?php

include_once('table.php');

class Contacts extends Table
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
				],
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
	
	protected function getSortColArray()	// used by method `select`...
	{
		return ['lastname', 'firstname'];
	}
/*
	protected function getSortOrdArray()	// used by method `select`...
	{
		return ['ASC', 'DESC'];
	}
*/
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
		if (!in_array($data['sortOrd'], [Table::$asc, Table::$desc])) {
			$data['sortOrd'] = "ASC";
		};
		
		return $data;
	}
}


function getInsertUpdateData(){		// temporary function...
	$array = array(
		"firstname" => "Oleh",
		"lastname" => "Kolos",
		"email" => "oleh.k@gmail.com",
		"home_phone" => "383083",
		"work_phone" => "581411",
		"cell_phone" => "0974515035",
		"best_phone" => "cell_phone",
		"adress1" => "Ternopil1",
		"adress2" => "Ternopil2",
		"city" => "Ternopil3",
		"state" => "Ternopil4",
		"zip" => "45014",
		"country" => "Ukraine",
		"birthday" => "17-05-1989",
	);
	return $array;
};

function getSelectData(){
	$data = [
		'fields' => '*',
		
		'sortCol' => 'lastname',
		'sortOrd' => 'DESC',
		'page' => 1,
		'limit' => 5,
		
		'where' => [
			'OR' => [
				'AND' => [
					'lastname' => 'Denys',
					'home_phone' => '289083'
				],
				'OR' => [
					'lastname' => 'Miha',
					'home_phone' => '283083'
				]
			]
		],
		
		'lololo' => 'qweqwe'
	];
	return $data;
};

function getDeleteData(){
	$data= [
		'AND' => [
			'id' => 60
		]
	];
	return $data;
};

function makewhereObj(){

	$temp = [
		'OR' => [
			'AND' => [
				'lastname' => 'Denys',
				'home_phone' => '289083'
			],
			'OR' => [
				'lastname' => 'Miha',
				'home_phone' => '283083'
			]
		]
	];
	
	/*
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
	*/
	return $temp;
};

$testClass = new Contacts(['host'=>'localhost', 'user'=>'root', 'password'=>'123', 'dbName'=>'contact_manager'], 'contacts');

//**********************DELETE**********************
/*
$temp = $testClass->delete(getDeleteData());		//working...
echo "<pre>", var_dump($temp), "</pre>";	//temporary line...
*/
//**************************************************



//**********************INSERT**********************
/*
$temp = $testClass->insert(getInsertUpdateData());		//working...
echo "<pre>", var_dump($temp), "</pre>";	//temporary line...
*/
//**************************************************



//**********************UPDATE**********************
/*
$temp = $testClass->update(getInsertUpdateData(), "id=61");		//working...
echo "<pre>", var_dump($temp), "</pre>";	//temporary line...
*/
//**************************************************



//**********************SELECT_COUNT*****************
/*
$temp = $testClass->selectCount();		//working...
echo "<pre>", var_dump($temp), "</pre>";	//temporary line...
*/
//**************************************************



//**********************SELECT***********************
/*
$temp = $testClass->select(getSelectData());		//working...
echo "<pre>", var_dump($temp), "</pre>";	//temporary line...
*/
//**************************************************



//echo "<pre>", var_dump($result), "</pre>";	//temporary line...

/*
$resss = $testClass->makeWhere(makewhereObj());		//working...
echo "<pre>", var_dump($resss), "</pre>";	//temporary line...
*/

/*
$temp = $testClass->insertValidation(['firstname'=>'qwe', 
		'lastname'=>'asd', 'email'=>'afsdf@sdfs.swef', 'birthday'=>'wer',
		'home_phone'=>'654', 'best_phone'=>'home_phone']);
echo "<pre>", var_dump($temp), "</pre>";	//temporary line...
*/


