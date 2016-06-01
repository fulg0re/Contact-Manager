<?php

include_once('dbInterface.php');

class MysqlDriver implements dbInterface
{
	private $conn;

	private function connect($dbHost, $dbUser, $dbPassword, dbName)
	{
		$this->conn = new mysqli($dbHost, $dbUser, $dbPassword, dbName);
		
		if ($this->conn->connect_errno) {
			printf("Connect failed: %s\n", $this->conn->connect_error);
			exit();
		}
		
		printf("Connected to DB, nice))");	//temporary line...
	}
	
	private function disconnect()
	{
		mysqli_close($this->conn);
	}
	
	private function query($query)
	{
		
	}
	
	private function getLastInsertId()
	{
		return $this->conn->insert_id;
	}
	
	private function getArray()
	{
		
	}
	
	private function getLastQuery()
	{
		
	}
	
	private function prepare()
	{
		
	}
}

//echo "<pre>", var_dump($mysqlDriver->getOneContact('1')), "</pre>";	//temporary line...








