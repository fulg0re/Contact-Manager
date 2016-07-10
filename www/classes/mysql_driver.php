<?php

include_once('db_interface.php');

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
			$this->dbConnection = new mysqli(
				$this->dbHost, $this->dbUser, $this->dbPassword, $this->dbName);
		}else{
			printf("Already connected to DB!");	//temporary line...
		};
		
		if ($this->dbConnection->connect_errno) {
			printf("Connect failed: %s\n", $this->dbConnection->connect_error);
			exit();
		};
		
		printf("Connected to DB, nice))");	//temporary line...
	}
	
	public function disconnect()
	{
		if (!$this->dbConnection){
			printf("There is no connection...");	//temporary line...
		}else{
			$this->dbConnection->close();
			printf("Disconnected, nice))");	//temporary line...
		};
	}
	
	public function query($query)
	{
		$this->lastQuery = $query;
		//echo "<pre>", var_dump($query), "</pre>";	//temporary line...
		$this->preparedDBConnection = $this->dbConnection->prepare($this->lastQuery);
			
		return ($this->preparedDBConnection->execute()) ? true : false;
	}
	
	public function getNumRows()
	{
		
	}
	
	public function getLastInsertId()
	{
		return $this->dbConnection->insert_id;
	}
	
	public function getArray()
	{
		$res = $this->preparedDBConnection->get_result();
		
		if ($res->num_rows > 0){
			$i = 0;
			while ($row = $res->fetch_assoc()){
				$result[$i] = $row;
				$i++;
			};

			$this->preparedDBConnection->close();
			
			return $result;

		};
		return false;
	}
	
	public function getLastQuery()
	{
		return $this->lastQuery;
	}
}

//$temp = new MysqlDriver("localhost", "root", "123", "contact_manager");
//$temp->connect();
//echo "<pre>", var_dump($mysqlDriver->getOneContact('1')), "</pre>";	//temporary line...








