<?php

include_once('../includes/config.php');
include_once('dbInterface.php');

class MysqlDriver implements dbInterface
{
	private $conn;

	function __construct()
	{
		$this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		if ($this->conn->connect_errno) {
			printf("Connect failed: %s\n", $this->conn->connect_error);
			exit();
		}
		
		printf("Connected to DB, nice))");	//temporary line...
	}
/*
	public function getOneContact($contactId)
	{
		$stmt = $this->conn->prepare("SELECT * FROM ".CONTACTS_DB." WHERE id = ?");
		
		$stmt->bind_param("s", $contactId);

		$stmt->execute();

		$res = $stmt->get_result();

		if ($res->num_rows > 0){
			while ($row = $res->fetch_assoc()){
				foreach($row as $key => $val){
					$result[$key] = $val;
				};
			};
			$stmt->close();
			return $result;
		};

		$stmt->close();
		return false;
	}
*/
}

$mysqlDriver = new MysqlDriver;

//echo "<pre>", var_dump($mysqlDriver->getOneContact('1')), "</pre>";	//temporary line...








