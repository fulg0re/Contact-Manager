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
				return "Errormessage: %s\n"/*.$this->error*/;
			};
		};
	}

	private function isEmail($data, $key)
	{
		if (!filter_var($data[$key], $this->fields[$key]['rule'])) {
			$res['message'] = $this->fields[$key]['ruleMessage'];
			return $res;
		};
	}

	private function isPhone($data, $key)
	{
		foreach($this->fields[$key] as $phoneKey => $phoneVal){

			// phone validation for empty...
			if ($phoneKey == 'isNotEmpty'){
				$notEmpty = 0;

				foreach($phoneVal['phoneNames'] as $phoneNameKey => $phoneNameVal){
					if (!empty($data[$phoneNameKey])){
						$notEmpty++;
					};
				};

				if ($phoneVal['rule'] == 'one'){
					if ($notEmpty == 0){
						$res['message'] = $phoneVal['message'];
						return $res;
					}
				}else{	//if ($phoneVal['rule'] == 'all')
					if ($notEmpty < count($phoneVal['phoneNames'])){
						$res['message'] = $phoneVal['message'];
						return $res;
					}
				};
			};

			// radiobutton-phone validation...
			if ($phoneKey == 'best_phone'){
				if ($phoneVal['rule'] == 'compare'
					&& empty($data[$data[$phoneKey]])){

					$res['message'] = $phoneVal['message'];
					return $res;
				};
			};
		};
	}

	private function insertValidation($data)
	{
		$validRes = [
			'res' => false,
			'message'=>''
		];

		//fields validation(check for requird fields)...
		foreach($this->fields as $key => $val){
			
			foreach($this->fields[$key] as $key2 => $val2){

				// required fields validation...
				if ($key == 'phone'){

					// phone validation is lower...

				}elseif (($key2 == "required") 
						&& ($val2 == true) 
						&& (!isset($data[$key]))
						|| (empty($data[$key]))){

					$validRes['message'] = $this->fields[$key]['message'];
					return $validRes;
				};

				// email validation...
				if ($key == 'email'){
					$res = $this->isEmail($data, $key);
					if (isset($res['message'])){
						$validRes['message'] = $res['message'];
						return $validRes;
					};
				};

				// phone validation...
				if ($key == 'phone'){

					$res = $this->isPhone($data, $key);
					if (isset($res['message'])){
						$validRes['message'] = $res['message'];
						return $validRes;
					};
				};
			};
		};

		$validRes['res'] = true;		
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
			return "Errormessage: %s\n"/*.$this->error*/;
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
		
		if ($res = $this->query($query)){
			return $res;
		}else{
			return "Errormessage: %s\n"/*.$this->error*/;
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
		$validRes = $this->insertValidation($data);
		if ($validRes['res'] == false){
			return $validRes['message'];
		};

		$data['allFields'] = $this->allFields();
		
		$query = "UPDATE ".$this->table." SET ".$this->makeUpdateQuery($data)." WHERE ".$where;
		if ($res = $this->query($query)){
			return $res;
		}else{
			return "Errormessage: %s\n"/*.$this->error*/;
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