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
	
	public function query($query)
	{ 
		$this->database->query($query);
	}
	
	public function prepare()
	{
		return $this->database->prepare();
	}
	
	private function allContactsFields()
	{
		return [
			"id", "firstname", "lastname",
			"email", "home_phone", "work_phone",
			"cell_phone", "best_phone", "adress1",
			"adress2", "city", "state",
			"zip", "country", "birthday"];
	}
	
	private function makeAddContactQuery($data)
	{
		$result = " (";
		$allFields = $this->allContactsFields();
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
		$query = "INSERT INTO ".$this->table.$this->makeAddContactQuery($data);
		$this->query($query);
		$res = $this->prepare();
		printf("Inserted contact: ".$res);	//temporary line...
	}

	public function delete($where)
	{
		$query = "DELETE FROM ".$this->table." WHERE ".$where;
		$this->query($query);
		$res = $this->prepare();
		printf("Deleted contact: ".$res);	//temporary line...
	}
	
	private function makeUpdateQuery($data)
	{
		$allFields = $this->allContactsFields();
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
		$this->query($query);
		$res = $this->prepare();
		printf("Updated contact: ".$res);	//temporary line...
	}
	
	public function select($fields, $asParam, $where, $sort_col, $sort_ord, $page, $limit)
	{
		$query = "SELECT ".$fields." ";
		if (isset($asParam)){
			$query .= "AS ".$asParam." ";
		};
		$query .= "FROM ".$this->table." ";
		if (isset($sort_col)){
			$query .= "ORDER BY ".$sort_col." ".$sort_ord." ";
		};
		if (isset($where)){
			$query .= "WHERE ";
		};
		
		/*
		("SELECT * FROM ".CONTACTS_DB." ORDER BY ".$_POST['sortBy']." ".$_POST['sortTurn']." 
		LIMIT ".$offset.", ".$offsetTo);
		
		("SELECT * FROM ".USERS_DB." 
		WHERE username = ? and password = ? Limit 1");
		
		("SELECT * FROM ".CONTACTS_DB." 
		WHERE id = ?");
		
		("SELECT COUNT(*) AS allContacts FROM ".CONTACTS_DB)
		
		*/
	}

}


function getData(){		// temporary function...
	$array = array(
		"firstname" => "bar",
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

$testClass = new TestClass(['host'=>'localhost', 'user'=>'root', 'password'=>'123', 'dbName'=>'contact_manager'], 'contacts');
//$testClass->delete("id=24");		//working...
//$testClass->insert(getData());		//working...
//$testClass->update(getData(), "id=29");		//working...

//echo "<pre>", var_dump($result), "</pre>";	//temporary line...



