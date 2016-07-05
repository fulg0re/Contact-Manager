<?php

abstract class Table
{
	
	abstract public function delete($where);
	
	abstract public function insert($data);
	
	abstract public function select($fields, $asParam, $where, $sort_col, $sort_ord, $page, $limit);
	
	abstract public function update($data, $where);

}

// cakephp framework...
