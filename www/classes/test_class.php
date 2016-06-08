<?php

include_once('table.php');
include_once('mysql_driver.php');
include_once('config.php');

class TestClass extends Table
{

	public function delete($contactId)
	{
		
	}
	
	public function insert($contactId)
	{
		
	}
	
	public function select($toSelect)
	{
		$mysqlDriver = new MysqlDriver(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$mysqlDriver->connect();
		$toDo = "SELECT";
		return $mysqlDriver->getArray($toDo, $toSelect, CONTACTS_DB);
	}
	
	public function update($contactId)
	{
		
	}

}

$testClass = new TestClass;
$result = $testClass->select('*');
echo "<pre>", var_dump($result), "</pre>";	//temporary line...



