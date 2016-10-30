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
	
	protected function makeInsertQuery($data)	// used by method `insert`...
	{
		$result = "(";
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
	
		// radioButton validation...
		if (empty($data['best_phone'])){
			$validRes['res'] = false;
			$validRes['message'] = "Please choose 'best phone number'!!!";
			return $validRes;
		};
		
		return $validRes;
		
		//echo "<pre>", var_dump($requiredField), "</pre>";	//temporary line...
		//echo "<pre>", var_dump($this->fields), "</pre>";	//temporary line...
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
			return "Inserted ".$res." record(s).";
		}else{
			return "ERROR inserting record(s).";
		};
		
	}

	private function arrayKeySearch($array, $key)
	{
		return array_key_exists($key, $array) ? true : false;
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
		//echo "<pre>", var_dump($res), "</pre>";	//temporary line...
		return $res;
	}
	
	public function selectCount($where = 1)
	{
		$_where = ($where == 1) 
			? $where
			: $this->makeWhere($where);

		$query = sprintf("SELECT COUNT(*) AS countedFields FROM ".$this->table." WHERE %s", $_where);

		if ($result = $this->query($query)){
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
		return join(", ", $temp);	//JxOcWG6PNu
	}
	
	public function update($data, $where)
	{
		$data['allFields'] = $this->allFields();
		
		$query = "UPDATE ".$this->table." SET ".$this->makeUpdateQuery($data)." WHERE ".$where;
		if ($res = $this->query($query)){
			return "Updated ".$res." record(s).";
		}else{
			return "ERROR updating record(s).";
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
