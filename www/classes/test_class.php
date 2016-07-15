<?php

include_once('table.php');
include_once('mysql_driver.php');
include_once('config.php');

class TestClass extends Table
{
	
	private $database;
	private $table;
	
	function __construct($database, $table)
	{
		if (isset($database) && isset($table)){
			$this->database = new MysqlDriver(
					$database['host'], $database['user'], $database['password'], $database['dbName']);
			$this->database->connect();
			$this->table = $table;
		}else{
			printf("Please enter all parameters!(database and table)...");	//temporary line...
		};
	}
	
	private function query($query)
	{ 
		return $this->database->query($query);
	}
	
	private function getArray()
	{
		return $this->database->getArray();
	}
	
	private function getLastInsertId()
	{
		return $this->database->getLastInsertId();
	}
	
	private function getNumRows()
	{
		return $this->database->getNumRows();
	}
	
	private function allFields()
	{
		return [
			"id", "firstname", "lastname",
			"email", "home_phone", "work_phone",
			"cell_phone", "best_phone", "adress1",
			"adress2", "city", "state",
			"zip", "country", "birthday"];
	}
	
	private function makeInsertQuery($data)	// used by method `insert`...
	{
		$result = " (";
		$allFields = $this->allFields();
		$allFields = array_merge(array_diff($allFields, array("id")));	//without "id" field...	
		$result .= join(', ', $allFields);
		$result .= ") VALUES ('";
		$temp;
		$i = 0;
		while($i < count($allFields)){
			$temp[$i] = $data[$allFields[$i]];
			$i++;
		};
		$result .= join("', '", $temp);
		$result .= "')";
		return $result;
	}
	
	public function insert($data)
	{
		$query = "INSERT INTO ".$this->table.$this->makeInsertQuery($data);
		if ($this->query($query)){
			printf("Inserted contact: ".$res);	//temporary line...
		};
	}

	public function delete($where)
	{
		$query = "DELETE FROM ".$this->table." WHERE ".$where;
		if ($this->query($query)){
			printf("Deleted contact: ".$res);	//temporary line...
		};
	}
	
	private function makeUpdateQuery($data)	// used by method `update`...
	{
		$allFields = $this->allFields();
		$allFields = array_merge(array_diff($allFields, array("id")));	//without "id" field...	
		$temp;
		for ($i=0; $i < count($allFields); $i++){
			$temp[$i] = $allFields[$i]."='".$data[$allFields[$i]]."'";
		};
		return join(", ", $temp);
	}
	
	public function update($data, $where)
	{
		$query = "UPDATE ".$this->table." SET ".$this->makeUpdateQuery($data)." WHERE ".$where;
		if ($this->query($query)){
			printf("Updated contact: ");	//temporary line...
		};
	}
	
	private function getSortColArray()	// used by method `select`...
	{
		return ['lastname', 'firstname'];
	}

	private function getSortOrdArray()	// used by method `select`...
	{
		return ['ASC', 'DESC'];
	}
	
	private function selectValidation($data)	// used by method `select`...
	{
		// seting default data...
		if (!isset($data['sortCol']) 
			|| !isset($data['sortOrd']) 
			|| !isset($data['page']) 
			|| !isset($data['limit'])){
		
			$data['sortCol'] = "lastname";
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

	//	input data: $data['fields'], $data['sortCol'], $data['sortOrd'], 
	//				$data['page'], $data'[limit'], $data['whereAndChoise'], 
	//				$data['whereOrChoise']
	public function select($data)
	{
		$data['offset'] = $this->getOffset($data);
		
		$data = $this->selectValidation($data);
	
		// making WHERE... part
		$_where = $this->getWhere($data);		
		
		$query = sprintf(
			"SELECT %s FROM %s WHERE %s ORDER BY %s %s LIMIT %d, %d",
			$data['fields'], $this->table, $_where,
			$data['sortCol'], $data['sortOrd'],
			$data['offset'], $data['limit']
		);
		
		//echo "<pre>", var_dump($query), "</pre>";	//temporary line...
		
		if ($this->query($query)){
			$res = $this->getArray();
			echo "<pre>", var_dump($res), "</pre>";	//temporary line...
		};
	}
	
	public function selectCount()
	{
		$query = "SELECT COUNT(*) AS allContacts FROM ".$this->table;
		if ($this->query($query)){
			$result = $this->getArray();
			return $result[0]['allContacts'];
		};
	}

}


function getData(){		// temporary function...
	$array = array(
		"firstname" => "bareeee",
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
		'page' => 0,
		'limit' => 5,
		/*
		'whereAndChoise' => array(
			'id' => 1,
			'lastname' => 'Denys'
		),
		*/
		
		'whereOrChoise' => [
			'id' => 1234,
			'lastname' => 'Denys'
		],
		
		'lololo' => 'qweqwe'
	);
	return $data;
};

$testClass = new TestClass(['host'=>'localhost', 'user'=>'root', 'password'=>'123', 'dbName'=>'contact_manager'], 'contacts');
//$testClass->delete("id=28");		//working...
//$testClass->insert(getData());		//working...
//$testClass->update(getData(), "id=29");		//working...
//$testClass->selectCount();		//working...
$testClass->select(getSelectData());		//working...

//echo "<pre>", var_dump($result), "</pre>";	//temporary line...



