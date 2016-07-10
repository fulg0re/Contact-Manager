<?php

abstract class Table
{	
	abstract public function delete($where);
	
	abstract public function insert($data);
	
	abstract public function select($data);
	
	abstract public function update($data, $where);
	
	protected function getWhere($data)	// used by method `select`...
	{
		if (!isset($data['where'])){
			return "1";
		};
		
		$tempArray = array();
		foreach ($data['where'] as $key => $val){
			$tempArray[$key] = $key . "=" . $data['where'][$key];
		};
		return join(' '.$data['whereChoise'].' ', $tempArray);
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
