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
			$this->database = $database;
			$this->table = $table;
		}else{
			printf("Please enter all parameters!(database and table)...");	//temporary line...
		};
	}

	public function delete($where)
	{
		
	}
	
	public function insert($data)
	{
		
	}
	
	public function select($fields, $where, $sort_col, $sort_ord, $page, $limit)
	{
	/*
		$mysqlDriver = new MysqlDriver(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$mysqlDriver->connect();
		$toDo = "SELECT";
		return $mysqlDriver->getArray($toDo, $toSelect, CONTACTS_DB);
	*/
	}
	
	public function update($data, $where)
	{
		
	}

}

$testClass = new TestClass(DB_NAME, CONTACTS_DB);
$result = $testClass->select('*');
echo "<pre>", var_dump($result), "</pre>";	//temporary line...



