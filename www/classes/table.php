<?php
include_once('mysql_driver.php');
abstract class Table
{	
	
	protected $database;
	protected $table;
	public static $asc = 'ASC';
	public static $desc = 'DESC';
	
	abstract protected function allFields();
	
	abstract protected function getSortColArray();
	//abstract protected function getSortOrdArray();
	abstract protected function getOffset($data);
	
	abstract protected function selectValidation($data);
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
	
	public function delete($where)
	{
		if (!$where){
			printf("Nothing to delete...");
		}else{
			//echo "<pre>", var_dump($where), "</pre>";	//temporary line...
			$query = "DELETE FROM ".$this->table." WHERE ".$this->getWhere($where);
			if ($res = $this->query($query)){
				printf("Deleted ".$res." record(s).");	//temporary line...
			}else{
				printf("ERROR deleting record(s).");	//temporary line...
			};
		};
	}
	
	protected function makeInsertQuery($data)	// used by method `insert`...
	{
		$result = " (";
		$data['allFields'] = array_merge(array_diff($data['allFields'], array("id")));	//without "id" field...	
		$result .= join(', ', $data['allFields']);
		$result .= ") VALUES ('";
		$temp =[];
		/*
			$result = [];
			while ($row = $res->fetch_assoc()){
				array_push($result, $row);
			};
			
		foreach ($whereArray as $key => $val){
			$temp = $key . "='" . $whereArray[$key] ."'";
			array_push($tempArray, $temp);
		};
		*/
		
		foreach($data['allFields'] as $key => $val){
			array_push($temp, $data[$data['allFields'][$key]]);
		};
		$result .= join("', '", $temp);
		$result .= "')";
		return $result;
	}
	
	public function insert($data)
	{
		$data['allFields'] = $this->allFields();
		
		$query = "INSERT INTO ".$this->table.$this->makeInsertQuery($data);
		
		if ($res = $this->query($query)){
			printf("Inserted ".$res." record(s).");	//temporary line...
		}else{
			printf("ERROR inserting record(s).");	//temporary line...
		};
		
	}
	
	protected function makeWhere($where)
	{
		$result = [];
		$globalKey = "";
		foreach ($where as $key => $val){
			if (($key != "AND") 
					&& ($key != "OR") 
					&& ($key != "NOT")){
				foreach ($where as $key2 => $val2){
					if ($key == "NOT"){
						array_push($result, "NOT ".$key2."='".$val2."'");
					}else{
						array_push($result, $key2."='".$val2."'");
					};
				};
				return "(".join(' AND ', $result).")";
			}else{
				$globalKey = $key;
				array_push($result, $this->makeWhere($where[$key]));
			};
		};
		return "(".join($globalKey, $result).")";
	}

	//	input data: $data['fields'], $data['sortCol'], $data['sortOrd'],
	//				$data['page'], $data'[limit'], $data['where']
	public function select($data)
	{
		if ((!isset($data['page'])) && (!isset($data['limit']))){
			$data['page'] = 1;
			$data['limit'] = $this->selectCount();
		};
		
		$data['offset'] = $this->getOffset($data);
		
		$data = $this->selectValidation($data);
	
		// making WHERE... part
		$_where = (isset($data['where'])) ? $this->makeWhere($data['where']) : 1;
		
		$query = sprintf(
			"SELECT %s FROM %s WHERE %s ORDER BY %s %s LIMIT %d, %d",
			$data['fields'], $this->table, $_where,
			$data['sortCol'], $data['sortOrd'],
			$data['offset'], $data['limit']);
		
		//echo "<pre>", var_dump($query), "</pre>";	//temporary line...
		
		$res = $this->query($query);
		echo "<pre>", var_dump($res), "</pre>";	//temporary line...
	}
	
	public function selectCount($where = 1)
	{
		$_where = ($where == 1) 
			? $where
			: makeWhere($where);

		//$query = "SELECT COUNT(*) AS countedFields FROM ".$this->table;

		$query = sprintf("SELECT COUNT(*) AS countedFields FROM ".$this->table." WHERE %s", $_where);

		if ($this->query($query)){
			$result = $this->getArray();
			return $result[0]['countedFields'];
		};
	}
	
	private function makeUpdateQuery($data)	// used by method `update`...
	{
		$data['allFields'] = array_merge(array_diff($data['allFields'], array("id")));	//without "id" field...	
		
		$temp = [];
		
		foreach($data['allFields'] as $key => $val){
			$tempString = $data['allFields'][$key]."='".$data[$data['allFields'][$key]]."'";
			array_push($temp, $tempString);
		};
		return join(", ", $temp);
	}
	
	public function update($data, $where)
	{
		$data['allFields'] = $this->allFields();
		
		$query = "UPDATE ".$this->table." SET ".$this->makeUpdateQuery($data)." WHERE ".$where;
		if ($res = $this->query($query)){
			printf("Updated ".$res." record(s).");	//temporary line...
		}else{
			printf("ERROR updating record(s).");	//temporary line...
		};
	}
	
	protected function query($query)
	{ 
		return $this->database->query($query);
	}
	
	protected function getArray()
	{
		return $this->database->getArray();
	}
	
	protected function getLastInsertId()
	{
		return $this->database->getLastInsertId();
	}
	
	protected function getNumRows()
	{
		return $this->database->getNumRows();
	}
}
// cakephp framework...
