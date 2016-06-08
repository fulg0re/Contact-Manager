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
	
	function __construct($host, $user, $password, $name)
	{
		$this->dbHost = $host;
		$this->dbUser = $user;
		$this->dbPassword = $password;
		$this->dbName = $name;
	}

	public function connect()
	{
		$this->dbConnection = new mysqli(
			$this->dbHost, $this->dbUser, $this->dbPassword, $this->dbName);
		
		if ($this->dbConnection->connect_errno) {
			printf("Connect failed: %s\n", $this->dbConnection->connect_error);
			exit();
		}
		
		printf("Connected to DB, nice))");	//temporary line...
	}
	
	public function disconnect()
	{
		if (mysqli_close($this->dbConnection)){
			return true;
		};
		return false;
	}
	
	public function query($toDo, $whotToDo, $Table)
	{
		$this->lastQuery = $toDo." ".$whotToDo." FROM ".$Table;
		return true;
	}
	
	public function getLastInsertId()
	{
		return $this->dbConnection->insert_id;
	}
	
	public function getArray($toDo, $whotToDo, $Table)
	{
		switch ($toDo) {
			case "SELECT":
				if ($this->query($toDo, $whotToDo, $Table) == true){
					if (($result = $this->prepare(null)) != false){
						return $result;
					}else{
						//make error message...
					};
				}else{
					//make error message...
				};
				break;
		};
		
		
		// bind results, and get results from query...
	}
	
	public function getLastQuery()
	{
		return $this->lastQuery;
	}
	
	public function prepare($numberOfVariables)
	{
		if ($numberOfVariables == null){
			$this->preparedDBConnection = $this->dbConnection->prepare($this->lastQuery);
			
			$this->preparedDBConnection->execute();

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

			$this->preparedDBConnection->close();
			return false;
		}else{
			
		};
	}
}

//$temp = new MysqlDriver("localhost", "root", "123", "contact_manager");
//$temp->connect();
//echo "<pre>", var_dump($mysqlDriver->getOneContact('1')), "</pre>";	//temporary line...








