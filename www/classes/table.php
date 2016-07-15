<?php

abstract class Table
{	
	abstract public function delete($where);
	
	abstract public function insert($data);
	
	abstract public function select($data);
	
	abstract public function update($data, $where);
	
	protected function makeWhere($whereArray)
	{
		$tempArray = [];
		foreach ($whereArray as $key => $val){
			$temp = $key . "='" . $whereArray[$key] ."'";
			array_push($tempArray, $temp);
		};
		return $tempArray;
	}
	
	protected function getWhere($data)	// used by method `select`...
	{
		if (!isset($data['whereAndChoise']) && !isset($data['whereOrChoise'])){
			return "1";
		};
		
		$result = "";
		if (isset($data['whereAndChoise'])){
			$result = join(' AND ', $this->makeWhere($data['whereAndChoise']));
		};
		
		if (isset($data['whereAndChoise']) && isset($data['whereOrChoise'])){
			$result .= " AND ";
		};
		
		if (isset($data['whereOrChoise'])){
			$result .= "( ";
			$result .= join(' OR ', $this->makeWhere($data['whereOrChoise']));
			$result .= " )";
		};		
		
		return $result;
	}

	protected function getOffset($data)	// used by method `select`...
	{
		if (!isset($data['page']) || $data['page'] <= 1){
			return 0;
		};
		$offset = ($data['page']*$data['limit'])-$data['limit'];
				
		$allContacts = $this->selectCount();
		
		// check URL variable "activePage" if correct...getOffset
		if ($offset > $allContacts){
			return 0;
		};
		
		return $offset;
	}

}

// cakephp framework...
