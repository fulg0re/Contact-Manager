<?php

namespace Core\Core;

include_once('db_interface.php');

use mysqli;

class MysqlDriver implements dbInterface
{
	private $dbConnection;
	private $preparedDBConnection;
	private $dbHost;
	private $dbUser;
	private $dbPassword;
	private $dbName;
	private $lastQuery;
	private $result;
	
	function __construct($host, $user, $password, $name)
	{
		$this->dbHost = $host;
		$this->dbUser = $user;
		$this->dbPassword = $password;
		$this->dbName = $name;
	}
	public function connect()
	{
		if (!$this->dbConnection){
			$this->dbConnection = new mysqli($this->dbHost, $this->dbUser, $this->dbPassword, $this->dbName);
		}else{
			return "Already connected to DB!";
		};
		
		if ($this->dbConnection->connect_errno) {
			return ("Connect failed: %s\n".$this->dbConnection->connect_error);
			exit();
		};
		
		return "Connected to DB, nice))";
	}
	
	public function disconnect()
	{
		if (!$this->dbConnection){
			return "There is no connection...";
		}else{
			$this->dbConnection->close();
			return "Disconnected, nice))";
		};
	}

	private function getTypeQuery($query)
	{
		$type = explode(' ',$query);

		// for SELECT COUNT query...
		if ($type[0] == "SELECT" && $type[1] == "COUNT"){
			return $type[1];
		};

		return $type[0];
	}
	
	public function query($query)
	{
		$this->lastQuery = $query;
		echo "<pre>", var_dump($query), "</pre>";	//temporary line...
		$this->preparedDBConnection = $this->dbConnection->prepare($this->lastQuery);
		//echo "<pre>", var_dump($this->lastQuery), "</pre>";	//temporary line...
		
		$queryType = $this->getTypeQuery($query);

		return ($this->preparedDBConnection->execute())
					? ($queryType == 'SELECT')
						? ($queryType == 'COUNT')
							? $this->getNumRows()
							: $this->getArray()
						: $this->getNumRows()
					: false;

/*
		return ($this->preparedDBConnection->execute())
					? (strpos($query, 'SELECT') !== false)
						? (strpos($query, 'COUNT') !== false)
							? $this->getNumRows()
							: $this->getArray()
						: $this->getNumRows()
					: false;
*/
	}
	
	public function getNumRows()
	{
		//var_dump("this is getNumRows()...");
		return $this->preparedDBConnection->affected_rows;
	}
	
	public function getLastInsertId()
	{
		return $this->dbConnection->insert_id;
	}
	
	public function getArray()
	{
		//var_dump("this is getArray()...");
		$result = false;
		$res = $this->preparedDBConnection->get_result();
		if ($res->num_rows > 0){
			$result = [];
			while ($row = $res->fetch_assoc()){
				array_push($result, $row);
			};
		};
		$this->preparedDBConnection->close();			
		return $result;
	}
	
	public function getLastQuery()
	{
		return $this->lastQuery;
	}
}
//$temp = new MysqlDriver("localhost", "root", "123", "contact_manager");
//$temp->connect();
//echo "<pre>", var_dump($mysqlDriver->getOneContact('1')), "</pre>";	//temporary line...
