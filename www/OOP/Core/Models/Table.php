<?php

namespace Core\Models;

include_once('../App/config.php');
include_once('MysqlDriver.php');

abstract class Table
{	
	
	protected $database;
	protected $table;
	protected $modelObj;
	public static $asc = 'ASC';
	public static $desc = 'DESC';
	
	abstract protected function allFields();
	
	abstract protected function getSortColArray();
	
	abstract protected function getOffset($data);
	
	abstract protected function selectValidation($data);

	function __construct()
	{
		$this->database = new MysqlDriver(DB_HOST, DB_USER,	DB_PASSWORD, DB_NAME);
	}
/*
	function __construct($database, $table)
	{
		if (isset($database) && isset($table)){
			$this->database = new MysqlDriver(
				$database['host'], 
				$database['user'], 
				$database['password'], 
				$database['dbName']);
			$this->table = $table;
		}else{
			printf("Please enter all parameters!(database and table)...");	//temporary line...
		};
	}
	*/
	public function delete($where)
	{
		if (!$where){
			return "Nothing to delete...";
		}else{
			//echo "<pre>", var_dump($where), "</pre>";	//temporary line...
			$query = "DELETE FROM ".$this->table." WHERE ".$this->makeWhere($where);
			if ($res = $this->query($query)){
				return "Deleted ".$res." record(s).";
			}else{
				return "ERROR deleting record(s).";
			};
		};
	}

	private function insertValidation($data)
	{
		$validRes = [
			'res' => true,
			'message'=>''
		];

		//fields validation(check for requird fields)...
		foreach($this->fields as $key => $val){
			foreach($this->fields[$key] as $key2 => $val2){
				if (($key2 == "required") 
						&& ($val2 == true) 
						&& (!isset($data[$key]))
						|| (empty($data[$key]))){

					$validRes['res'] = false;
					$validRes['message'] = $this->fields[$key]['message'];
					return $validRes;
				};
			};
		};

		// email validation...
		if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$validRes['res'] = false;
			$validRes['message'] = "Wrong \"email\" format!!!";
			return $validRes;
		};

		// phone validation for empty...
		if (empty($data['home_phone']) 
			&& empty($data['work_phone']) 
			&& empty($data['cell_phone'])){
			
			$validRes['res'] = false;
			$validRes['message'] = "Please enter etleast one phone number!!!";
			return $validRes;
		};

		// radiobutton-phone validation...
		if (empty($data[$data['best_phone']])){
			$validRes['res'] = false;
			$validRes['message'] = "Selected phone number is empty!!!";
			return $validRes;
		}
	
		// radioButton validation...
		if (empty($data['best_phone'])){
			$validRes['res'] = false;
			$validRes['message'] = "Please choose 'best phone number'!!!";
			return $validRes;
		};
		
		return $validRes;
		
		//echo "<pre>", var_dump($this->fields), "</pre>";	//temporary line...
	}
	
	protected function makeInsertQuery($data)	// used by method `insert`...
	{
		$result = "(";
		$data['allFields'] = array_merge(array_diff($data['allFields'], array("id")));	//without "id" field...	
		$result .= join(', ', $data['allFields']);
		$result .= ") VALUES ('";
		$temp =[];

		foreach($data['allFields'] as $key => $val){
			array_push($temp, $data[$data['allFields'][$key]]);
		};
		$result .= join("', '", $temp);
		$result .= "')";
		return $result;
	}
	
	public function insert($data)
	{
		$validRes = $this->insertValidation($data);
		if ($validRes['res'] == false){
			return $validRes['message'];
		};

		$data['allFields'] = $this->allFields();
		
		$query = "INSERT INTO ".$this->table." ".$this->makeInsertQuery($data);
		
		if ($res = $this->query($query)){
			return $res;
		}else{
			return "ERROR inserting record(s).";
		};
		
	}

	private function arrayKeySearch($array, $key)
	{
		if (array_key_exists($key, $array)){
			return true;
		};
		return false;
	}
	
	protected function makeWhere($where)
	{
		$result = [];
		$globalKey = "";
		foreach ($where as $key => $val){
			if ((!$this->arrayKeySearch($where, "AND")) 
					&& (!$this->arrayKeySearch($where, "OR")) 
					&& (!$this->arrayKeySearch($where, "NOT"))){
				foreach ($where as $key2 => $val2){
					if ($this->arrayKeySearch($where, "NOT")){
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
		$data['offset'] = $this->getOffset($data);
		
		$data = $this->selectValidation($data);
	
		// making WHERE... part
		if (isset($data['where'])){
			$_where = $this->makeWhere($data['where']);
		}else{
			$_where = 1;
		};
		
		$query = sprintf(
			"SELECT %s FROM %s WHERE %s ORDER BY %s %s LIMIT %d, %d",
			$data['fields'], $this->table, $_where,
			$data['sortCol'], $data['sortOrd'],
			$data['offset'], $data['limit']);
		
		//echo "<pre>", var_dump($query), "</pre>";	//temporary line...
		
		$res = $this->query($query);
		//echo "<pre>", var_dump($res), "</pre>";	//temporary line...
		return $res;
	}
	
	private function makeUpdateQuery($data)	// used by method `update`...
	{
		$data['allFields'] = array_merge(array_diff($data['allFields'], array("id")));	//without "id" field...	
		
		$temp = [];
		
		foreach($data['allFields'] as $key => $val){
			$tempString = $data['allFields'][$key]."='".$data[$data['allFields'][$key]]."'";
			array_push($temp, $tempString);
		};
		return join(", ", $temp);	//JxOcWG6PNu
	}
	
	public function update($data, $where)
	{
		$validRes = $this->insertValidation($data);
		if ($validRes['res'] == false){
			return $validRes['message'];
		};

		$data['allFields'] = $this->allFields();
		
		$query = "UPDATE ".$this->table." SET ".$this->makeUpdateQuery($data)." WHERE ".$where;
		if ($res = $this->query($query)){
			return $res;
		}else{
			//return "ERROR updating record(s).";
			return "Record(s) has not been changed!";
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