<?php

interface dbInterface{

	public function connect();
	
	public function disconnect();
	
	public function query($query);
	
	public function getLastInsertId();
	
	public function getArray();
	
	public function getLastQuery();
	
	public function prepare();

}
