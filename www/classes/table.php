<?php

abstract class Table
{
	
	abstract public function delete($contactId);
	
	abstract public function insert($contactId);
	
	abstract public function select($toSelect);
	
	abstract public function update($contactId);

}

// cakephp framework...
